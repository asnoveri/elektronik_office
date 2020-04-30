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
        $data=$this->user_Mod->del_User($iduser);
        if($data){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
               Gagal Menghapus User '.$cek_user.' 
            </div>');  
            redirect("User_Managemen");
        }else{
            $this->user_Mod->del_User1($iduser);
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus User '.$cek_user.'
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
                <a href="'.base_url().'User_Managemen/delSekre/'.$row->id.'/'.$row->id_penguna.'/'.$this->user_Mod->get_jabatanOP($row->id_penguna).'" type="button" class="btn btn-warning" >Delete</a>
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

    public function delSekre($iduser,$id_penguna,$id_jabatan){
        $cek_user=$this->user_Mod->get_user($iduser);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->user_Mod->ubahstatusJabatan($id_jabatan,$data);
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
                }
                elseif($cekpenguna=$this->user_mod->get_penguna_BYID($id,$status=0,$role_id)){
                    $id_penguna=$cekpenguna->id_penguna;
                        $data=[
                            'status'=>1
                            ];  
                            $jbt=$this->user_Mod->get_jabatanOPNonAktiv($id_penguna);
                        if($this->user_Mod->ubahstatus($id_penguna,$data)){
                            $this->user_Mod->ubahstatusJabatan($jbt,$data);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai Sekretaris
                            </div>');  
                            redirect("User_Managemen/list_op");
                        }
                }elseif($this->user_mod->get_penguna_BYID($id,$status='',$role_id)==false){  
                        $role_id=2;        
                                $data=[
                                'id'=>$id,
                                'role_id'=>2,
                                'status'=>1,
                                // 'id_unitkerja'=>2
                            ];
                        if($id=$this->user_Mod->Add_Pengunafor_jabatan($data,$role_id)){
                            $datapd=[
                                'id_peguna'=> $id,
                                'id_unitkerja'=>2,
                                'status'=>1
                            ];
                            $this->user_Mod->add_jabatan($datapd);
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  '.$cek_user.' Sebagai Sekretaris
                        </div>');  
                        redirect("User_Managemen/list_op");
                    }
                }
            }
    }

    public function get_alluser_combobox(){
        $search=$this->input->post('searchTerm');
        $data=$this->user_Mod->get_alluser_combobox($search);
        foreach($data as $row){
            $json[]=[
               "id"      => $row->id,
               "text"    => $row->fullname,
            ];
        }
        echo json_encode($json);die();
    }

    public function get_allwadir_combobox(){
        $search=$this->input->post('searchTerm');
        $data=$this->user_Mod->get_allwadir_combobox($search);
        foreach($data as $row){
            $json[]=[
               "id"      => $row->id_unitkerja,
               "text"    => $row->unitkerja,
            ];
        }
        echo json_encode($json);die();
    }

    public function get_allUnit_kerja(){
        $search=$this->input->post('searchTerm');
        $data=$this->user_Mod->get_allUnit_kerja($search);
        foreach($data as $row){
            $json[]=[
               "id"      => $row->id_unitkerja,
               "text"    => $row->unitkerja,
            ];
        }
        echo json_encode($json);die();
    }

    public function get_alljabatan(){
       $unitker= $this->input->post('unitker');
       $search=$this->input->post('searchTerm');    
       $data=$this->user_Mod->get_alljabatan($search,$unitker);
       foreach($data as $row){
           $json[]=[
              "id"      => $row->id_unitkerja,
              "text"    => $row->unitkerja,
           ];
       }
       echo json_encode($json);die();
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
                    <a href="'.base_url().'User_Managemen/deldirek/'.$row->id.'/'.$row->id_penguna.'/'.$this->user_Mod->get_jabatanOP($row->id_penguna).'" type="button" class="btn btn-warning" >Delete</a>
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
    

    public function deldirek($iduser,$id_penguna,$id_jabatan){
        $cek_user=$this->user_Mod->get_user($iduser);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->user_Mod->ubahstatusJabatan($id_jabatan,$data);
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
                $cek_direktur=$this->user_Mod->get_direktur();
                $role_id=4;
                if(count($cek_direktur) >= 1){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Gagal Menambahkan  '.$cek_user.' Sebagai Direktur, Karena Direktur Hanya Bisa digunakan seorang Pegawai/User
                    </div>');  
                    redirect("User_Managemen/listdirektur");
                }elseif(count($cek_direktur) < 1){
                    if($cekpenguna=$this->user_mod->get_penguna_BYID($id,$status=0,$role_id)){
                        $id_penguna=$cekpenguna->id_penguna;
                            $data=[
                                'status'=>1
                                ];  
                                $jbt=$this->user_Mod->get_jabatanOPNonAktiv($id_penguna);
                            if($this->user_Mod->ubahstatus($id_penguna,$data)){
                                $this->user_Mod->ubahstatusJabatan($jbt,$data);
                                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Berhasil Menambahkan  '.$cek_user.' Sebagai Direktur
                                </div>');  
                                redirect("User_Managemen/listdirektur");
                            }
                    }elseif($this->user_mod->get_penguna_BYID($id,$status='',$role_id)==false){  
                        $role_id=4;      
                            $data=[
                                'id'=>$id,
                                'role_id'=>4,
                                'status'=>1,
                            ];
                            if($id=$this->user_Mod->Add_Pengunafor_jabatan($data,$role_id)){
                                $datapd=[
                                    'id_peguna'=> $id,
                                    'id_unitkerja'=>1,
                                    'nama_jabatan'=>1,
                                    'status'=>1
                                ];
                                $this->user_Mod->add_jabatan($datapd);
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

    public function listwadir($param=""){
        if($param=='listwadir'){
            $length= intval($this->input->post('length'));
            $start= intval($this->input->post('start'));
            $draw= intval($this->input->post('draw'));
            $order= $this->input->post('order');
            $search= $this->input->post('search');
            $search = $search['value'];
            $col=0;
            $dir="";
            $id=5;
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
                $jabatan=$this->user_Mod->get_jabatanWadir($row->id_penguna);
                $json[]=[
                    $no++,
                    $row->fullname,
                    $row->user_name,  
                    $row->email,
                    '<div class="btn-group-vertical w-100">
                        <button class="btn btn-primary btn-sm"> '.$jabatan->unitkerja.' </button>
                    </div>',
                    '<div class="btn-group-vertical w-100">
                        <a href="'.base_url().'User_Managemen/delwadir/'.$row->id.'/'.$row->id_penguna.'/'.$jabatan->id_jabatan.'/'.$jabatan->nama_jabatan.'" type="button" class="btn btn-warning" >Delete</a>
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
        $halaman='user_maneg/list_wadir';
        $this->template->TemplateGen($judul,$halaman);  
    }

    public function delwadir($iduser,$id_penguna,$id_jabatan,$nama_jabatan){
        $cek_user=$this->user_Mod->get_user($iduser);
        $cek_wadir=$this->user_Mod->get_wadir($nama_jabatan);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->user_Mod->ubahstatusJabatan($id_jabatan,$data);
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus '.$cek_user.' Sebagai '.$cek_wadir->unitkerja.'
            </div>');  
               redirect("User_Managemen/listwadir");
        }else{
            $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus '.$cek_user.' Sebagai '.$cek_wadir->unitkerja.'
                </div>');  
                redirect("User_Managemen/listwadir");
        }  
    }


    public function add_wadir(){
        $this->form_validation->set_rules('pegawai','Pegawai','required|trim',
            ['required'=>'Pegawai Belum Di Pilih']); 
        $this->form_validation->set_rules('jabatan','Jabatan','required|trim',
            ['required'=>'Jabatan Belum Di Pilih']); 
            if ($this->form_validation->run() == FALSE){
                $this->listwadir();
            }else{       
                $id=$this->input->post('pegawai',true);
                $jabatan=$this->input->post('jabatan',true);
                $cek_user=$this->user_Mod->get_user($id);
                $cek_wadir=$this->user_Mod->get_wadir($jabatan);
                $cek_jabatan=$this->user_Mod->get_cek_jabatan_user($jabatan);
                $role_id=5;
                $pegu=$this->user_mod->get_penguna_BYID($id,$status=1,$role_id);
                if($pegu){
                    $peg=$this->user_Mod->get_jabatanWadir($pegu->id_penguna);
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Gagal Menambahkan  '.$cek_user.' Sebagai '.$cek_wadir->unitkerja.' Karena  Sudah Terdaftar Sebagai '.$peg->unitkerja.'
                    </div>');  
                    redirect("User_Managemen/listwadir");
                }elseif($cek_jabatan){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Gagal Menambahkan  '.$cek_user.' Sebagai '.$cek_wadir->unitkerja.' Karena  Sudah digunakan Pegawai/User Lain
                    </div>');  
                    redirect("User_Managemen/listwadir");
                }elseif($cekpenguna=$this->user_mod->get_penguna_BYID($id,$status=0,$role_id)){
                    $id_penguna=$cekpenguna->id_penguna;
                    $peg=$this->user_Mod->get_jabatanWadrinonaktiv($id_penguna);
                        $data=[
                            'status'=>1
                            ];  
                        if($this->user_Mod->ubahstatus($id_penguna,$data)){
                            $this->user_Mod->ubahstatusJabatan($peg->id_jabatan,$data);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cek_wadir->unitkerja.'
                            </div>');  
                            redirect("User_Managemen/listwadir");
                        }
                }elseif($this->user_mod->get_penguna_BYID($id,$status='',$role_id)==false){  
                            $role_id=5;
                            $data=[
                                'id'=>$id,
                                'role_id'=>5,
                                'status'=>1
                            ];
                         if($id=$this->user_Mod->Add_Pengunafor_jabatan($data,$role_id)){
                            $datajbt=[
                                'id_peguna'=> $id,
                                'id_unitkerja'=>14,
                                'nama_jabatan'=>$jabatan,
                                'status'=>1
                            ];
                            $this->user_Mod->add_jabatan($datajbt);
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  '.$cek_user.' Sebagai  '.$cek_wadir->unitkerja.'
                        </div>');  
                        redirect("User_Managemen/listwadir");
                    }
                }
            }
    }

    public function Adum($param=""){
        if($param=='listadum'){
            $length= intval($this->input->post('length'));
            $start= intval($this->input->post('start'));
            $draw= intval($this->input->post('draw'));
            $order= $this->input->post('order');
            $search= $this->input->post('search');
            $search = $search['value'];
            $col=0;
            $dir="";
            $id=6;
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
                    <a href="'.base_url().'User_Managemen/deladum/'.$row->id.'/'.$row->id_penguna.'/'.$this->user_Mod->get_jabatanOP($row->id_penguna).'" type="button" class="btn btn-warning" >Delete</a>
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
        $halaman='user_maneg/list_adum';
        $this->template->TemplateGen($judul,$halaman);
    }

    public function deladum($iduser,$id_penguna,$id_jabatan){
        $cek_user=$this->user_Mod->get_user($iduser);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->user_Mod->ubahstatusJabatan($id_jabatan,$data);
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus '.$cek_user.' Sebagai Adum
            </div>');  
               redirect("User_Managemen/Adum");
        }else{
            $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus '.$cek_user.' Sebagai Adum
                </div>');  
                redirect("User_Managemen/Adum");
        }  
    }

    public function add_adum(){
        $this->form_validation->set_rules('pegawai','Pegawai','required|trim',
        ['required'=>'Pegawai Belum Di Pilih']); 
        if ($this->form_validation->run() == FALSE){
            $this->Adum();
        }else{       
            $id=$this->input->post('pegawai',true);
            $cek_user=$this->user_Mod->get_user($id);
            $cek_adum=$this->user_Mod->get_adum();
            $role_id=6;
            if(count($cek_adum) >= 1){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan  '.$cek_user.' Sebagai Adum, Karena Adum Hanya Bisa digunakan seorang Pegawai/User
                </div>');  
                redirect("User_Managemen/Adum");
            }elseif(count($cek_adum) < 1){
                if($cekpenguna=$this->user_mod->get_penguna_BYID($id,$status=0,$role_id)){
                    $id_penguna=$cekpenguna->id_penguna;
                        $data=[
                            'status'=>1
                            ];  
                            $jbt=$this->user_Mod->get_jabatanOPNonAktiv($id_penguna);
                        if($this->user_Mod->ubahstatus($id_penguna,$data)){
                            $this->user_Mod->ubahstatusJabatan($jbt,$data);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai Adum
                            </div>');  
                            redirect("User_Managemen/Adum");
                        }
                }elseif($this->user_mod->get_penguna_BYID($id,$status='',$role_id)==false){  
                    $role_id=6;      
                        $data=[
                            'id'=>$id,
                            'role_id'=>6,
                            'status'=>1
                        ];
                        if($id=$this->user_Mod->Add_Pengunafor_jabatan($data,$role_id)){
                            $datapd=[
                                'id_peguna'=> $id,
                                'id_unitkerja'=>2,
                                'status'=>1,
                                'nama_jabatan'=>46
                            ];
                            $this->user_Mod->add_jabatan($datapd);
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  '.$cek_user.' Sebagai Adum 
                        </div>');  
                        redirect("User_Managemen/Adum");
                    }
                }
            }
        }
    }

    public function list_pegawai($param=''){
        if($param=='data_pegawai'){
            $length= intval($this->input->post('length'));
            $start= intval($this->input->post('start'));
            $draw= intval($this->input->post('draw'));
            $order= $this->input->post('order');
            $search= $this->input->post('search');
            $search = $search['value'];
            $col=0;
            $dir="";
            $id=3;
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
                    ' <span class="badge  badge-light text-left">'.unitkerja($row->id_penguna).'</span>',
                    ' <span class="badge  badge-light text-left">'.jabatanget($row->id_penguna).'</span>',
                    '<div class="btn-group-vertical w-100">
                    <a href="'.base_url().'User_Managemen/del_pegawai/'.$row->id.'/'.$row->id_penguna.'" type="button" class="btn btn-warning" >Delete</a>
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
        $halaman='user_maneg/List_pegawai';
        $this->template->TemplateGen($judul,$halaman);
    }

    public function del_pegawai($id,$id_penguna){
        $cek_user=$this->user_Mod->get_user($id);
        $data=[
            'status'=>0
        ];
        if($this->user_Mod->ubahstatus($id_penguna,$data)){
            $this->user_Mod->ubahstatusJabatanByidpenguna($id_penguna,$data);
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus '.$cek_user.' Sebagai Pegawai
            </div>');  
               redirect("User_Managemen/list_pegawai");
        }else{
            $this->session->set_flashdata('pesantambah','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus '.$cek_user.' Sebagai Pegawai
                </div>');  
                redirect("User_Managemen/list_pegawai");
        }
    }

    public function add_pegawai(){
        $this->form_validation->set_rules('pegawai','Pegawai','required|trim',
            ['required'=>'Pegawai Belum Di Pilih']); 
        $this->form_validation->set_rules('unitkerja','Unitkerja','required|trim',
            ['required'=>'Unit Kejra Belum Di Pilih']); 
        $this->form_validation->set_rules('jabatan','Jabatan','required|trim',
            ['required'=>'Jabatan Belum Di Pilih']); 
            if ($this->form_validation->run() == FALSE){
                $this->list_pegawai();
            }else{  
                $pegawai=$this->input->post('pegawai',true);
                $cek_user=$this->user_Mod->get_user($pegawai);
                $unitkerja=$this->input->post('unitkerja',true);
                $jabatan=$this->input->post('jabatan',true);
                $cekJabatan=$this->user_Mod->get_unitkerjabyID($jabatan);
                $cek_user=$this->user_Mod->get_user($pegawai);
                
                if($jabatan==38 || $jabatan==19 || $jabatan==23 || $jabatan==26 || $jabatan==29 || $jabatan==31 || $jabatan==33 || $jabatan==35 || $jabatan==37 || $jabatan==40 || $jabatan==13){
                    if($JabatanEksis=$this->user_Mod->get_unitkerjaPegawaiBYukp($unitkerja,$status=1,$jabatan)){
                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Menambahkan '.$cek_user.' Sebagai '.$cekJabatan.' Karena Sudah digunakan Pegawai/User
                    </div>');
                    redirect("User_Managemen/list_pegawai");
                    }else{
                        if($penguna=$this->user_Mod->get_penguna_BYID($pegawai,$status=1,$role_id=3)){
                            if($cekunitkerja=$this->user_Mod->get_unitkerjaPegawai($penguna->id_penguna,$unitkerja,$status=1,$jabatan)){
                                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Gagal Menambahkan '.$cek_user.' Sebagai '.$cekJabatan.' Karena Sudah Terdaftar Sebagai '.$cekJabatan.'
                                </div>');
                                redirect("User_Managemen/list_pegawai");
                            }else if($cekunitkerja=$this->user_Mod->get_unitkerjaPegawai($penguna->id_penguna,$unitkerja,$status=0,$jabatan)){
                                $data=[
                                    'status'=>1
                                ];  
                                $this->user_Mod->ubahstatuJBtnByidpengdanIdjabatan($penguna->id_penguna,$unitkerja,$jabatan,$data);
                                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                                </div>');  
                                redirect("User_Managemen/list_pegawai");
                            }else{
                                $data=[
                                'id_peguna'=> $penguna->id_penguna,
                                'id_unitkerja'=>$unitkerja,
                                'nama_jabatan'=>$jabatan,
                                'status'=>1
                                ];
                                $this->user_Mod->add_jabatan($data);
                                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                                </div>');  
                                redirect("User_Managemen/list_pegawai");
                            }
                        }elseif ($pengunatidakAktiv=$this->user_Mod->get_penguna_BYID($pegawai,$status=0,$role_id=3)){
                            if($cekunitkerjatidakAktiv=$this->user_Mod->get_unitkerjaPegawainonAktiv($pengunatidakAktiv->id_penguna,$unitkerja,$status=0,$jabatan)){
                                $data=[
                                    'status'=>1
                                    ];  
                                    if($this->user_Mod->ubahstatus($pengunatidakAktiv->id_penguna,$data)){
                                        $this->user_Mod->ubahstatuJBtnByidpengdanIdjabatan($pengunatidakAktiv->id_penguna,$unitkerja,$jabatan,$data);
                                        $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                                        </div>');  
                                        redirect("User_Managemen/list_pegawai");
                                    }
                            }else{
                                $data=[
                                    'status'=>1
                                    ];  
                                if($this->user_Mod->ubahstatus($pengunatidakAktiv->id_penguna,$data)){
                                $data=[
                                    'id_peguna'=> $pengunatidakAktiv->id_penguna,
                                    'id_unitkerja'=>$unitkerja,
                                    'nama_jabatan'=>$jabatan,
                                    'status'=>1
                                ];
                                $this->user_Mod->add_jabatan($data);
                                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                                </div>');  
                                redirect("User_Managemen/list_pegawai");
                                }
                            }
                        }else {
                            $data=[
                                'id'=>$pegawai,
                                'role_id'=>3,
                                'status'=>1,
                            ];
                            if($id=$this->user_Mod->Add_Pengunafor_jabatan($data,$role_id)){
                                $datapd=[
                                    'id_peguna'=> $id,
                                    'id_unitkerja'=>$unitkerja,
                                    'nama_jabatan'=>$jabatan,
                                    'status'=>1
                                ];
                                $this->user_Mod->add_jabatan($datapd);
                                $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                            </div>');  
                            redirect("User_Managemen/list_pegawai");
                                }
                        }
                    }
                }else{
                    echo "oipi";
                    if($penguna=$this->user_Mod->get_penguna_BYID($pegawai,$status=1,$role_id=3)){
                        if($cekunitkerja=$this->user_Mod->get_unitkerjaPegawai($penguna->id_penguna,$unitkerja,$status=1,$jabatan)){
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Gagal Menambahkan '.$cek_user.' Sebagai '.$cekJabatan.' Karena Sudah Terdaftar Sebagai '.$cekJabatan.'
                            </div>');
                            redirect("User_Managemen/list_pegawai");
                        }else if($cekunitkerja=$this->user_Mod->get_unitkerjaPegawai($penguna->id_penguna,$unitkerja,$status=0,$jabatan)){
                            $data=[
                                'status'=>1
                            ];  
                            $this->user_Mod->ubahstatuJBtnByidpengdanIdjabatan($penguna->id_penguna,$unitkerja,$jabatan,$data);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                            </div>');  
                            redirect("User_Managemen/list_pegawai");
                        }else{
                            $data=[
                            'id_peguna'=> $penguna->id_penguna,
                            'id_unitkerja'=>$unitkerja,
                            'nama_jabatan'=>$jabatan,
                            'status'=>1
                            ];
                            $this->user_Mod->add_jabatan($data);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                            </div>');  
                            redirect("User_Managemen/list_pegawai");
                        }
                    }elseif ($pengunatidakAktiv=$this->user_Mod->get_penguna_BYID($pegawai,$status=0,$role_id=3)){
                        if($cekunitkerjatidakAktiv=$this->user_Mod->get_unitkerjaPegawainonAktiv($pengunatidakAktiv->id_penguna,$unitkerja,$status=0,$jabatan)){
                            $data=[
                                'status'=>1
                                ];  
                                if($this->user_Mod->ubahstatus($pengunatidakAktiv->id_penguna,$data)){
                                    $this->user_Mod->ubahstatuJBtnByidpengdanIdjabatan($pengunatidakAktiv->id_penguna,$unitkerja,$jabatan,$data);
                                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                                    </div>');  
                                    redirect("User_Managemen/list_pegawai");
                                }
                        }else{
                            $data=[
                                'status'=>1
                                ];  
                            if($this->user_Mod->ubahstatus($pengunatidakAktiv->id_penguna,$data)){
                            $data=[
                                'id_peguna'=> $pengunatidakAktiv->id_penguna,
                                'id_unitkerja'=>$unitkerja,
                                'nama_jabatan'=>$jabatan,
                                'status'=>1
                            ];
                            $this->user_Mod->add_jabatan($data);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                            </div>');  
                            redirect("User_Managemen/list_pegawai");
                            }
                        }
                    }else {
                        $data=[
                            'id'=>$pegawai,
                            'role_id'=>3,
                            'status'=>1,
                        ];
                        if($id=$this->user_Mod->Add_Pengunafor_jabatan($data,$role_id)){
                            $datapd=[
                                'id_peguna'=> $id,
                                'id_unitkerja'=>$unitkerja,
                                'nama_jabatan'=>$jabatan,
                                'status'=>1
                            ];
                            $this->user_Mod->add_jabatan($datapd);
                            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  '.$cek_user.' Sebagai '.$cekJabatan.'
                        </div>');  
                        redirect("User_Managemen/list_pegawai");
                            }
                    }
                }
                
                die();
                
            }
    }

    public function penjabat($param=''){
        if($param=='listpjbt'){
            $length= intval($this->input->post('length'));
            $start= intval($this->input->post('start'));
            $draw= intval($this->input->post('draw'));
            $order= $this->input->post('order');
            $search= $this->input->post('search');
            $search = $search['value'];
            $col=0;
            $dir="";
    
            if(!empty($order)){
                    foreach($order as $or){
                        $dir = $or['dir'];
                    }
                }
                if($dir!='asc' && $dir!='desc'){
                    $dir='desc';
                }
    
            $dta=$this->user_Mod->get_all_jabatan($length,$start,$order,$dir,$search);
            $json = [];
            $no=$start+1;
            foreach($dta as $data){                
                if($data->role_id==4){
                    $link="listdirektur";
                }elseif($data->role_id==5){
                    $link="listwadir";
                }elseif($data->role_id==6){
                    $link="Adum";
                }
                $json[]=[
                    $no++,
                    $data->role_name,
                    '<div class="btn-group-vertical w-100">
                    <a href="'.base_url().'User_Managemen/'.$link.'" type="button" class="btn btn-info">Cek '.$data->role_name.'</a>
                    </div>'
                ];
            }
            $tot=count($this->user_Mod->get_all_jabatan_count());
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
        $halaman='user_maneg/list_penjabat';
        $this->template->TemplateGen($judul,$halaman);      
    }
}
?>