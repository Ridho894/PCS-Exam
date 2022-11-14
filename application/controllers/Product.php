<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    function index()
    {
        $this->load->model('M_product');
        $product = $this->M_product->getProduct();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $product
        );
        echo json_encode($data_json);
    }
}
