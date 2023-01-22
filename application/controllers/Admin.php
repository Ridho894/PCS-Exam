<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/Firebase/JWT/JWT.php';

use \Firebase\JWT\JWT;



class Admin extends CI_Controller
{
    private $secret_key = 'z9lwock9tjd7fa5i9Ov5bMRyWVNL9Dui';

    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_admin');
    }

    public function index()
    {
        $this->cekToken();
        $admin = $this->M_admin->getAdmin();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $admin
        );
        echo json_encode($data_json);
    }

    // Create
    public function admin_post()
    {
        // $this->cekToken();
        $validation_message = [];

        if ($this->input->post("email") == "") {
            array_push($validation_message, "Email cannot be empty");
        }

        if ($this->input->post("email") != "" && !filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
            array_push($validation_message, "Email not valid");
        }

        if ($this->input->post("password") == "") {
            array_push($validation_message, "Password cannot be empty");
        }

        if ($this->input->post("nama") == "") {
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
            "email" => $this->input->post("email"),
            "password" => md5($this->input->post("password")),
            "nama" => $this->input->post("nama"),
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
    public function admin_put()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("email") == "") {
            array_push($validation_message, "Email cannot be empty");
        }

        if ($this->input->post("email") != "" && !filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
            array_push($validation_message, "Email not valid");
        }

        if ($this->input->post("password") == "") {
            array_push($validation_message, "Password cannot be empty");
        }

        if ($this->input->post("nama") == "") {
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
            "email" => $this->input->post("email"),
            "password" => md5($this->input->post("password")),
            "nama" => $this->input->post("nama"),
        );

        $id = $this->input->post("id");

        $result = $this->M_admin->updateAdmin($data, $id);
        $data_json = array(
            'success' => true,
            "message" => "Update Data Success",
            "data" => array(
                "admin" => $result
            )
        );
        echo json_encode($data_json);
    }

    // Delete
    public function admin_delete()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("id") == "") {
            array_push($validation_message, "ID Admin cannot be empty");
        }

        $id = $this->input->post("id");
        $result = $this->M_admin->deleteAdmin($id);
        if (empty($result)) {
            $data_json = array(
                'success' => false,
                "message" => "Id is Invalid",
            );
            echo json_encode($data_json);
            $this->output->_display();
            exit();
        }
        $this->db->delete("admin", array("id" => $id));
        $data_json = array(
            'success' => true,
            "message" => "Delete Success",
        );
        echo json_encode($data_json);
    }

    public function login_post()
    {
        $data = array(
            "email" => $this->input->post("email"),
            "password" => md5($this->input->post("password")),
        );

        $result = $this->M_admin->cekLoginAdmin($data);

        if (empty($result)) {

            $data_json = array(
                'success' => false,
                "message" => "Email & Password Invalid",
                "error_code" => 1308
            );
            echo json_encode($data_json);
            $this->output->_display();
            exit();
        } else {
            $date = new DateTime();
            $payload["id"] = $result["id"];
            $payload["email"] = $result["email"];
            $payload["iat"] = $date->getTimestamp();
            $payload["exp"] = $date->getTimestamp() * 3600;

            $data_json = array(
                "success" => true,
                "message" => "Authentication Success",
                "data" => array(
                    "admin" => $result,
                    "token" => JWT::encode($payload, $this->secret_key)
                )
            );
            echo json_encode($data_json);
        }
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
