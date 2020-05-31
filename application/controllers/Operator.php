<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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
                $data = $this->absensi_Mod->add_absensi($data);
                if ($data == true) {
                    $pesan = "Absen Masuk Anda Sudah Terkirim";
                }
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
            } else {
                $pesan = "Anda Sudah Mengambil Absen Pulang";
            }
            echo json_encode($pesan);
            die();
        } else {
            $judul = 'Dashboard';
            $halaman = 'operator/index';
            $data['jadwal_absen'] = $this->absensi_Mod->get_jadwal_absensi();
            $this->template->TemplateGen($judul, $halaman, $data);
        }
    }




    public function profil_op()
    {
        $judul = 'Profil ';
        $halaman = 'Operator/profil_operator';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }
}
