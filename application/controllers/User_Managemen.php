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
    public function addform($id){
      if($id==2){
        $judul="User Managemen";
        $halaman='user_maneg/add_operator';
        $data['id']=$id;
        $this->template->TemplateGen($judul,$halaman,$data);  
      }elseif($id==3){
        $judul="User Managemen";
        $halaman='user_maneg/add_user';
        $data['id']=$id;
        $data['list_jabatan']=$this->user_Mod->get_all_jabatan();
        $this->template->TemplateGen($judul,$halaman,$data);  
      }else{
        redirect("User_Managemen");
      }
    }
    public function add_operator($id){
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
            $this->addform($id);
        }else{
            $data=[
                'id'        =>'' ,
                'fullname'  =>$this->input->post('fullname',true),
                'email'     =>$this->input->post('email',true),
                'is_active' => 1,
                'image'     => "default.png",
                'pass'      =>password_hash($this->input->post('pass1',true), PASSWORD_DEFAULT),
                'date_created'=> time(),
                'role_id'   => 2
            ];
            //passwor operator= operator12345
            
            if($this->user_Mod->Add_Admin($data)){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Menambahkan Operator Baru 
                </div>');
               redirect("User_Managemen/list_all_user/$id");
            }else{
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan Operator Baru
                </div>');  
                redirect("User_Managemen/list_all_user/$id");
            }
        }
    }
    
    public function delOP($idop,$id){
        if($this->user_Mod->del_Admin($idop)== true){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus Operator
            </div>');  
            redirect("User_Managemen/list_all_user/$id");
        }else{
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Gagal Menghapus Operator 
            </div>');  
            redirect("User_Managemen/list_all_user/$id");
        }    
     }

     public function add_user($id){
        $this->form_validation->set_rules('fullname','Fullname','required|trim'
        ,['required'=> 'Field  Nama Lengkap Tidak Boleh Kosong']);
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]' ,[
            'required'=> 'Field  Email  Tidak Boleh Kosong',
            'valid_email'=> 'Email yang dimasukan Salah',
            'is_unique'=> 'Email Sudah Terdaftar di Database' ]);
        $this->form_validation->set_rules('pass','Pass','required|trim|min_length[6]|matches[pass1]',
            ['required'=>'Password Tidak Boleh Kosong',
            'min_length'=> 'Password Harus Lebih dari 6 Karakter',
            'matches'=> 'Password yang Di Inputkan Tidak sama']); 
        $this->form_validation->set_rules('pass1','Pass1','required|trim|min_length[6]|matches[pass]',
            ['required'=>'Password Verification Tidak Boleh Kosong',
            'min_length'=> 'Password Harus Lebih dari 6 Karakter',
            'matches'=> 'Password yang Di Inputkan Tidak sama']);    
        $this->form_validation->set_rules('id_jabatan','Id_jabatan','required|is_unique[user.id_jabatan]',
            ['required'=>'Jabatan User Belum di Pilih, Silahkan Pilih jabatan',
            'is_unique'=>'Jabatan yang di Pilih Sudah Digunakan']);    
        if ($this->form_validation->run() == FALSE){
            $this->addform($id);
        }else{
            $data=[
                'id'        =>'' ,
                'fullname'  =>$this->input->post('fullname',true),
                'email'     =>$this->input->post('email',true),
                'is_active' => 1,
                'image'     => "default.png",
                'pass'      =>password_hash($this->input->post('pass1',true), PASSWORD_DEFAULT),
                'date_created'=> time(),
                'role_id'   => 3,
                'id_jabatan'=>$this->input->post('id_jabatan',true)
            ];
            //passwor operator= operator12345
            
            if($this->user_Mod->Add_Admin($data)){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Menambahkan User Baru 
                </div>');
               redirect("User_Managemen/list_all_user/$id");
            }else{
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan User Baru
                </div>');  
                redirect("User_Managemen/list_all_user/$id");
            }
        }
    }
    public function delUser($iduser,$id){
        if($this->user_Mod->del_Admin($iduser)== true){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus User
            </div>');  
            redirect("User_Managemen/list_all_user/$id");
        }else{
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Gagal Menghapus User 
            </div>');  
            redirect("User_Managemen/list_all_user/$id");
        }    
     }

     public function getJabatanlike(){
         $jabatan=$this->input->post('jbtn',true);
            echo json_encode($this->user_mod->getJabatanlike($jabatan));
        }
      
    public function get_operatorBYid(){
        $data=[
            'id'=>$this->input->post('idop',true)
        ];
       echo json_encode ($this->user_Mod->get_admin_BYID($data));
    }    

    public function edit_operator($idrl){
        $this->form_validation->set_rules('pass1','Pass1','required|trim|min_length[6]',
        ['required'=>'Password Tidak Boleh Kosong',
        'min_length'=> 'Password Harus Lebih dari 6 Karakter']     
        );     

        if($this->form_validation->run() == FALSE){
            $this->list_all_user($idrl);
        }else{
            $id=$this->input->post('id',true);
            $data =[
                'pass'=>password_hash($this->input->post('pass1',true),PASSWORD_DEFAULT) 
            ];
            $in=$this->user_Mod->editAdmin($id,$data);

            if($in == true){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Mengubah Password Operator 
                </div>');
                redirect("User_Managemen/list_all_user/$idrl");
            }else{
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    gagal Ubah Password Operator 
                </div>');
                redirect("User_Managemen/list_all_user/$idrl");
            }
        }
    }

    public function ubah_isactiveUser(){
            $is_active=$this->input->post('idst',true);
            $id=$this->input->post('id_user',true);
            if($is_active == 1){
                $data=[
                    'is_active'=> 0
            ];
                if($this->user_Mod->change_isactive_User($data,$id)== true){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil  NON aktivkan User
                    </div>');
                }else{
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Gagal NON aktivkan User
                    </div>');
                }
            }else{
                $data=[
                    'is_active'=> 1
            ];
                if($this->user_Mod->change_isactive_User($data,$id)== true){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Mengaktivkan User
                    </div>');
                }else{
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Gagal Mengaktivkan User
                    </div>');
            }
            }
        }

        public function edit_user($iduser,$id){
            $judul="User Managemen";
            $halaman='user_maneg/edit_usr';
            $data['id']=$id;
            $data['list_jabatan']=$this->user_Mod->get_all_jabatan();
            $data1=[
                'id'=>$iduser,
                'role_id'=>3
            ];
           if($data['pegawai']=$this->user_Mod->get_userPEg_BYID($data1)) {
               $this->template->TemplateGen($judul,$halaman,$data);
           }else{
               redirect('Blank_page');
           }
        }
        public function do_edit_user(){
                print_r($this->input->post());
        }

        public function do_edit_uploadimage(){
           print_r($this->input->post());
        }
}
?>