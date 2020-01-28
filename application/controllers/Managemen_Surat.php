<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managemen_surat extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        $this->load->model('Surat_Mod');

       is_login();
    
    }

    public function index(){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/index';
        $data['jabatan']=$this->user_Mod->get_all_jabatan();
        $data['adum']=$this->user_Mod->get_jbtnBYid(14);
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function add_surat(){
        $this->form_validation->set_rules('tgl_surat_masuk','Tgl_surat_masuk','required|trim',[
            'required'=>'Tanggal Surat Harus di pilih',
        ]);
        $this->form_validation->set_rules('asal_surat','Asal_Surat','required|trim',[
            'required'=>'Asal Surat Masuk Tidak boleh Kosng',
        ]);
        $this->form_validation->set_rules('no_surat','No_surat','required|trim',[
            'required'=>'No Surat Masuk Tidak Boleh Kosong',
        ]);
        $this->form_validation->set_rules('perihal','perihal','required|trim',[
            'required'=>'Perihal Tidak Boleh Kosong',
        ]);
        $this->form_validation->set_rules('di_teruskan_ke','Di_teruskan_ke','required|trim',[
            'required'=>'Di Teruskan Ke  Harus di pilih',
        ]);

      if($this->form_validation->run()==false){
            $this->index();
      }else{
          $upload_file_srt= $_FILES["file_surat"]["name"];
          if($upload_file_srt){
            $config['upload_path']          = "./assets/upload_file_surat/";
            $config['allowed_types']        = 'pdf|jpg';
            $config['max_size']             = 4096;
            $config['remove_spaces']        = true;
            //memangil libraires upload dan masukan configurasinya
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file_surat')) {
                $error =$this->upload->display_errors();
                $this->session->set_flashdata('pesan_surat','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>'
                 .$error.    
                '</div>');
                redirect('Managemen_surat');
                   
                }else{
                 $file=$this->upload->data('file_name');
            }
          }
          $data=[
            'tgl_surat_masuk'=>$this->input->post('tgl_surat_masuk',true),
            'no_surat'=> $this->input->post('no_surat',true),
            'di_teruskan_ke'=> $this->input->post('di_teruskan_ke',true),
            'di_kirimkan_oleh'=> $this->session->userdata('role_id'),
            'asal_surat'=> $this->input->post('asal_surat',true),
            'perihal'=> $this->input->post('perihal',true),
            'file_surat'=>$file,
            'id_feedback'=>'1'
          ]; 
          $jbtn=$this->user_Mod->get_jbtnBYid($this->input->post('di_teruskan_ke',true));
          if($this->Surat_Mod->upload_SRT_Msk($data)== true){

            $this->session->set_flashdata('pesan_surat1','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Berhasil Meneruskan Surat ke '. $jbtn->jabatan .'
            </div>');
            redirect('Managemen_surat/list_dftr_srt_msk');
          }else{
            $this->session->set_flashdata('pesan_surat1','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               gagal MengirmMeneruskan Surat ke '. $jbtn->jabatan .'
            </div>');
            redirect('Managemen_surat/list_dftr_srt_msk');
          }
      }
    }

    public function list_dftr_srt_msk(){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/list_dftr_srt_msk';
        $data['srt_masuk']=$this->Surat_Mod->get_all_srtMSk();   
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function detail_srt_masuk($id){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/detail_Surat_masuk';
        $data['detail_srt_masuk']=$this->Surat_Mod->get_srtMSkBYID($id);   
        $this->template->TemplateGen($judul,$halaman,$data);    
    }
    

    public function kelola_alur_srt(){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/kelola_alr_srt';
        $data="";   
        $this->template->TemplateGen($judul,$halaman,$data);    
    }

}


?>