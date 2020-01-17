<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Managemen extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_mod');
        is_login();
      
    }

    public function index(){
        $judul="User Managemen";
        $halaman='user_maneg/index';
        $data['user_all_rolelist']=$this->user_Mod->get_all_user_not_admin();
        $this->template->TemplateGen($judul,$halaman,$data);  
    }

    public function list_all_user($id){
        $judul="User Managemen";
        $halaman='user_maneg/list_all_user';
        $data['role']=$this->user_Mod->get_user_BYID($id);
        $data['user_all_list']=$this->user_Mod->get_user_bytipe_roleID($id);
        $this->template->TemplateGen($judul,$halaman,$data);
    }
}
?>