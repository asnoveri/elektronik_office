<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managemen_surat extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        $this->load->model('Surat_Mod');
        date_default_timezone_set('Asia/Jakarta');       

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
        $this->form_validation->set_rules('sifat_surat','Sifat_surat','required|trim',[
            'required'=>'Sifat surat Harus di pilih',]);

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
          }else{
            $this->session->set_flashdata('pesan_surat','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                File yang di Upload belum di pilih, Silahkan pilih dulu filenya
            </div>');
            redirect('Managemen_surat');
               
          }
          $data=[
            'tgl_surat_masuk'=>$this->input->post('tgl_surat_masuk',true),
            'no_surat'=> $this->input->post('no_surat',true),
            'sifat_surat'=>$this->input->post('sifat_surat',true),
            'asal_surat'=> $this->input->post('asal_surat',true),
            'perihal'=> $this->input->post('perihal',true),
            'file_surat'=>$file,
            'tipe_surat'=>"Surat Masuk"
          ]; 
      
          $jbtn=$this->user_Mod->get_jbtnBYid($this->input->post('di_teruskan_ke',true));
          if($id_srt_msk=$this->Surat_Mod->upload_SRT_Msk($data)){
            
                 $data1=[
                        'id_surat_masuk'=> $id_srt_msk->id_surat_masuk,
                        'di_teruskan_ke'=> $this->input->post('di_teruskan_ke',true),
                        'di_kirimkan_oleh'=> 0,
                        'id_feedback'=>'1',
                        'bg_porgres'=>'primary'
                    ]; 
                 $this->Surat_Mod->add_srt_msuk_diter($data1);

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
        $data['detail_srt_masuk_ter']=$this->Surat_Mod->get_srtMSkBYID_ter($id);   
        $this->template->TemplateGen($judul,$halaman,$data);    
    }
    
    public function srt_keluar(){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/list_dftr_srt_keluar_BYopadmn';
        $data['srt_keluar_ter']=$this->Surat_Mod->get_surat_keluar_diterBYopadmn();   
        $de=$data['srt_keluar_ter'];
        foreach($de as $idsk){
            $srt_keluar[]=$this->Surat_Mod->get_surat_keluarByid($idsk->id_surat_keluar);
            $fdbk[]= $idsk->id_feedback_terSrtKlr;
            $idtrsk[]=$idsk->id_terus_srt_keluar;
        }
      $data['srt_keluar']= $srt_keluar;
      $data['feeback']= $fdbk;
      $data['id_terus_srt_keluar']= $idtrsk;
        $this->template->TemplateGen($judul,$halaman,$data);     
    }

    public function detail_srt_keluar($id_surat_keluar){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/detail_Surat_keluar';
        $data['srt_keluarbyId']=$this->Surat_Mod->get_surat_keluarByid($id_surat_keluar);   
        // $data['pjbtn_mndt']=$this->user_Mod->get_user_BYIDjabtan($data['srt_keluarbyId']->yang_mendisposisi);
        $data['jabatan']=$this->user_Mod->get_all_jabatan();
        $this->template->TemplateGen($judul,$halaman,$data);    
    }

    public function add_suratkeluar_diteruskan($id){
        $this->form_validation->set_rules('di_teruskan_ke_srt_klr','Di_teruskan_ke_srt_klr','required',
         ['required'=> 'Teruskan Pengajuan Disposisi Keluar Tidak Boleh Kosong']     
        );  
        if($this->form_validation->run() == FALSE){
            $this->detail_srt_keluar($id);
        }else{  
            $jbtn=$this->user_Mod->get_jbtnBYid($this->input->post('di_teruskan_ke_srt_klr',true));
            $data1=[
                'id_surat_keluar'=> $this->input->post('id_surat_keluar',true),
                'di_teruskan_ke_srt_klr'=> $this->input->post('di_teruskan_ke_srt_klr',true),
                'id_feedback_terSrtKlr'=>'1',
                'bg_porgres_srt_keluar'=>'primary'
            ]; 
                $this->Surat_Mod->add_srt_keluar_diter($data1);
                $this->session->set_flashdata('pesan_surat1','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Berhasil Meneruskan Pengajuan Disposis Surat ke '. $jbtn->jabatan .'
                </div>');
                redirect('Managemen_Surat/srt_keluar');
        }
    }

    public function status_srt_keluar_kepjbt($id){
        $judul='Managemen Surat';
        $halaman='Surat_maneg/status_srt_keluar_kepjbt';
        $data['surat_keluarter']=$this->Surat_Mod->get_surat_keluarByidMulti($id);
        $data['surat_keluar']=$this->Surat_Mod->get_surat_keluarByid($id);
        $this->template->TemplateGen($judul,$halaman,$data);    
    }
    public function ubh_feedback_srtklr_useradmop (){
        $id=$this->input->post('id_terus_srt_keluar', true);
        $data=[
            'id_feedback_terSrtKlr'=> 2,
            'bg_porgres_srt_keluar'=>'success'
        ];
        $this->Surat_Mod->edit_feedback_srtkelter($data,$id);
    }
}


?>