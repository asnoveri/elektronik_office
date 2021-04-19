<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LookbookMod extends CI_Model
{
    public function get_all_lookbook($length = "", $start = "", $order = "", $dir = "", $search = "", $where = "")
    {
        $array = array('fullname' => $search, 'tanggal' => $search, 'unitkerja'=>$search);
        if ($where != '') {

            $this->db->select("*");
            $this->db->from('t_lookbook');
            $this->db->join('user', 'user.id = t_lookbook.id');
            $this->db->join('unit_kerja', 'unit_kerja.id_unitkerja = t_lookbook.id_unitkerja');
            $this->db->where('tanggal', $where);
            $this->db->order_by($order, $dir);
            $this->db->limit($length, $start);
            $this->db->like('fullname', $search);
            $query = $this->db->get()->result();
        } else {
            $this->db->order_by($order, $dir);
            $this->db->or_like($array);
            $this->db->limit($length, $start);
            $this->db->select("*");
            $this->db->from('t_lookbook');
            $this->db->join('user', 'user.id = t_lookbook.id');
            $this->db->join('unit_kerja', 'unit_kerja.id_unitkerja = t_lookbook.id_unitkerja');
            $query = $this->db->get()->result();
        }
        return $query;
    }

    public function get_all_lookbook_count($where = "")
    {
        if ($where != '') {
            $this->db->where('tanggal', $where);
            $query = $this->db->count_all_results('t_lookbook');
        } else {
            $query = $this->db->count_all_results('t_lookbook');
        }
        return $query;
    }
}
