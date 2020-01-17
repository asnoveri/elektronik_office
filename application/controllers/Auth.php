<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model('login_Mod');
    }

    public function index(){
       
        $data['judul']='Disposisi -Login';
        $this->load->view('auth_templates/header',$data);
        $this->load->view('auth/index');
        $this->load->view('auth_templates/footer');
    }

    public function login(){
        $this->form_validation->set_rules('email','Email','required|valid_email|trim');
        $this->form_validation->set_rules('pass','Pass','required|trim');
		
        if($this->form_validation->run() == false){
            $this->index();
        }else{
            $data=$this->input->post('email',true);
            $pass=$this->input->post('pass',true);
            $datalogin=$this->login_Mod->get_User($data);

            if($datalogin){
                if($datalogin['is_active'] == 1){
                    $data=[
                        'email'     => $datalogin['email'],
                        'role_id'   => $datalogin['role_id'],
                        'id_jabatan'=> $datalogin['id_jabatan']
                    ];
                    $this->session->set_userdata($data);
                    if(password_verify($pass,$datalogin['pass'])){
                        if($datalogin['role_id'] == 1){
                             redirect('Admin');
                            
                        }elseif($datalogin['role_id'] == 2){
                            redirect('Operator');
                        }elseif($datalogin['role_id'] == 3){
                            redirect('User');
                        }
                    }else{
                        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                           Password Yang Anda Masukan Salah!!
                        </div>');
                        redirect('Auth');
                    }
                }else{
                    $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Account Anda Belum Aktif Silahkan Hubungi Admin Sistem Untuk Menaktifkan Account Anda!!
                    </div>');
                    redirect('Auth');
                }
            }else{
                $this->session->set_flashdata('pesan','<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Account Anda Belum Terdaftar Silahkan Hubungi Admin Sistem Untuk Mendaftarkan Account Anda!!
                </div>');
              redirect('Auth');
            }
        }
    }

    public function autlog($data){
        //pesan adalah nama item 
        if($data ==1){
            $pesan='Silahkan Hubungi Admin Sistem Untuk Menset Ulang Password Anda!!';
        }elseif($data ==2){
            $pesan='Silahkan Hubungi Admin Sistem Untuk Mendaftarkan Account Anda!!';
        }
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
       '.$pesan.'
      </div>');
      redirect('Auth');


    }


    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id_jabatan');
        $this->session->set_flashdata('pesan','<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
            Anda Baru Saja Logout dari Aplikasi Dispsoisi!!!
        </div>');

      redirect('Auth');
    }
}

?>