<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {

    public function __construct(){
        parent::__construct();

        is_login();
    }

    public function index(){
        $judul='Dashboard';
        $halaman='Operator/index';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);   
      
       
    }

    public function profil_op(){
        $judul='Profil Sekretaris';
        $halaman='Operator/profil_operator';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);   
    }

   
}

?>