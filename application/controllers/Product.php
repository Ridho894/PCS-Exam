<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/Firebase/JWT/JWT.php';

use \Firebase\JWT\JWT;
use Restserver\Libraries\REST_Controller;

class Product extends CI_Controller
{
    private $secret_key = 'z9lwock9tjd7fa5i9Ov5bMRyWVNL9Dui';
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_product');
        $this->load->model('M_admin');
    }

    // Get All
    public function index()
    {
        $product = $this->M_product->getProduct();
        $data_json = array(
            'success' => true,
            "message" => "Data found",
            "data" => $product
        );
        echo json_encode($data_json);
    }

    // Create
    public function product_post()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->post("admin_id") != "" && !$this->M_admin->cekAdminExist($this->input->post("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }

        if ($this->input->post("nama") == "") {
            array_push($validation_message, "Nama cannot be empty");
        }

        if ($this->input->post("harga") == "") {
            array_push($validation_message, "Harga cannot be empty");
        }

        if ($this->input->post("harga") != "" && !is_numeric($this->input->post("harga"))) {
            array_push($validation_message, "Price must be a number");
        }

        if ($this->input->post("stok") == "") {
            array_push($validation_message, "Stock cannot be empty");
        }

        if ($this->input->post("stok") != "" && !is_numeric($this->input->post("stok"))) {
            array_push($validation_message, "Stock must be a number");
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
            "nama" => $this->input->post("nama"),
            "harga" => $this->input->post("harga"),
            "stok" => $this->input->post("stok"),
        );

        $result = $this->M_product->insertProduct($data);
        $data_json = array(
            'success' => true,
            "message" => "Insert Data Success",
            "data" => array(
                "product" => $result
            )
        );

        echo json_encode($data_json);
    }

    // Update
    public function product_put()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->post("admin_id") != "" && !$this->M_admin->cekAdminExist($this->input->post("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }


        if ($this->input->post("nama") == "") {
            array_push($validation_message, "Nama cannot be empty");
        }

        if ($this->input->post("id") != "" && !$this->M_product->cekProductExist($this->input->post("id"))) {
            array_push($validation_message, "Product not found");
        }

        if ($this->input->post("harga") == "") {
            array_push($validation_message, "Price cannot be empty");
        }

        if ($this->input->post("harga") != "" && !is_numeric($this->input->post("harga"))) {
            array_push($validation_message, "Price must be a number");
        }

        if ($this->input->post("stok") == "") {
            array_push($validation_message, "Stock cannot be empty");
        }

        if ($this->input->post("stok") != "" && !is_numeric($this->input->post("stok"))) {
            array_push($validation_message, "Stock must be a number");
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
            "nama" => $this->input->post("nama"),
            "harga" => $this->input->post("harga"),
            "stok" => $this->input->post("stok"),
        );

        $id = $this->input->post("id");

        $result = $this->M_product->updateProduct($data, $id);
        $data_json = array(
            'success' => true,
            "message" => "Update Data Success",
            "data" => array(
                "product" => $result
            )
        );
        echo json_encode($data_json);
    }

    // Delete
    public function product_delete()
    {
        $this->cekToken();
        $validation_message = [];

        if ($this->input->post("id") == "") {
            array_push($validation_message, "ID Product cannot be empty");
        }

        if ($this->input->post("id") != "" && !$this->M_product->cekProductExist($this->input->post("id"))) {
            array_push($validation_message, "Product not found");
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

        $this->db->delete("produk", array("id" => $this->input->post("id")));
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
