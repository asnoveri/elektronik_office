<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kepeg extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        date_default_timezone_set('Asia/Jakarta');        
        is_login();
    }

    public function index(){
        $judul='Dashboard';
        $halaman='Admin_kepeg/index';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function profil_adminkepg(){
        $judul='Profil Wadir';
        $halaman='Admin_kepeg/profil_adminkepg';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);        
    }
}


?>