<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');

       is_login();
    
    }

    public function index(){
        $judul='Dashboard';
        $halaman='Admin/index';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);     
        
    }

    public function profil_admin(){
        $judul='Profil Admin';
        $halaman='Admin/profil';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);     
        
    }
    

   
}


?>