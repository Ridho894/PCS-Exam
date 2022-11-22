<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/Firebase/JWT/JWT.php';

use \Firebase\JWT\JWT;
use Restserver\Libraries\REST_Controller;

class Item_Transaction extends CI_Controller
{
    private $secret_key = 'z9lwock9tjd7fa5i9Ov5bMRyWVNL9Dui';
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_item_transaksi');
    }

    // Get All
    public function index()
    {
        $product = $this->M_item_transaksi->getItemTransaction();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $product
        );
        echo json_encode($data_json);
    }

    // Get Data By Id Transaction
    public function item_transaction_get_by_id()
    {
        $transaksi_id = $this->input->get("transaksi_id");
        $product = $this->M_item_transaksi->getItemTransactionById($transaksi_id);
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $product
        );
        echo json_encode($data_json);
    }

    // Create
    public function item_transaction_post()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->get("transaksi_id") == "") {
            array_push($validation_message, "Transaksi Id cannot be empty");
        }

        if ($this->input->get("transaksi_id") != "" && !is_numeric($this->input->get("transaksi_id"))) {
            array_push($validation_message, "Transaksi Id must be a number");
        }

        if ($this->input->get("produk_id") == "") {
            array_push($validation_message, "Product Id cannot be empty");
        }

        if ($this->input->get("produk_id") != "" && !is_numeric($this->input->get("produk_id"))) {
            array_push($validation_message, "Product Id must be a number");
        }

        if ($this->input->get("qty") == "") {
            array_push($validation_message, "Quantity cannot be empty");
        }

        if ($this->input->get("qty") != "" && !is_numeric($this->input->get("qty"))) {
            array_push($validation_message, "Quantity must be a number");
        }

        if ($this->input->get("harga_saat_transaksi") == "") {
            array_push($validation_message, "Harga Saat Transaksi cannot be empty");
        }

        if ($this->input->get("harga_saat_transaksi") != "" && !is_numeric($this->input->get("harga_saat_transaksi"))) {
            array_push($validation_message, "Harga Saat Transaksi must be a number");
        }

        if ($this->input->get("sub_total") == "") {
            array_push($validation_message, "Sub Total cannot be empty");
        }

        if ($this->input->get("sub_total") != "" && !is_numeric($this->input->get("sub_total"))) {
            array_push($validation_message, "Sub Total must be a number");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                'success' => false,
                "message" => "Insert Data Failed",
                "data" => $validation_message
            );

            echo json_encode($data_json);
            $this->output->_display();
            exit();
        }
        $data = array(
            "transaksi_id" => $this->input->get("transaksi_id"),
            "produk_id" => $this->input->get("produk_id"),
            "qty" => $this->input->get("qty"),
            "sub_total" => $this->input->get("sub_total"),
            "harga_saat_transaksi" => $this->input->get("harga_saat_transaksi"),
        );

        $result = $this->M_item_transaksi->insertItemTransaction($data);
        $data_json = array(
            'success' => true,
            "message" => "Insert Data Success",
            "data" => array(
                "transaction" => $result
            )
        );

        echo json_encode($data_json);
    }

    // Update
    public function item_transaction_put()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->get("transaksi_id") == "") {
            array_push($validation_message, "Transaksi Id cannot be empty");
        }

        if ($this->input->get("transaksi_id") != "" && !is_numeric($this->input->get("transaksi_id"))) {
            array_push($validation_message, "Transaksi Id must be a number");
        }

        if ($this->input->get("produk_id") == "") {
            array_push($validation_message, "Product Id cannot be empty");
        }

        if ($this->input->get("produk_id") != "" && !is_numeric($this->input->get("produk_id"))) {
            array_push($validation_message, "Product Id must be a number");
        }

        if ($this->input->get("qty") == "") {
            array_push($validation_message, "Quantity cannot be empty");
        }

        if ($this->input->get("qty") != "" && !is_numeric($this->input->get("qty"))) {
            array_push($validation_message, "Quantity must be a number");
        }

        if ($this->input->get("harga_saat_transaksi") == "") {
            array_push($validation_message, "Harga Saat Transaksi cannot be empty");
        }

        if ($this->input->get("harga_saat_transaksi") != "" && !is_numeric($this->input->get("harga_saat_transaksi"))) {
            array_push($validation_message, "Harga Saat Transaksi must be a number");
        }

        if ($this->input->get("sub_total") == "") {
            array_push($validation_message, "Sub Total cannot be empty");
        }

        if ($this->input->get("sub_total") != "" && !is_numeric($this->input->get("sub_total"))) {
            array_push($validation_message, "Sub Total must be a number");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                'success' => false,
                "message" => "Update Data Failed",
                "data" => $validation_message
            );

            echo json_encode($data_json);
            $this->output->_display();
            exit();
        }
        $data = array(
            "transaksi_id" => $this->input->get("transaksi_id"),
            "produk_id" => $this->input->get("produk_id"),
            "qty" => $this->input->get("qty"),
            "sub_total" => $this->input->get("sub_total"),
            "harga_saat_transaksi" => $this->input->get("harga_saat_transaksi"),
        );

        $id = $this->input->get("id");

        $result = $this->M_item_transaksi->updateItemTransaction($data, $id);
        $data_json = array(
            'success' => true,
            "message" => "Update Data Success",
            "data" => array(
                "transaction" => $result
            )
        );

        echo json_encode($data_json);
    }

    // Delete
    public function item_transaction_delete()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->get("id") == "") {
            array_push($validation_message, "ID Item Transaction cannot be empty");
        }

        if ($this->input->get("id") != "" && !$this->M_item_transaksi->cekItemTransactionExist($this->input->get("id"))) {
            array_push($validation_message, "ID Item Transaction not found");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                'success' => false,
                "message" => $validation_message[0],
            );

            echo json_encode($data_json);
            $this->output->_display();
            exit();
        }

        $this->db->delete("item_transaksi", array("id" => $this->input->get("id")));
        $data_json = array(
            'success' => true,
            "message" => "Delete Data Success",
        );

        echo json_encode($data_json);
    }

    // Delete By Transaction ID
    public function item_transaction_delete_by_id()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->get("transaksi_id") == "") {
            array_push($validation_message, "Transaksi Id cannot be empty");
        }

        if ($this->input->get("transaksi_id") != "" && !$this->M_item_transaksi->cekItemTransactionExist($this->input->get("transaksi_id"))) {
            array_push($validation_message, "Transaksi Id not found");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                'success' => false,
                "message" => $validation_message[0],
            );

            echo json_encode($data_json);
            $this->output->_display();
            exit();
        }

        $this->db->delete("item_transaksi", array("transaksi_id" => $this->input->get("transaksi_id")));
        $data_json = array(
            'success' => true,
            "message" => "Delete Data Success",
        );

        echo json_encode($data_json);
    }

    public function cekToken()
    {
        try {
            $token = $this->input->get_request_header("Authorization");
            if (!empty($token)) {
                $token = explode(' ', $token)[1];
            }
            $token_decode = JWT::decode($token, $this->secret_key, array("HS256"));
        } catch (Exception $e) {
            $data_json = array(
                'success' => false,
                "message" => "Invalid Token",
                "error_code" => 1204,
            );
            echo json_encode($data_json);
            $this->output->_display();
            exit();
        }
    }
}
