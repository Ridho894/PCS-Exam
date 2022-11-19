<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->model('M_product');
        $this->load->model('M_admin');
    }

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

    public function product_post()
    {
        $validation_message = [];

        if ($this->input->get("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->get("admin_id") != "" && !$this->M_admin->cekAdminExist($this->input->get("admin_id"))) {
            array_push($validation_message, "Admin Id not found");
        }

        if ($this->input->get("nama") == "") {
            array_push($validation_message, "Nama cannot be empty");
        }

        if ($this->input->get("harga") == "") {
            array_push($validation_message, "Harga cannot be empty");
        }

        if ($this->input->get("stok") == "") {
            array_push($validation_message, "Stok cannot be empty");
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
            "nama" => $this->input->get("nama"),
            "harga" => $this->input->get("harga"),
            "stok" => $this->input->get("stok"),
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
        $validation_message = [];

        if ($this->input->get("admin_id") == "") {
            array_push($validation_message, "Admin Id cannot be empty");
        }

        if ($this->input->get("nama") == "") {
            array_push($validation_message, "Nama cannot be empty");
        }

        if ($this->input->get("harga") == "") {
            array_push($validation_message, "Harga cannot be empty");
        }

        if ($this->input->get("stok") == "") {
            array_push($validation_message, "Stok cannot be empty");
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
            "nama" => $this->input->get("nama"),
            "harga" => $this->input->get("harga"),
            "stok" => $this->input->get("stok"),
        );

        $id = $this->input->get("id");

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
    public function product_delete($id)
    {
        if (!$this->M_product->cekProductExist($this->input->get("id"))) {

            $data_json = array(
                'success' => false,
                "message" => "Product not found",
            );
            echo json_encode($data_json);
        } else {

            $this->db->delete("produk", array("id" => $id));
            $data_json = array(
                'success' => true,
                "message" => "Delete Success",
            );
            echo json_encode($data_json);
        }
    }
}
