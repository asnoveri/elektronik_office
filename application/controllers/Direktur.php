<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Direktur extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("login_Mod");
        $this->load->model("absensi_Mod");
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index($param = "")
    {
        if ($param == 'add_absensi') {
            $id_jdwlabnsi = $this->input->post('id_jdwlabnsi', true);
            $id = $this->session->userdata('id');
            $tgl = date("Y-m-d");
            $absen_masuk = $this->input->post('absensi_masuk', true);
            $ket_keberadaan = $this->input->post('ket_keberadaan', true);
            $cek_absen = $this->absensi_Mod->cek_absensiMasuk($id_jdwlabnsi, $id, $tgl);
            if ($cek_absen) {
                $pesan = "Anda Sudah Mengambil Absen Masuk";
            } else {
                $data = [
                    'id' => $id,
                    'tanggal' => $tgl,
                    'absensi_masuk' => $absen_masuk,
                    'ket_keberadaan' => $ket_keberadaan,
                    'id_jdwlabnsi' => $id_jdwlabnsi
                ];
                if ($this->absensi_Mod->add_absensi($data)) {
                    $pesan = "Absen Masuk Anda Sudah Terkirim";
                }
                $log = [
                    'tanggal' => time(),
                    'aksi' => "Absensi",
                    'Keterangan' => "Ambil Absen Masuk",
                    'ip' => $this->input->ip_address(),
                    'tipe_login' => $this->session->userdata('role_id'),
                    'id_user' => $this->session->userdata('id'),
                    'status' => 1
                ];
                $this->login_Mod->addlog($log);
            }
            echo json_encode($pesan);
            die();
        } elseif ($param == 'add_absn_plng') {
            $id = $this->session->userdata('id');
            $tgl = date("Y-m-d");
            $absen_keluar = $this->input->post('absen_keluar', true);
            $cek_absenKel = $this->absensi_Mod->cek_absensikeluar($id, $tgl);
            if ($cek_absenKel->absensi_keluar == "00:00:00") {
                $id_absensi = $cek_absenKel->id_absensi;
                $data = [
                    'absensi_keluar' => $absen_keluar
                ];
                if ($this->absensi_Mod->update_absensi($id_absensi, $data)) {
                    $pesan = "Absen Pulang Anda Sudah Terkirim ";
                }
                $log = [
                    'tanggal' => time(),
                    'aksi' => "Absensi",
                    'Keterangan' => "Ambil Absen Pulang",
                    'ip' => $this->input->ip_address(),
                    'tipe_login' => $this->session->userdata('role_id'),
                    'id_user' => $this->session->userdata('id'),
                    'status' => 1
                ];
                $this->login_Mod->addlog($log);
            } else {
                $pesan = "Anda Sudah Mengambil Absen Pulang";
            }
            echo json_encode($pesan);
            die();
        } else {
            $judul = 'Dashboard';
            $halaman = 'direktur/index';
            $data['jadwal_absen'] = $this->absensi_Mod->get_jadwal_absensi();
            $this->template->TemplateGen($judul, $halaman, $data);
        }
    }

    public function profil_dr()
    {
        $judul = 'Profil Direktur';
        $halaman = 'direktur/profil_dr';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }


    public function getAbsensiUser_id()
    {
        $length = intval($this->input->post('length'));
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $order = $this->input->post('order');
        $search = $this->input->post('search');
        $search = $search['value'];
        $searchByFromdate = $this->input->post('searchByFromdate');
        $col = 0;
        $dir = "";
        $where = "";

        if ($searchByFromdate != '') {
            $where = $searchByFromdate;
        }

        if (!empty($order)) {
            foreach ($order as $or) {
                $col = $or['column'];
                $dir = $or['dir'];
            }
        }

        if ($dir != 'asc' && $dir != 'desc') {
            $dir = 'desc';
        }

        $valid_columns = [
            1 => 'tanggal',
            2 => 'absensi_masuk',
            3 => 'absensi_keluar',
            4 => 'ket_keberadaan'
        ];

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $id_user = $this->session->userdata('id');
        $dta = $this->absensi_Mod->get_all_absensi_userid($length, $start, $order, $dir, $search, $where, $id_user);
        $json = [];
        $no = $start + 1;
        foreach ($dta as $data) {
            $bad_date = $data->tanggal;
            $tgl = nice_date($bad_date, 'd-m-Y');
            $json[] = [
                $no++,
                $tgl,
                $data->absensi_masuk,
                $data->absensi_keluar,
                $data->ket_keberadaan,
            ];
        }
        $tot = $this->absensi_Mod->get_all_absensi_userid_count($where, $id_user);
        $respon = [
            'draw' => $draw,
            'recordsTotal' => $tot,
            'recordsFiltered' => $tot,
            'data' => $json
        ];
        echo json_encode($respon);
        die();
    }
}
