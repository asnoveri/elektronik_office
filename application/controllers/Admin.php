<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
         $this->load->model('Log_Model');
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index()
    {
     
        // $value=date("Ymd");
        
      	// $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);

        // if(isset($array[$value])){
        //     echo"tanggal merah ".$array[$value]["deskripsi"];
        // }else if (date("D",strtotime($value))==="Sun") {
        //     echo"tanggal merah hari minggu";
        // }else if (date("D",strtotime($value))==="Sat") {
        //     echo"tanggal merah hari Sabtu";
        // }else{
        //     echo"bukan tanggal merah";
        // }
        // die();


        
        $judul = 'Dashboard';
        $halaman = 'admin/index';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);

     }

    public function profil_admin()
    {
        $judul = 'Profil ';
        $halaman = 'admin/profil';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function cek()
    {
        $latitude1       = $this->input->post('latitudeUser', true);
        $longitude1      = $this->input->post('longitudeUser', true);

        // $latitude1          = 0.527241;
        // $longitude1         = 101.434586;
        $latitude2          = 0.525254;
        $longitude2         = 101.434762;

        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        $jarak_akhri = round($distance, 2);
        echo json_encode($jarak_akhri);
        // if ($jarak_akhri <= 0.3) {
        //     // $this->index("add_absensi", $this->input->post());
        //     $pesan = "Dapat Melakukan Absensi";
        //     $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
        //         <button type="button" class="close" data-dismiss="alert">&times;</button>'
        //         . $pesan .
        //         '</div>');
        //     echo json_encode($pesan);
        // } else {
        //     $pesan = "Tidak Dapat Melakukan Pengambilan Absen Masuk, Karena Anda Tidak Berada Di wilayah Kantor";
        //     $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
        //         <button type="button" class="close" data-dismiss="alert">&times;</button>'
        //         . $pesan .
        //         '</div>');
        //     echo json_encode($pesan);
        // }
        die();
    }

    public function listlog(){
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
            1 => 'tanggal',
            2 => 'id_user',
            3 => 'keterangan'
        ];

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $id_user = $this->session->userdata('id');
        $dta = $this->Log_Model->get_log_activity($length, $start, $order, $dir, $search);
        $json = [];
        $no = $start + 1;
        foreach ($dta as $data) {
            $datestring = '%d-%m-%Y / %H:%i:%s ';
            $json[] = [
                $no++,
                mdate($datestring, $data->tanggal), 
                $data->fullname,
                $data->keterangan
            ];
        }
        $tot = $this->Log_Model->get_log_activity_count();
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
