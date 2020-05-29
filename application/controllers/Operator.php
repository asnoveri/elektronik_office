<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index($param = "")
    {
        if ($param == "jadaw_absensi") {
            if (date("l") == "Friday") {
                $id_jadwal = 2;
            } else {
                $id_jadwal = 1;
            }
            $data = $this->db->get_where('jadwal_absensi', ['id_jdwlabnsi' => $id_jadwal])->row();
            echo json_encode($data);
        } else {
            $judul = 'Dashboard';
            $halaman = 'operator/index';
            $data['tgl'] = date("Y-m-d");
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
