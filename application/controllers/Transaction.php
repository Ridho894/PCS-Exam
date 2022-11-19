<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_Transaction');
    }

    public function index()
    {
        $transaksi = $this->M_Transaction->getTransaction();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $transaksi
        );
        echo json_encode($data_json);
    }
}
