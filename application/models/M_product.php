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
}
