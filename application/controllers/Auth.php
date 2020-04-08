<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model('login_Mod');
    }

    public function index($data1=""){
        $data['judul']='Elektronik Office -Login';
        $this->load->view('auth_templates/header',$data);
        $this->load->view('auth/index',$data1);
        $this->load->view('auth_templates/footer');
    }

    public function login(){
        // $this->form_validation->set_rules('email','Email','required|valid_email|trim');
        $this->form_validation->set_rules('user_name','User_name','required|trim|min_length[3]|alpha_dash', 
        ['alpha_dash'=>'User Name Tidak Mengizinkan Spasi Pada Karakter Yang di Masukkan']);
        $this->form_validation->set_rules('pass','Pass','required|trim');
		
        if($this->form_validation->run() == false){
            $this->index();
        }else{
            // $data=$this->input->post('email',true);
            $data=$this->input->post('user_name',true);
            $pass=$this->input->post('pass',true);
            $datalogin=$this->login_Mod->get_User($data);

            if($datalogin){
                if($datalogin['is_active'] == 1){
                    $direktur=$this->login_Mod->get_direktur($datalogin['id']);
                    $admin=$this->login_Mod->get_admin($datalogin['id']);
                    $sekretaris=$this->login_Mod->get_sekretaris($datalogin['id']);
                    $wadir=$this->login_Mod->get_wadir($datalogin['id']);
                    $adum=$this->login_Mod->get_adum($datalogin['id']);
                    $pegawai=$this->login_Mod->get_pegawai($datalogin['id']);
                    $adminkepeg=$this->login_Mod->get_adminkepeg($datalogin['id']);
                    $data= count($admin) + count($direktur) + count($sekretaris) + count($wadir) + count($adum) + count($pegawai) + count($adminkepeg);
                    if($data >1){
                        if(password_verify($pass,$datalogin['pass'])){
                            $data=[
                                'email'     => $datalogin['email'],
                                'id'        => $datalogin['id']
                            ];
                            $this->session->set_userdata($data);
                                $this->pilih_Role();
                        }else{
                            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Password Yang Anda Masukan Salah!!
                            </div>');
                            redirect('Auth');
                        }  
                    }else{
                        $role=$this->login_Mod->get_role($datalogin['id']);
                        $data=[
                            'email'     => $datalogin['email'],
                            'role_id'   => $role,
                            'id'        => $datalogin['id']
                            // 'id_jabatan'=> $datalogin['id_jabatan']
                        ];
                        $this->session->set_userdata($data);
                        if(password_verify($pass,$datalogin['pass'])){
                            if($role == 1){
                                redirect('Admin');
                            }elseif($role == 2){
                                redirect('Operator');
                            }elseif($role == 3){
                                redirect('User');
                            }elseif($role == 4){
                                redirect('Direktur');
                            }elseif($role == 5){
                                redirect('Wadir');
                            }elseif($role == 6){
                                redirect('Adum');
                            }elseif($role == 7){
                                redirect('admin_kepeg');
                            }else{
                                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Account Anda Belum Memiliki Hak Akses !!
                                </div>');
                                redirect('Auth');     
                            }
                        }else{
                            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                               Password Yang Anda Masukan Salah!!
                            </div>');
                            redirect('Auth');
                        }  
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

    public function pilih_Role($param=""){
        if($param){
            if($param==1){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="Admin";
            }elseif($param==2){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="Operator";
            }elseif($param==3){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="User";
            }elseif($param==4){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="Direktur";
            }elseif($param==5){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="Wadir";
            }elseif($param==6){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="Adum";
            }elseif($param==7){
                $email=$this->session->userdata('email');
                $role_id=$param;
                $id=$this->session->userdata('id');
                $redirect="admin_kepeg";
            }
            $datasession=[
                'email'     => $email,
                'role_id'   => $role_id,
                'id'        => $id
            ];
            $this->session->set_userdata($datasession);
            redirect($redirect);
        }else{
            $id= $this->session->userdata('id');  
            $dtdirektur=$this->login_Mod->get_direktur($id);
            $dtadmin=$this->login_Mod->get_admin($id);
            $dtsekretaris=$this->login_Mod->get_sekretaris($id);
            $dtwadir=$this->login_Mod->get_wadir($id);
            $dtadum=$this->login_Mod->get_adum($id);
            $dtpegawai=$this->login_Mod->get_pegawai($id);
            $dtadminkepeg=$this->login_Mod->get_adminkepeg($id);

            $data['pilih_akun']=1;
            if($dtadmin){
                $data['admin']=$dtadmin[0]->role_id;
            }
            if($dtdirektur){
                $data['direktur']=$dtdirektur[0]->role_id;
            }
            if($dtsekretaris){
                $data['sekretaris']=$dtsekretaris[0]->role_id;
            }
            if($dtwadir){
                $data['wadir']=$dtwadir[0]->role_id;
                $data['jabatan_wadir']=$dtwadir[0]->jabatan;
            }
            if($dtadum){
                $data['adum']=$dtadum[0]->role_id;
            }
            if($dtpegawai){
                $data['pegawai']=$dtpegawai[0]->role_id;   
            }
            if($dtadminkepeg){
                $data['adminkepeg']=$dtadminkepeg[0]->role_id;   
            }
            $this->index($data);
        } 
    }
}

?>