<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managemen_Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_mod');
        is_login();
      
    }

    public function index(){
        $judul="Managemen Admin";
        $halaman='user_maneg/addadmin';
        $data['admin_all_list']=$this->user_Mod->get_admin();
        $this->template->TemplateGen($judul,$halaman,$data);  
    }

    public function add_admin(){
        
        $this->form_validation->set_rules('fullname','Fullname','required|trim'
        ,['required'=> 'Field  Nama Lengkap Tidak Boleh Kosong']);
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]' ,[
            'required'=> 'Field  Email  Tidak Boleh Kosong',
            'valid_email'=> 'Email yang dimasukan Salah',
            'is_unique'=> 'Email Sudah Terdaftar di Database'
            ]);
        $this->form_validation->set_rules('pass','Pass','required|trim|min_length[6]|matches[pass1]',
        ['required'=>'Password Tidak Boleh Kosong',
        'min_length'=> 'Password Harus Lebih dari 6 Karakter',
        'matches'=> 'Password yang Di Inputkan Tidak sama']); 
        $this->form_validation->set_rules('pass1','Pass1','required|trim|min_length[6]|matches[pass]',
        ['required'=>'Password Verification Tidak Boleh Kosong',
        'min_length'=> 'Password Harus Lebih dari 6 Karakter',
        'matches'=> 'Password yang Di Inputkan Tidak sama']     
        );    
        
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $data=[
                'id'        =>'' ,
                'fullname'  =>$this->input->post('fullname',true),
                'email'     =>$this->input->post('email',true),
                'is_active' => 1,
                'image'     => "default.png",
                'pass'      =>password_hash($this->input->post('pass1',true), PASSWORD_DEFAULT),
                'date_created'=> time(),
                'role_id'   => 1
            ];
            //passwor asno= asno12345
            
            if($this->user_Mod->Add_Admin($data)){
                $this->session->set_flashdata('pesantambah','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Menambahkan Admin Baru
                </div>');
               redirect("Managemen_Admin");
            }else{
                $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan Admin Baru
                </div>');  
               redirect("Managemen_Admin");
            }
        }
        // redirect("Managemen_Admin");
    }

    public function hapus_admin($id){
        if($this->user_Mod->del_Admin($id)){
            $this->session->set_flashdata('pesantambah','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Berhasil Menghapus Admin 
                </div>');  
               redirect("Managemen_Admin");
        }else{
            $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus Admin 
                </div>');  
               redirect("Managemen_Admin");
        }
    }

    public function get_adminBYID(){
        $data=[
            'id'=>$this->input->post('id',true)
        ];
        $data=$this->user_Mod->get_admin_BYID($data);
        echo json_encode($data);
    }

    public function edit_admin(){
        $this->form_validation->set_rules('pass1','Pass1','required|trim|min_length[6]',
        ['required'=>'Password Tidak Boleh Kosong',
        'min_length'=> 'Password Harus Lebih dari 6 Karakter']     
        );     

        if($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $id=$this->input->post('id',true);
            $data =[
                'pass'=>password_hash($this->input->post('pass1',true),PASSWORD_DEFAULT) 
            ];
            $in=$this->user_Mod->editAdmin($id,$data);

            if($in == true){
                $this->session->set_flashdata('pesantambah','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Mengubah Password Admin 
                </div>');
               redirect("Managemen_Admin");
            }else{
                $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    gagal Ubah Password Admin 
                </div>');
               redirect("Managemen_Admin");
            }
        }
    }
}
?>