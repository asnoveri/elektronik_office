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

    public function  jabatan(){
        $judul="Jabatan Pegawai ";
        $halaman='user_maneg/list_jabatan';
        $data['jabatan']=$this->user_Mod->get_all_jabatan();
        $this->template->TemplateGen($judul,$halaman,$data);
    }

    public function add_jabatan(){
        $this->form_validation->set_rules('jabatan','Jabatan','required|trim|is_unique[jabatan_user.jabatan]',
        [
            'required'=>'Jabatan Tidak Boleh Kosong',
            'is_unique'=>'Jabatan yang Di Masukan Sudah Ada Di Database'
            ]);
        if($this->form_validation->run() == false){
            $this->jabatan();
        }else{
           $add= $this->user_Mod->Add_jabatan($this->input->post('jabatan',true));
            if($add == true){
                $this->session->set_flashdata('msgjbtn','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Menambahkan Jabatan Baru
                </div>');
               redirect("User_Managemen/jabatan");
            }else{
                $this->session->set_flashdata('msgjbtn','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Menambahkan Jabatan Baru
                </div>');
               redirect("User_Managemen/jabatan");
            }
        }
    }
    public function hapusjbt($id){
       if($this->user_Mod->delJabtan($id) == true){
                $this->session->set_flashdata('msgjbtn','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Berhasil Mengahapus Jabatan 
                </div>');
                redirect("User_Managemen/jabatan");
       } else{
                $this->session->set_flashdata('msgjbtn','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Menghapus Jabatan 
                </div>');
                redirect("User_Managemen/jabatan");
       }
    }
}
?>