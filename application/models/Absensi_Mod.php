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

    public function get_keb_pkt($tgl, $id_jadwal)
    {
        $this->db->where('id_jdwlabnsi', $id_jadwal);
        $this->db->where('tanggal', $tgl);
        $this->db->where('ket_keberadaan', 'piket kantor');
        return $this->db->get('absensi')->result();
    }

    public function get_keb_wfh($tgl, $id_jadwal)
    {
        $this->db->where('id_jdwlabnsi', $id_jadwal);
        $this->db->where('tanggal', $tgl);
        $this->db->where('ket_keberadaan', 'wfh');
        return $this->db->get('absensi')->result();
    }

    public function get_keb_izn($tgl, $id_jadwal)
    {
        $this->db->where('id_jdwlabnsi', $id_jadwal);
        $this->db->where('tanggal', $tgl);
        $this->db->where('ket_keberadaan', 'izin (sakit/cuti)');
        return $this->db->get('absensi')->result();
    }

    public function get_all_absensi($length = "", $start = "", $order = "", $dir = "", $search = "")
    {
        $tgl = date("Y-m-d");
        $this->db->order_by($order, $dir);
        $this->db->order_by('fullname', 'asc');
        $this->db->like('fullname', $search);
        $this->db->or_like('tanggal', $search);
        $this->db->or_like('ket_keberadaan', $search);
        $this->db->limit($length, $start);
        $this->db->where('tanggal', $tgl);
        return $this->db->from('absensi')
            ->join('user', 'user.id=absensi.id')
            ->get()
            ->result();
    }

    public function get_all_absensi_count()
    {
        return $this->db->count_all_results('absensi');
    }
}
