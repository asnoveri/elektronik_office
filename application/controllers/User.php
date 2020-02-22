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

    public function detail_srt_masuk_user($id,$idterus=""){
        $judul='Disposisi Surat';
        $halaman='user/detail_srt_masuk_user';
        $data['detail_srt_masuk']=$this->Surat_Mod->get_srtMSkBYID($id);   
        $data['detail_srt_masuk_ter']=$this->Surat_Mod->get_srtMSkBYID_terSingle($id,$idterus); 
        $data['jabatan']=$this->user_Mod->get_all_jabatan();
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

    public function add_suratmasuk_diteruskan(){
        
        $jbtn=$this->user_Mod->get_jbtnBYid($this->input->post('di_teruskan_ke',true));
        $data1=[
            'id_surat_masuk'=> $this->input->post('id_surat_masuk',true),
            'di_teruskan_ke'=> $this->input->post('di_teruskan_ke',true),
            'di_kirimkan_oleh'=> $this->session->userdata('id_jabatan'),
            'id_feedback'=>'1',
            'bg_porgres'=>'primary'
        ]; 
            $this->Surat_Mod->add_srt_msuk_diter($data1);
            $this->session->set_flashdata('pesan_surat1','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Berhasil Meneruskan Surat ke '. $jbtn->jabatan .'
            </div>');
            redirect('User/list_srt_msk_user');
            }
}


?>