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

    public function transaction_post()
    {
        $validation_message = [];

        if ($this->input->get("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
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
}
