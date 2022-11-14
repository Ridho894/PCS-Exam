<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_simple extends CI_Controller
{
    function index()
    {
        $this->load->model('M_admin');
        $admin = $this->M_admin->getAdmin();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $admin
        );
        echo json_encode($data_json);
    }
}
