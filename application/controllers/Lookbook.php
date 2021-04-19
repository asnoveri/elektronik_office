<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require('./application/third_party/phpoffice/vendor/autoload.php');

// use Spipu\Html2Pdf\Html2Pdf;

class Lookbook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        $this->load->model('LookbookMod');
        $this->load->model('login_Mod');
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index($param = "")
    {
        if ($param == "getlist_all_lookbook") {
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
                3 => 'unitkerja',
                4 => 'output',
            ];

            if (!isset($valid_columns[$col])) {
                $order = null;
            } else {
                $order = $valid_columns[$col];
            }
        
            $dta = $this->LookbookMod->get_all_lookbook($length, $start, $order, $dir, $search, $where);
            
            $json = [];
            $no = $start + 1;
            foreach ($dta as $data) {
                
                $bad_date = $data->tanggal;
                $longdate_indo = longdate_indo($bad_date);
                if( $data->output==1){
                    $datakeluar="Dokumen";
                }else{
                    $datakeluar="Kegiatan";
                }
                $json[] = [
                    $no++,
                    $data->fullname,
                    $longdate_indo,
                    $data->unitkerja,
                    $data->u_kegiatan,
                    $data->jumlah,
                    $datakeluar,
                    $data->bukti_keg
                ];
            }
            $tot = $this->LookbookMod->get_all_lookbook_count($where);
            $respon = [
                'draw' => $draw,
                'recordsTotal' => $tot,
                'recordsFiltered' => $tot,
                'data' => $json
            ];
            
            echo json_encode($respon);
            die();
        } else {
            $judul = 'LookBook';
            $halaman = 'Lookbook/index';
            // $data['tgl'] = date("Y-m-d");
            $this->template->TemplateGen($judul, $halaman);
        }
    }
}
