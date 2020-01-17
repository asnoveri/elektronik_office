<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blank_page extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
    }

    public function index(){
        $judul=" 404 Page Not Found";
        $halaman='general_templates/blank_page';
        $data1="";
        $this->template->TemplateGen($judul,$halaman,$data1);     
        
    }

    

}


?>