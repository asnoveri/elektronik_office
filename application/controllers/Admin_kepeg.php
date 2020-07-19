<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
            $dl = $this->absensi_Mod->get_keb_dl($tgl, $id_jadwal);
            $jml_peg = $this->user_Mod->get_jml_peg();
            $tot['pkt'] = count($pkt);
            $tot['wfh'] = count($wfh);
            $tot['izn'] = count($izn);
            $tot['dl'] = count($dl);
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
            $data['jadwal_absensi'] = $this->absensi_Mod->get_all_jdwl_absen();
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

    public function exsport_absen_excel()
    {
        //styling arrays
        //table head style
        $tableHead = [
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
                'bold' => true,
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '538ED5'
                ]
            ],
        ];
        //even row
        $evenRow = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '00BDFF'
                ]
            ]
        ];
        //odd row
        $oddRow = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '00EAFF'
                ]
            ]
        ];

        //styling arrays end
        $tgl =  date('Y-m-d');
        $date = longdate_indo($tgl);
        $spreadsheet = new Spreadsheet;

        $sheet = $spreadsheet->getActiveSheet();

        //set default font
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(10);

        //heading
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "Rekap Absensi Harian Pegawai ($date)");

        //merge heading
        $spreadsheet->getActiveSheet()->mergeCells("A1:E1");

        // set font style
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        // set cell alignment
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //setting column width
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);

        // total hadir awal
        if (date("l") == "Friday") {
            $id_jadwal = 2;
        } else {
            $id_jadwal = 1;
        }
        $data = $this->absensi_Mod->get_absensiTody();
        $pkt = $this->absensi_Mod->get_keb_pkt($tgl, $id_jadwal);
        $pktrengat = $this->absensi_Mod->get_keb_pkt_rengat($tgl, $id_jadwal);
        $wfh = $this->absensi_Mod->get_keb_wfh($tgl, $id_jadwal);
        $izn = $this->absensi_Mod->get_keb_izn($tgl, $id_jadwal);
        $jml_peg = $this->user_Mod->get_jml_peg();
        $dl = $this->absensi_Mod->get_keb_dl($tgl, $id_jadwal);


        $pkt = count($pkt);
        $pktrengat = count($pktrengat);
        $wfh = count($wfh);
        $izn = count($izn);
        $dl = count($dl);
        $tot_hdr = count($data);
        $jml_peg = count($jml_peg);
        $tot = $tot_hdr - $izn;
        // total hadir akhir

        //header text
        $spreadsheet->getActiveSheet()
            ->setCellValue('A2', "NO")
            ->setCellValue('B2', "Nama")
            ->setCellValue('C2', "Absen Masuk")
            ->setCellValue('D2', "Absen Pulang")
            ->setCellValue('E2', "Keterangan Keberadaan")

            ->setCellValue('H2', "WFH")
            ->setCellValue('H3', "Piket Kantor")
            ->setCellValue('H4', "Piket Kantor Rengat")
            ->setCellValue('H5', "Izin (Cuti/Sakit)")
            ->setCellValue('H6', "Perjalanan Dinas")
            // ->setCellValue('H6', "Jumlah Pegawai")
            ->setCellValue('I2', $wfh)
            ->setCellValue('I3', $pkt)
            ->setCellValue('I4', $pktrengat)
            ->setCellValue('I5', $izn)
            ->setCellValue('I6', $dl);
        // ->setCellValue('I6', $jml_peg);

        //set font style and background color
        $spreadsheet->getActiveSheet()->getStyle('A2:E2')->applyFromArray($tableHead);
        $spreadsheet->getActiveSheet()->getStyle('H2:H6')->applyFromArray($oddRow);
        $spreadsheet->getActiveSheet()->getStyle('I2:I6')->applyFromArray($evenRow);



        $row = 3;
        $no = 1;
        foreach ($data as $pegawai) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $row, $no)
                ->setCellValue('B' . $row, $pegawai->fullname)
                ->setCellValue('C' . $row, $pegawai->absensi_masuk)
                ->setCellValue('D' . $row, $pegawai->absensi_keluar)
                ->setCellValue('E' . $row, $pegawai->ket_keberadaan);

            //set row style
            if ($row % 2 == 0) {
                //even row
                $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':E' . $row)->applyFromArray($evenRow);
            } else {
                //odd row
                $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':E' . $row)->applyFromArray($oddRow);
            }
            //increment row
            $row++;
            $no++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="absensi_pegawai.' . $date . '.xlsx"');
        // header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function cetak_absensi()
    {
        ob_start();
        $tgl =  date('Y-m-d');
        $data['tgl'] = longdate_indo($tgl);
        $date = $data['tgl'];

        $data['absensi_harian'] = $this->absensi_Mod->get_absensiTody();
        if (date("l") == "Friday") {
            $id_jadwal = 2;
        } else {
            $id_jadwal = 1;
        }

        $pkt = $this->absensi_Mod->get_keb_pkt($tgl, $id_jadwal);
        $pktrengat = $this->absensi_Mod->get_keb_pkt_rengat($tgl, $id_jadwal);
        $wfh = $this->absensi_Mod->get_keb_wfh($tgl, $id_jadwal);
        $izn = $this->absensi_Mod->get_keb_izn($tgl, $id_jadwal);
        $dl = $this->absensi_Mod->get_keb_dl($tgl, $id_jadwal);

        $data['pkt_tot'] = count($pkt);
        $data['pkt_tot_rgt'] = count($pktrengat);
        $data['wfh_tot'] = count($wfh);
        $data['izn_tot'] = count($izn);
        $data['dl_tot']  = count($dl);

        $this->load->view('Template_laporan/laporan_absensi_harian_pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', false, 'ISO-8859-15', array(20, 10, 20, 5));
        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($html);
        $html2pdf->output("absensi_harian_pegawai'_$date.'.pdf");
    }
}
