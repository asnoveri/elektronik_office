<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Managemen extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_mod');
        is_login();
      
    }

    public function index($param=""){
        if($param=='listuser'){
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
                                        <button  class="dropdown-item sel1" values="1"  data-id='.$data->id.'> Aktiv </button>
                                        <button  class="dropdown-item sel2" values="0" data-id='.$data->id.'> Non Aktiv </button>
                                    </div>    
                            </div>';
                                
                $json[]=[
                    $no++,
                    $data->fullname,
                    $data->user_name,  
                    $data->email,
                    $status,
                    '<img class="img-profile rounded-circle mx-auto d-block" width="50" src="'.base_url().'assets/images/'.$data->image.'">',
                    '<div class="btn-group-vertical w-100">
                    <button type="button" class="btn btn-success  edtpswd"  data-id='.$data->id.'>Edit kataSandi</button>
                    <a href="'.base_url().'User_Managemen/edit_user/'.$data->id.'" type="button" class="btn btn-warning"  data-id='.$data->id.'>Edit</a>
                    <a href="'.base_url().'User_Managemen/delUser/'.$data->id.'" type="button" class="btn btn-danger" data-id='.$data->id.'>Delete</a>
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
        $judul="User Managemen";
        $halaman='user_maneg/index';
        $this->template->TemplateGen($judul,$halaman);  
    }

     public function add_user(){
        $this->form_validation->set_rules('fullname','Fullname','required|trim'
        ,['required'=> 'Field  Nama Lengkap Tidak Boleh Kosong']);
        $this->form_validation->set_rules('user_name','User_name','trim|min_length[3]|alpha_dash|required',
            [ 'required'=> 'User Name  Tidak Boleh Kosong',
            'min_length'=> 'User Name Harus Lebih dari 3 Karakter',
            'alpha_dash'=>'User Name Tidak Mengizinkan Spasi Pada Karakter Yang di Masukkan']); 
        $this->form_validation->set_rules('email','Email','trim|valid_email|is_unique[user.email]' ,[
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
            $cek_user=$this->input->post('user_name',true);
            if($this->user_Mod->cek_username($cek_user)==true){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Menambahkan User Karena User Name Sudah Digunakan... 
                </div>');
               redirect("User_Managemen");
            }else{
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
    }
    public function delUser($iduser){
        $cek_user=$this->user_Mod->get_user($iduser);
        if($this->user_Mod->del_User($iduser)== true){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus User '.$cek_user.'
            </div>');  
            redirect("User_Managemen");
        }else{
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Gagal Menghapus User '.$cek_user.' 
            </div>');  
            
            redirect("User_Managemen");
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

        public function edit_user($id){
            $judul="User Managemen";
            $halaman='user_maneg/edit_usr';
            $data['user']=$this->user_Mod->get_userEdit($id);
            $this->template->TemplateGen($judul,$halaman,$data);
        
        }

        public function do_edit_user(){
            $id= $this->input->post('id',true);
            $this->form_validation->set_rules('fullname','Fullname','required|trim'
            ,['required'=> 'Field  Nama Lengkap Tidak Boleh Kosong']);
            $this->form_validation->set_rules('user_name','User_name','trim|min_length[3]|alpha_dash|required',
            [ 'required'=> 'User Name  Tidak Boleh Kosong',
            'min_length'=> 'User Name Harus Lebih dari 3 Karakter',
            'alpha_dash'=>'User Name Tidak Mengizinkan Spasi Pada Karakter Yang di Masukkan']); 
            $this->form_validation->set_rules('email','Email','trim|valid_email',[
                'valid_email'=> 'Email yang dimasukan Salah' ]);
            if ($this->form_validation->run() == FALSE){
                $this->edit_user($id);
            }else{
                $data=[
                    'fullname'  =>$this->input->post('fullname',true),
                    'user_name' =>$this->input->post('user_name',true),
                    'email'     =>$this->input->post('email',true)
                
                ];
                        if($this->user_Mod->edit_userBYid($data,$id)){
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Berhasil edit User  
                            </div>');
                           redirect("User_Managemen/edit_user/$id");
                        }else{
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Gagal edit User  
                            </div>');
                           redirect("User_Managemen/edit_user/$id");
                        }
            }
        }

        public function do_edit_uploadimage(){
           $id= $this->input->post('id',true);
           $data=$this->user_Mod->get_userEdit($id);
           
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


    public function list_op($param=""){
        if($param=='listoprator'){
        $length= intval($this->input->post('length'));
        $start= intval($this->input->post('start'));
        $draw= intval($this->input->post('draw'));
        $order= $this->input->post('order');
        $search= $this->input->post('search');
        $search = $search['value'];
        $col=0;
        $dir="";
        $id=2;
            if(!empty($order)){
                foreach($order as $or){
                    $dir = $or['dir'];
                }
            }
            if($dir!='asc' && $dir!='desc'){
                $dir='desc';
            }

        $data=$this->user_Mod->get_allpenguna($length,$start,$dir,$search,$id);
        $json = [];
        $no=1+$start;
        foreach($data as $row){
            $json[]=[
                $no++,
                $row->fullname,
                $row->user_name,  
                $row->email,
                '<div class="btn-group-vertical w-100">
                <a href="'.base_url().'User_Managemen/delSekre/'.$row->id.'/'.$row->id_penguna.'" type="button" class="btn btn-warning" >Delete</a>
                </div>'
            ];
        }
        $tot1=$this->user_mod->get_allpengunan_count($id);
        $tot=count($tot1);
        $respon['draw']=$draw;
        $respon['recordsTotal']=$tot;
        $respon['recordsFiltered']=$tot;
        $respon['data']=$json;
        echo json_encode($respon);die();
        }
            $judul="User Managemen";
            $halaman='user_maneg/list_op';
            $this->template->TemplateGen($judul,$halaman);  
    }


    public function ubahaPswd(){
        $id= $this->input->post('id',true);
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
                'pass'      =>password_hash($this->input->post('pass1',true), PASSWORD_DEFAULT),
            ];
                    if($this->user_Mod->edit_userBYid($data,$id)){
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil edit Kata sandi User  
                        </div>');
                       redirect("User_Managemen");
                    }else{
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Gagal edit Kata Sandi User  
                        </div>');
                       redirect("User_Managemen");
                    }
        }
    }

    public function delSekre($iduser,$id_penguna){
        $cek_user=$this->user_Mod->get_user($iduser);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus '.$cek_user.' Sebagai Sekretaris
            </div>');  
               redirect("User_Managemen/list_op");
        }else{
            $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus '.$cek_user.' Sebagai Sekretaris
                </div>');  
                redirect("User_Managemen/list_op");
        }  
    }  

    public function get_alluser_combobox(){
        $search=$this->input->post('searchTerm');
        $data=$this->user_Mod->get_alluser_combobox($search,);
        foreach($data as $row){
            $json[]=[
               "id"      => $row->id,
               "text"    => $row->fullname,
            ];
        }
        echo json_encode($json);die();
    }

    public function add_sekretaris(){
        $this->form_validation->set_rules('pegawai','Pegawai','required|trim',
            ['required'=>'Pegawai Belum Di Pilih']); 
            if ($this->form_validation->run() == FALSE){
                $this->list_op();
            }else{
                $id=$this->input->post('pegawai',true);
                $cek_user=$this->user_Mod->get_user($id);
                $role_id=2;
                if($this->user_mod->get_penguna_BYID($id,$status=1,$role_id)){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Gagal Menambahkan  '.$cek_user.' Sebagai Sekretaris Karena '.$cek_user.' Sudah Terdaftar Sebagai Sekretaris
                    </div>');  
                    redirect("User_Managemen/list_op");
                }elseif($cekpenguna=$this->user_mod->get_penguna_BYID($id,$status=0,$role_id)){
                    $id_penguna=$cekpenguna->id_penguna;
                        $data=[
                            'status'=>1
                            ];  
                        if($this->user_Mod->ubahstatus($id_penguna,$data)){
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai Sekretaris
                            </div>');  
                            redirect("User_Managemen/list_op");
                        }
                }elseif($this->user_mod->get_penguna_BYID($id,$status='',$role_id)==false){  
                            $data=[
                                'id'=>$id,
                                'role_id'=>2,
                                'status'=>1
                            ];
                        if($this->user_Mod->Add_Penguna($data)){
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  '.$cek_user.' Sebagai Sekretaris
                        </div>');  
                        redirect("User_Managemen/list_op");
                    }
                }
            }
            
    }

    public function listdirektur($param=""){
        if($param=='listdirek'){
            $length= intval($this->input->post('length'));
            $start= intval($this->input->post('start'));
            $draw= intval($this->input->post('draw'));
            $order= $this->input->post('order');
            $search= $this->input->post('search');
            $search = $search['value'];
            $col=0;
            $dir="";
            $id=4;
                if(!empty($order)){
                    foreach($order as $or){
                        $dir = $or['dir'];
                    }
                }
                if($dir!='asc' && $dir!='desc'){
                    $dir='desc';
                }
    
            $data=$this->user_Mod->get_allpenguna($length,$start,$dir,$search,$id);
            $json = [];
            $no=1+$start;
            foreach($data as $row){
                $json[]=[
                    $no++,
                    $row->fullname,
                    $row->user_name,  
                    $row->email,
                    '<div class="btn-group-vertical w-100">
                    <a href="'.base_url().'User_Managemen/deldirek/'.$row->id.'/'.$row->id_penguna.'" type="button" class="btn btn-warning" >Delete</a>
                    </div>'
                ];
            }
            $tot1=$this->user_mod->get_allpengunan_count($id);
            $tot=count($tot1);
            $respon['draw']=$draw;
            $respon['recordsTotal']=$tot;
            $respon['recordsFiltered']=$tot;
            $respon['data']=$json;
            echo json_encode($respon);die();
        }
        $judul="User Managemen";
        $halaman='user_maneg/listdirut';
        $this->template->TemplateGen($judul,$halaman);  
    }
    

    public function deldirek($iduser,$id_penguna){
        $cek_user=$this->user_Mod->get_user($iduser);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus '.$cek_user.' Sebagai Direktur
            </div>');  
               redirect("User_Managemen/listdirektur");
        }else{
            $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus '.$cek_user.' Sebagai Direktur
                </div>');  
                redirect("User_Managemen/listdirektur");
        }  
    }

    public function addDirektur(){
        $this->form_validation->set_rules('pegawai','Pegawai','required|trim',
            ['required'=>'Pegawai Belum Di Pilih']); 
            if ($this->form_validation->run() == FALSE){
                $this->listdirektur();
            }else{       
                $id=$this->input->post('pegawai',true);
                $cek_user=$this->user_Mod->get_user($id);
                $role_id=4;
                if($this->user_mod->get_penguna_BYID($id,$status=1,$role_id)){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Gagal Menambahkan  '.$cek_user.' Sebagai Direktur Karena '.$cek_user.' Sudah Terdaftar Sebagai Direktur
                    </div>');  
                    redirect("User_Managemen/listdirektur");
                }elseif($cekpenguna=$this->user_mod->get_penguna_BYID($id,$status=0,$role_id)){
                    $id_penguna=$cekpenguna->id_penguna;
                        $data=[
                            'status'=>1
                            ];  
                        if($this->user_Mod->ubahstatus($id_penguna,$data)){
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai Direktur
                            </div>');  
                            redirect("User_Managemen/list_op");
                        }
                }elseif($this->user_mod->get_penguna_BYID($id,$status='',$role_id)==false){  
                            $data=[
                                'id'=>$id,
                                'role_id'=>4,
                                'status'=>1
                            ];
                        if($this->user_Mod->Add_Penguna($data)){
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  '.$cek_user.' Sebagai Direktur 
                        </div>');  
                        redirect("User_Managemen/listdirektur");
                    }
                }
            }
    }
}
?>