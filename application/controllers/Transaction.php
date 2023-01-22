<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/Firebase/JWT/JWT.php';

use \Firebase\JWT\JWT;
use Restserver\Libraries\REST_Controller;

class Transaction extends CI_Controller
{
    private $secret_key = 'z9lwock9tjd7fa5i9Ov5bMRyWVNL9Dui';

    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_transaction');
    }

    // Get All Data
    public function index()
    {
        $transaksi = $this->M_transaction->getTransaction();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $transaksi
        );
        echo json_encode($data_json);
    }

    // Get data by month
    public function transaction_this_month()
    {
        $this->cekToken();
        $transaksi = $this->M_transaction->getItemTransactionThisMonth();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $transaksi
        );
        echo json_encode($data_json);
    }

    // Create
    public function transaction_post()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->post("admin_id") != "" && !$this->M_transaction->cekTransactionExist($this->input->post("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }

        if ($this->input->post("total") == "") {
            array_push($validation_message, "Total cannot be empty");
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
            "admin_id" => $this->input->post("admin_id"),
            "total" => $this->input->post("total"),
            'tanggal' => date("Y-m-d H:i:s"),
        );

        $result = $this->M_transaction->insertTransaction($data);
        $data_json = array(
            'success' => true,
            "message" => "Insert Transaction Success",
            "data" => array(
                "transaction" => $result
            )
        );

        echo json_encode($data_json);
    }

    // Update
    public function transaction_put()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->post("admin_id") != "" && !$this->M_transaction->cekAdminIdTransactionExist($this->input->post("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }

        if ($this->input->post("total") == "") {
            array_push($validation_message, "Total cannot be empty");
        }

        if ($this->input->post("id") == "") {
            array_push($validation_message, "Id cannot be empty");
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
            "admin_id" => $this->input->post("admin_id"),
            "total" => $this->input->post("total"),
        );

        $id = $this->input->post("id");

        $result = $this->M_transaction->updateTransaction($data, $id);
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
    public function transaction_delete()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("id") == "") {
            array_push($validation_message, "ID Product cannot be empty");
        }

        if ($this->input->post("id") != "" && !$this->M_transaction->cekTransactionExist($this->input->post("id"))) {
            array_push($validation_message, "Transaction not found");
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

        $this->db->delete("transaksi", array("id" => $this->input->post("id")));
        $data_json = array(
            'success' => true,
            "message" => "Delete Transaction Success",
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
