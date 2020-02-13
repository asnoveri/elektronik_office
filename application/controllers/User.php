<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        $this->load->model('Surat_Mod');

        is_login();

    }

    public function index(){
        $judul='Dashboard';
        $halaman='user/index';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);   
      
       
    }

    public function profil_user(){
        $judul='Profil user';
        $halaman='user/profil_user';
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);   
    }

    public function list_srt_msk_user(){
        $judul='Disposisi Surat';
        $halaman='user/surat_masuk';
        $data='';
        $this->template->TemplateGen($judul,$halaman,$data);   
    }

    public function detail_srt_masuk_user($id){
        $judul='Disposisi Surat';
        $halaman='user/detail_srt_masuk_user';
        $data['detail_srt_masuk']=$this->Surat_Mod->get_srtMSkBYID($id);   
        $data['detail_srt_masuk_ter']=$this->Surat_Mod->get_srtMSkBYID_ter($id);   
        $this->template->TemplateGen($judul,$halaman,$data);    
    }

    public function ubh_feedback_srtmsk_user (){
         $id=$this->input->post('id_terus', true);
        $data=[
            'id_feedback'=> 2,
            'bg_porgres'=>'success'
         ];
         if($this->Surat_Mod->edit_feedback_srtMSK($data,$id)){

         }
    }
}


?>