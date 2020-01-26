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
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function add_surat(){
        $this->form_validation->set_rules('tgl_surat_masuk','Tgl_surat_masuk','required|trim',[
            'required'=>'Tanggal Surat Harus di pilih',
        ]);
        $this->form_validation->set_rules('asal_surat','Asal_Surat','required|trim',[
            'required'=>'Asal Surat Masuk Tidak boleh Kosng',
        ]);
        $this->form_validation->set_rules('sifat_surat','Sifat_surat','required|trim',[
            'required'=>'Sifat Surat Harus di Pilih',
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
        $this->form_validation->set_rules('instruksi','Instruksi','required|trim',[
            'required'=>'Instruksi Tidak Boleh Kosong',
        ]);

      if($this->form_validation->run()==false){
            $this->index();
      }else{
          $upload_file_srt= $_FILES["file_surat"]["name"];
          if($upload_file_srt){
            $config['upload_path']          = "./assets/upload_file_surat/";
            $config['allowed_types']        = 'docx|pdf\jpg';
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
            'tgl_surat_masuk'=>nice_date($this->input->post('tgl_surat_masuk',true), 'd-m-Y'),
            'no_surat'=> $this->input->post('no_surat',true),
            'sifat_surat'=> $this->input->post('sifat_surat',true),
            'di_teruskan_ke'=> $this->input->post('di_teruskan_ke',true),
            'instruksi'=> $this->input->post('instruksi',true),
            'di_kirimkan_oleh'=> $this->session->userdata('role_id'),
            'asal_surat'=> $this->input->post('asal_surat',true),
            'perihal'=> $this->input->post('perihal',true),
            'file_surat'=>$file,
            'id_feedback'=>'1'
          ]; 
          $jbtn=$this->user_Mod->get_jbtnBYid($this->input->post('di_teruskan_ke',true));
          if($this->Surat_Mod->upload_SRT_Msk($data)== true){

            $this->session->set_flashdata('pesan_surat','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Berhasil Mengirmkan Surat ke '. $jbtn->jabatan .'
            </div>');
            redirect('Managemen_surat');
          }else{
            $this->session->set_flashdata('pesan_surat','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               gagal Mengirmkan Surat ke '. $jbtn->jabatan .'
            </div>');
            redirect('Managemen_surat');
          }
      }
    }


}


?>