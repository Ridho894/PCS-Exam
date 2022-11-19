<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Transaction extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTransaction()
    {
        $query = $this->db->get('transaksi');
        return $query->result_array();
    }
}
