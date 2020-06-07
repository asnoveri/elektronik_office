<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

class Absensi extends CI_Controller
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
        if ($param == "getlist_all_absensi") {
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

            $dta = $this->absensi_Mod->get_all_absensi_everyday($length, $start, $order, $dir, $search, $where);
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
            $tot = $this->absensi_Mod->get_all_absensi_everyday_count($where);
            $respon = [
                'draw' => $draw,
                'recordsTotal' => $tot,
                'recordsFiltered' => $tot,
                'data' => $json
            ];
            echo json_encode($respon);
            die();
        } else {
            $judul = 'Absensi';
            $halaman = 'Absensi/index';
            $data['tgl'] = date("Y-m-d");
            $this->template->TemplateGen($judul, $halaman, $data);
        }
    }

    public function cetak_persensiHarian()
    {
        ob_start();
        $tgl = $this->input->post('tanggal', true);;
        $data['tgl'] = longdate_indo($tgl);
        $date = $data['tgl'];

        $data['absensi_harian'] = $this->absensi_Mod->get_absensicetakPertgl($tgl);
        $get_hari = date("l", strtotime($tgl));
        if ($get_hari == "Friday") {
            echo     $id_jadwal = 2;
        } else {
            echo    $id_jadwal = 1;
        }

        $pkt = $this->absensi_Mod->get_keb_pkt($tgl, $id_jadwal);
        $wfh = $this->absensi_Mod->get_keb_wfh($tgl, $id_jadwal);
        $izn = $this->absensi_Mod->get_keb_izn($tgl, $id_jadwal);

        $data['pkt_tot'] = count($pkt);
        $data['wfh_tot'] = count($wfh);
        $data['izn_tot'] = count($izn);

        $this->load->view('Template_laporan/laporan_absensi_harian_pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', false, 'ISO-8859-15', array(20, 10, 20, 5));
        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($html);
        $html2pdf->output("absensi_harian_pegawai'_$date.'.pdf");
    }
}
