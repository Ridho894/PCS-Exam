<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Item_Transaction extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_item_transaksi');
    }

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
}
