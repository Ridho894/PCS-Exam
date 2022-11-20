<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
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

    // Create
    public function transaction_post()
    {
        $validation_message = [];

        if ($this->input->get("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->get("admin_id") != "" && !$this->M_transaction->cekTransactionExist($this->input->get("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }

        if ($this->input->get("total") == "") {
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
            "admin_id" => $this->input->get("admin_id"),
            "total" => $this->input->get("total"),
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
        $validation_message = [];

        if ($this->input->get("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->get("admin_id") != "" && !$this->M_transaction->cekAdminIdTransactionExist($this->input->get("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }

        if ($this->input->get("total") == "") {
            array_push($validation_message, "Total cannot be empty");
        }

        if ($this->input->get("id") == "") {
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
            "admin_id" => $this->input->get("admin_id"),
            "total" => $this->input->get("total"),
        );

        $id = $this->input->get("id");

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
        $validation_message = [];

        if ($this->input->get("id") == "") {
            array_push($validation_message, "ID Product cannot be empty");
        }

        if ($this->input->get("id") != "" && !$this->M_transaction->cekTransactionExist($this->input->get("id"))) {
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

        $this->db->delete("transaksi", array("id" => $this->input->get("id")));
        $data_json = array(
            'success' => true,
            "message" => "Delete Transaction Success",
        );

        echo json_encode($data_json);
    }
}
