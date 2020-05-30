<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wadir extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        date_default_timezone_set('Asia/Jakarta');        
        is_login();
    }

    public function index(){
        $judul='Dashboard';
        $halaman='wadir/index';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function profil_wadir(){
        $judul='Profil Wadir';
        $halaman='Wadir/profil_wadir';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);        
    }
}