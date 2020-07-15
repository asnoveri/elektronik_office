<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Log_Model extends CI_Model
{

    public function get_log_activity($length = "", $start = "", $order = "", $dir = "", $search = ""){
        $this->db->order_by($order, $dir);
        $this->db->like('fullname', $search);
        $this->db->limit($length, $start);
        $this->db->select("*");
        $this->db->from('log');
        $this->db->join('user', 'user.id = log.id_user');
        return $query = $this->db->get()->result();
    }

    public function get_log_activity_count()
    {

        return $this->db->count_all_results('log');
    }
}