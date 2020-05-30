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
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Anda Sudah Mengambil Absen Masuk
                </div>');
                echo json_encode($cek_absen);
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
                    echo json_encode(true);
                }
            }
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
