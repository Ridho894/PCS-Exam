<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAdmin()
    {
        $query = $this->db->get('admin');
        return $query->result_array();
    }
}
