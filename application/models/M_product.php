<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_product extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getProduct()
    {
        $query = $this->db->get('produk');
        return $query->result_array();
    }

    public function insertProduct($data)
    {
        $this->db->insert('produk', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('produk', array('id' => $insert_id));

        return $result->row_array();
    }

    public function updateProduct($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('produk', $data);

        $result = $this->db->get_where('produk', array('id' => $id));

        return $result->row_array();
    }

    public function deleteProduct($id)
    {
        $result = $this->db->get_where('produk', array('id' => $id));

        return $result->row_array();
    }

    public function cekProductExist($id)
    {
        $data = array(
            "id" => $id
        );
        $this->db->where($data);
        $result = $this->db->get('produk');

        if (empty($result->row_array())) {
            return false;
        };

        return true;
    }
}
