<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi_Mod extends CI_Model
{
    public function get_jadwal_absensi()
    {
        if (date("l") == "Friday") {
            $id_jadwal = 2;
        } else {
            $id_jadwal = 1;
        }
        $data =  $this->db->get_where('jadwal_absensi', ['id_jdwlabnsi' => $id_jadwal])->row();
        return $data;
    }

    public function cek_absensiMasuk($id_jdwlabnsi, $id, $tgl)
    {
        $this->db->where('id_jdwlabnsi', $id_jdwlabnsi);
        $this->db->where('tanggal', $tgl);
        $this->db->where('id', $id);
        return $this->db->get('absensi')->row();
    }

    public function add_absensi($data)
    {
        $this->db->insert('absensi', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cek_absensikeluar($id, $tgl)
    {
        $this->db->where('tanggal', $tgl);
        $this->db->where('id', $id);
        return $this->db->get('absensi')->row();
    }

    public function update_absensi($id, $data)
    {
        $this->db->where('id_absensi', $id);
        $this->db->update('absensi', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
