<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_admin');
    }

    public function index()
    {
        $admin = $this->M_admin->getAdmin();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $admin
        );
        echo json_encode($data_json);
    }

    public function admin_post()
    {
        $validation_message = [];

        if ($this->input->get("email") == "") {
            array_push($validation_message, "Email cannot be empty");
        }

        if ($this->input->get("email") != "" && !filter_var($this->input->get("email"), FILTER_VALIDATE_EMAIL)) {
            array_push($validation_message, "Email not valid");
        }

        if ($this->input->get("password") == "") {
            array_push($validation_message, "Password cannot be empty");
        }

        if ($this->input->get("nama") == "") {
            array_push($validation_message, "Nama cannot be empty");
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
            "email" => $this->input->get("email"),
            "password" => md5($this->input->get("password")),
            "nama" => $this->input->get("nama"),
        );

        $result = $this->M_admin->insertAdmin($data);
        $data_json = array(
            'success' => true,
            "message" => "Insert Data Success",
            "data" => array(
                "admin" => $result
            )
        );

        echo json_encode($data_json);
    }

    // Update
    // public function admin_put()
    // {
    //     $validation_message = [];

    //     if ($this->put("email") == "") {
    //         array_push($validation_message, "Email cannot be empty");
    //     }

    //     if ($this->put("email") != "" && !filter_var($this->put("email"), FILTER_VALIDATE_EMAIL)) {
    //         array_push($validation_message, "Email not valid");
    //     }

    //     if ($this->put("password") == "") {
    //         array_push($validation_message, "Password cannot be empty");
    //     }

    //     if ($this->put("nama") == "") {
    //         array_push($validation_message, "Nama cannot be empty");
    //     }

    //     if (count($validation_message) > 0) {
    //         $data_json = array(
    //             'success' => false,
    //             "message" => "Insert Data Failed",
    //             "data" => $validation_message
    //         );
    //         echo json_encode($data_json);
    //         $this->output->_display();
    //         exit();
    //     }
    //     $data = array(
    //         "email" => $this->put("email"),
    //         "password" => md5($this->put("password")),
    //         "nama" => $this->put("nama"),
    //     );

    //     $id = $this->put("id");

    //     $result = $this->M_admin->updateAdmin($data, $id);
    //     $data_json = array(
    //         'success' => true,
    //         "message" => "Update Data Success",
    //         "data" => array(
    //             "admin" => $result
    //         )
    //     );
    //     echo json_encode($data_json);
    // }

    // Delete
    public function admin_delete($id)
    {
        $this->db->delete("admin", array("id" => $id));
        $data_json = array(
            'success' => true,
            "message" => "Delete Success",
        );
        echo json_encode($data_json);
    }
}
