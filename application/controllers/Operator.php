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
        $data1="";
        $this->template->TemplateGen($judul,$halaman,$data1);   
      
       
    }

    public function profil_op(){
        $judul='Profil Operator';
        $halaman='Operator/profil_operator';
        $data1="";
        $this->template->TemplateGen($judul,$halaman,$data1);   
    }

   
}

?>