<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_kepeg extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        $this->load->model('absensi_Mod');
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index($param = "")
    {
        if ($param == "get_keb") {
            if (date("l") == "Friday") {
                $id_jadwal = 2;
            } else {
                $id_jadwal = 1;
            }
            $tgl = date("Y-m-d");
            $pkt = $this->absensi_Mod->get_keb_pkt($tgl, $id_jadwal);
            $wfh = $this->absensi_Mod->get_keb_wfh($tgl, $id_jadwal);
            $izn = $this->absensi_Mod->get_keb_izn($tgl, $id_jadwal);
            $jml_peg = $this->user_Mod->get_jml_peg();
            $tot['pkt'] = count($pkt);
            $tot['wfh'] = count($wfh);
            $tot['izn'] = count($izn);
            $tot['jml_peg'] = count($jml_peg);
            echo json_encode($tot);
            die();
        } elseif ($param == "list_absensi") {
            $length = intval($this->input->post('length'));
            $draw = intval($this->input->post('draw'));
            $start = intval($this->input->post('start'));
            $order = $this->input->post('order');
            $search = $this->input->post('search');
            $search = $search['value'];
            $col = 0;
            $dir = "";

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
                1 => 'fullname',
                2 => 'tanggal',
                3 => 'absensi_masuk',
                4 => 'absensi_keluar',
                5 => 'ket_keberadaan'
            ];

            if (!isset($valid_columns[$col])) {
                $order = null;
            } else {
                $order = $valid_columns[$col];
            }

            $dta = $this->absensi_Mod->get_all_absensi($length, $start, $order, $dir, $search);
            $json = [];
            $no = $start + 1;
            foreach ($dta as $data) {
                $bad_date = $data->tanggal;
                $tgl = nice_date($bad_date, 'd-m-Y');
                $json[] = [
                    $no++,
                    $data->fullname,
                    $tgl,
                    $data->absensi_masuk,
                    $data->absensi_keluar,
                    $data->ket_keberadaan,
                ];
            }
            $tot = $this->absensi_Mod->get_all_absensi_count();
            $respon = [
                'draw' => $draw,
                'recordsTotal' => $tot,
                'recordsFiltered' => $tot,
                'data' => $json
            ];
            echo json_encode($respon);
            die();
        } else {
            $judul = 'Dashboard';
            $halaman = 'Admin_kepeg/index';
            $data['tgl'] = date("Y-m-d");
            $this->template->TemplateGen($judul, $halaman, $data);
        }
    }

    public function profil_adminkepg()
    {
        $judul = 'Profil Wadir';
        $halaman = 'Admin_kepeg/profil_adminkepg';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }
}
