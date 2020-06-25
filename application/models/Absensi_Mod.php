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

    public function get_keb_dl($tgl, $id_jadwal)
    {
        $this->db->where('id_jdwlabnsi', $id_jadwal);
        $this->db->where('tanggal', $tgl);
        $this->db->where('ket_keberadaan', 'dl');
        return $this->db->get('absensi')->result();
    }

    public function get_all_absensi($length = "", $start = "", $order = "", $dir = "", $search = "")
    {
        $tgl = date("Y-m-d");
        $this->db->order_by($order, $dir);
        $this->db->like('ket_keberadaan', $search);
        $this->db->limit($length, $start);
        $this->db->select("*");
        $this->db->from('absensi');
        $this->db->join('user', 'user.id = absensi.id');
        $this->db->where('tanggal', $tgl);
        return $query = $this->db->get()->result();
    }

    public function get_all_absensi_count()
    {
        $tgl = date("Y-m-d");
        $this->db->where('tanggal', $tgl);
        return $this->db->count_all_results('absensi');
    }

    public function get_all_jdwl_absen()
    {
        return  $this->db->get('jadwal_absensi')->result();
    }

    public function get_absensiTody()
    {
        $tgl = date("Y-m-d");
        $this->db->select("*");
        $this->db->from('absensi');
        $this->db->where('tanggal', $tgl);
        $this->db->join('user', 'user.id = absensi.id');
        return $query = $this->db->get()->result();
    }

    public function get_absensicetakPertgl($tgl)
    {
        $this->db->select("*");
        $this->db->from('absensi');
        $this->db->where('tanggal', $tgl);
        $this->db->join('user', 'user.id = absensi.id');
        return $query = $this->db->get()->result();
    }


    public function get_all_absensi_everyday($length = "", $start = "", $order = "", $dir = "", $search = "", $where = "")
    {
        $array = array('fullname' => $search, 'ket_keberadaan' => $search, 'tanggal' => $search);
        if ($where != '') {

            $this->db->select("*");
            $this->db->from('absensi');
            $this->db->join('user', 'user.id = absensi.id');
            $this->db->where('tanggal', $where);
            $this->db->order_by($order, $dir);
            $this->db->limit($length, $start);
            $this->db->like('ket_keberadaan', $search);
            $query = $this->db->get()->result();
        } else {
            $this->db->order_by($order, $dir);
            $this->db->or_like($array);
            $this->db->limit($length, $start);
            $this->db->select("*");
            $this->db->from('absensi');
            $this->db->join('user', 'user.id = absensi.id');
            $query = $this->db->get()->result();
        }
        return $query;
    }

    public function get_all_absensi_everyday_count($where = "")
    {
        if ($where != '') {
            $this->db->where('tanggal', $where);
            $query = $this->db->count_all_results('absensi');
        } else {
            $query = $this->db->count_all_results('absensi');
        }
        return $query;
    }

    // public function get_absensi_cetakBulan($tanggal, $tanggal1)
    // {
    //     $query = "SELECT * FROM absensi WHERE tanggal between '$tanggal' AND '$tanggal1'";
    //     return  $this->db->query($query)->result();
    // }

    public function get_count_wfhperid($id, $tanggal, $tanggal1)
    {
        $query = "SELECT * FROM absensi WHERE id=$id AND ket_keberadaan='wfh' AND tanggal between '$tanggal' AND '$tanggal1'";
        return  $this->db->query($query)->result();
    }

    public function get_count_pktperid($id, $tanggal, $tanggal1)
    {
        $query = "SELECT * FROM absensi WHERE id=$id AND ket_keberadaan='piket kantor' AND tanggal between '$tanggal' AND '$tanggal1'";
        return  $this->db->query($query)->result();
    }

    public function get_count_iznperid($id, $tanggal, $tanggal1)
    {
        $query = "SELECT * FROM absensi WHERE id=$id AND ket_keberadaan='izin (sakit/cuti)' AND tanggal between '$tanggal' AND '$tanggal1'";
        return  $this->db->query($query)->result();
    }

    public function get_count_dlperid($id, $tanggal, $tanggal1)
    {
        $query = "SELECT * FROM absensi WHERE id=$id AND ket_keberadaan='dl' AND tanggal between '$tanggal' AND '$tanggal1'";
        return  $this->db->query($query)->result();
    }



    public function get_all_absensi_userid($length = "", $start = "", $order = "", $dir = "", $search = "", $where = "", $id_user="")
    {
        $array = array('ket_keberadaan' => $search, 'tanggal' => $search);
        if ($where != '') {

            $this->db->select("*");
            $this->db->from('absensi');
            $this->db->join('user', 'user.id = absensi.id');
            $this->db->order_by($order, $dir);
            $this->db->like('ket_keberadaan', $search);
            $this->db->limit($length, $start);
            $this->db->where('tanggal', $where);
            $this->db->where('absensi.id', $id_user);    
            $query = $this->db->get()->result();
        } else {
            $this->db->select("*");
            $this->db->from('absensi');
            $this->db->join('user', 'user.id = absensi.id');
            $this->db->order_by($order, $dir);
             $this->db->like('ket_keberadaan', $search);
            $this->db->limit($length, $start);
            $this->db->where('absensi.id', $id_user);
            $query = $this->db->get()->result();
        }
        return $query;
    }

    public function get_all_absensi_userid_count($where = "", $id_user="")
    {
        if ($where != '') {
            $this->db->where('tanggal', $where);
            $this->db->where('id', $id_user);
            $query = $this->db->count_all_results('absensi');
        } else {
            $this->db->where('id', $id_user);
            $query = $this->db->count_all_results('absensi');
        }
        return $query;
    }
}
