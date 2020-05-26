<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adum extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        date_default_timezone_set('Asia/Jakarta');        
        is_login();
    }

    public function index(){
        $judul='Dashboard';
        $halaman='adum/index';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function profil_adum(){
        $judul='Profil Adum';
        $halaman='Adum/profil_adum';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);        
    }
}
