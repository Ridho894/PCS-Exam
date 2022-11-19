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

    public function insertTransaction($data)
    {
        $this->db->insert('transaksi', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('transaksi', array('id' => $insert_id));

        return $result->row_array();
    }
}
