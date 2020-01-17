<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();


        is_login();

    }

    public function index(){
        $judul='Dashboard';
        $halaman='user/index';
        $data1="";
        $this->template->TemplateGen($judul,$halaman,$data1);   
      
       
    }

    public function profil_user(){
        $judul='Profil user';
        $halaman='user/profil_user';
        $data1="";
        $this->template->TemplateGen($judul,$halaman,$data1);   
    }

}


?>