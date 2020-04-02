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
        $this->template->TemplateGen($judul,$halaman);  
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

     public function add_user(){
        $this->form_validation->set_rules('fullname','Fullname','required|trim'
        ,['required'=> 'Field  Nama Lengkap Tidak Boleh Kosong']);
        $this->form_validation->set_rules('user_name','User_name','required|trim|min_length[3]',
            ['required'=>'User Name Tidak Boleh Kosong',
            'min_length'=> 'User Name Harus Lebih dari 3 Karakter',
            'matches'=> 'Kata Sandi yang Di Inputkan Tidak sama']); 
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]' ,[
            'required'=> 'Field  Email  Tidak Boleh Kosong',
            'valid_email'=> 'Email yang dimasukan Salah',
            'is_unique'=> 'Email Sudah Terdaftar di Database' ]);
        $this->form_validation->set_rules('pass','Pass','required|trim|min_length[6]|matches[pass1]',
            ['required'=>'Kata Sandi Tidak Boleh Kosong',
            'min_length'=> 'Kata Sandi Harus Lebih dari 6 Karakter',
            'matches'=> 'Kata Sandi yang Di Inputkan Tidak sama']); 
        $this->form_validation->set_rules('pass1','Pass1','required|trim|min_length[6]|matches[pass]',
            ['required'=>'Ulang Kata Sandi Tidak Boleh Kosong',
            'min_length'=> 'Kata Sandi Harus Lebih dari 6 Karakter',
            'matches'=> 'Kata Sandi yang Di Inputkan Tidak sama']);    
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $data=[
                'id'        =>'' ,
                'fullname'  =>$this->input->post('fullname',true),
                'user_name'  =>$this->input->post('user_name',true),
                'email'     =>$this->input->post('email',true),
                'is_active' => 1,
                'image'     => "default.png",
                'pass'      =>password_hash($this->input->post('pass1',true), PASSWORD_DEFAULT),
                'date_created'=> time()
            ];
            //passwor operator= operator12345
            
            if($this->user_Mod->Add_user($data)){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Menambahkan User Baru 
                </div>');
               redirect("User_Managemen");
            }else{
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan User Baru
                </div>');  
                redirect("User_Managemen");
            }
        }
    }
    public function delUser($iduser){
        if($this->user_Mod->del_User($iduser)== true){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus User
            </div>');  
            redirect("User_Managemen");
        }else{
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Gagal Menghapus User 
            </div>');  
            redirect("User_Managemen");
        }    
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
            if($idrl==2){
                $type_user="Operator";
            }else if($idrl==3){
                $type_user="User";
            }
            if($in == true){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Mengubah Password ' . $type_user.'
                </div>');
                redirect("User_Managemen/list_all_user/$idrl");
            }else{
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    gagal Ubah Password '   . $type_user.'
                </div>');
                redirect("User_Managemen/list_all_user/$idrl");
            }
        }
    }

    public function ubah_isactiveUser(){
        $id=$this->input->post('id',true);
        $is_active=$this->input->post('status'); 
        // echo json_encode($is_active);die();
        if($is_active == 0){
            $data=[
                'is_active'=> 0
            ];
            // echo json_encode($data);die();    
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
            }elseif($is_active == 1){
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
            $data['iduser']=$iduser;
            $data['list_jabatan']=$this->user_Mod->get_all_jabatan();
            $data1=[
                'id'=>$iduser,
                'role_id'=>$id
            ];
           if($data['pegawai']=$this->user_Mod->get_userPEg_BYID($data1)) {
               $this->template->TemplateGen($judul,$halaman,$data);
           }else{
               redirect('Blank_page');
           }
        }


        public function do_edit_user(){
            $id= $this->input->post('idgambar',true);
            $role_id= $this->input->post('role_id',true);
            $this->form_validation->set_rules('fullname','Fullname','required|trim'
            ,['required'=> 'Field  Nama Lengkap Tidak Boleh Kosong']);
            $this->form_validation->set_rules('email','Email','trim|required|valid_email',[
                'required'=> 'Field  Email  Tidak Boleh Kosong',
                'valid_email'=> 'Email yang dimasukan Salah' ]);
                
            if ($this->form_validation->run() == FALSE){
                $this->edit_user($id,$role_id);
            }else{
                $data=[
                    'fullname'  =>$this->input->post('fullname',true),
                    'email'     =>$this->input->post('email',true),
                    'is_active' => 1,
                    'role_id'   => $role_id
                ];
                        if($this->user_Mod->edit_pegawaiBYid($data,$id,$role_id)){
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Berhasil edit User  
                            </div>');
                           redirect("User_Managemen/edit_user/$id/$role_id");
                        }else{
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Gagal edit User  
                            </div>');
                           redirect("User_Managemen/edit_user/$id/$role_id");
                        }
            }
        }

        public function do_edit_uploadimage(){
           $id= $this->input->post('idgambar',true);
           $role_id= $this->input->post('role_id',true);
           $data1=[
            'id'=>$id,
            'role_id'=>$role_id
        ];
           $data=$this->user_Mod->get_userPEg_BYID($data1);
          
           //mencek jika ada gambar yang akan di upload
            $upload_image = $_FILES["gambar"]["name"];
            if($upload_image){
                $config['upload_path']          = "./assets/images/";
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 3072;
                $config['remove_spaces']        = true;
                
                //memangil libraires upload dan masukan configurasinya
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('gambar')) {
                    $error =$this->upload->display_errors();
                    $this->session->set_flashdata('erorogbr','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                     .$error.    
                    '</div>');
                       
                    }else {
                        $old_images=$data->image;
                        
                        //mencek images lama yang tersimpan di drektory sistem tidak sama dengan  default.jpg
                       if($old_images != 'default.png'){
                        //   jika tidak sama hapus image selain default.jpg
                        unlink(FCPATH.'/assets/images/'.$old_images);
                       }
                        $new_images =[
                            // $this->upload->data('file_name')->untuk mengmbil nama dari file yang di upload
                            'image'=>$this->upload->data('file_name')
                        ];  
                        $this->user_Mod->Update_images($new_images,$id);
                }
            }
        }

        public function ubh_jabtan_user(){
            $ubhjbatan=$this->input->post('jbtn',true);
            $id=$this->input->post('id_user',true);
                if($this->user_Mod->cekPegJabatan($ubhjbatan) == true){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal edit User Karena Jabatan Yang dipilih sudah di Set pada pegawai lain
                    </div>');
                }else{
                    $data=[
                        'id_jabatan'=> $ubhjbatan
                    ];
                    if($this->user_Mod->change_Jabatan_User($data,$id)== true){
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Edit Jabatan User
                        </div>');
                    }
                }

            }
        
    public function get_tesdatatabel(){
        $length=intval($this->input->post('length'));
        $draw=intval($this->input->post('draw'));
        $start=intval($this->input->post('start'));
        $order=$this->input->post('order'); 
        $search=$this->input->post('search');
        $search = $search['value'];
        $col=0;
        $dir="";

            if(!empty($order)){
                foreach($order as $or){
                    $col = $or['column'];
                    $dir = $or['dir'];
                }
            }
           
            if($dir!='asc' && $dir!='desc'){
                $dir = 'desc';
            }

            $valid_columns=[
                1=>'fullname',
                2=>'user_name',
                3=>'email',
                4=>'is_active'
            ];

            if(!isset($valid_columns[$col])){
                $order=null;
            }else{
                $order= $valid_columns[$col];
            }

        $dta=$this->user_Mod->get_all_user($length,$start,$order,$dir,$search);
        $json = [];
        $no=$start+1;
        foreach($dta as $data){
            if($data->is_active==1){
                $sts= "Aktiv";
            }else{
                $sts= "Non Aktiv";
            }
                $status= '<div class="dropdown ">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                                    '.$sts.'
                                </button>  
                                <div class="dropdown-menu">
                                    <button  class="dropdown-item sel1" values="1" data-id='.$data->id.'> Aktiv </button>
                                    <button  class="dropdown-item sel2" values="0" data-id='.$data->id.'> Non Aktiv </button>
                                </div>    
                        </div>';
                            
            $json[]=[
                $no++,
                $data->fullname,
                $data->user_name,  
                $data->email,
                $status,
                '<div class="btn-group w-100">
                <a href="#" type="button" class="btn btn-warning  edt-usr" data-id='.$data->id.'>Edit</a>
                <a href="'.base_url().'User_Managemen/delUser/'.$data->id.'" type="button" class="btn btn-danger   del-usr" data-id='.$data->id.'>Delete</a>
                </div>'
            ];
        }
        $tot=$this->user_Mod->get_all_user_count();
        $respon=[
            'draw'=>$draw,
            'recordsTotal'=>$tot,
            'recordsFiltered'=>$tot,
            'data'=>$json
        ];
        echo json_encode($respon);
        die();
    }
}
?>