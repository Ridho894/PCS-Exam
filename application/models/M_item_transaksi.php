<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_item_transaksi extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getItemTransaction()
    {
        $query = $this->db->get('item_transaksi');
        return $query->result_array();
    }

    public function insertItemTransaction($data)
    {
        $this->db->insert('item_transaksi', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('item_transaksi', array('id' => $insert_id));

        return $result->row_array();
    }

    public function updateItemTransaction($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('item_transaksi', $data);

        $result = $this->db->get_where('item_transaksi', array('id' => $id));

        return $result->row_array();
    }

    public function deleteItemTransaction($id)
    {
        $result = $this->db->get_where('item_transaksi', array('id' => $id));

        return $result->row_array();
    }

    public function cekItemTransactionExist($id)
    {
        $data = array(
            "id" => $id
        );
        $this->db->where($data);
        $result = $this->db->get('item_transaksi');

        if (empty($result->row_array())) {
            return false;
        };

        return true;
    }
}
