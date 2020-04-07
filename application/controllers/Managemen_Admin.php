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
        $data="";
        $this->template->TemplateGen($judul,$halaman,$data);  
    }

    public function get_admin(){
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
                $col = $or['column'];
                $dir = $or['dir'];
            }
        }
        if($dir!='asc' && $dir!='desc'){
            $dir='desc';
        }
        $valid_columns=[
            1=>'fullname',
            2=>'user_name',
            3=>'email',
        ];
        if(!isset($valid_columns[$col])){
            $order=null;
        }else{
            $order= $valid_columns[$col];
        }

        $data=$this->user_mod->get_admin($length,$start,$order,$dir,$search);
        $json=[];
        $no=1+$start;
        foreach($data as $row){
            $json[]=[
                $no++,
                $row->fullname,
                $row->user_name,
                $row->email,
                '<div class="btn-group-vertical w-100">
                <a href="'.base_url().'Managemen_Admin/hapus_admin/'.$row->id.'/'.$row->id_admin.'" type="button" class="btn btn-warning" >Delete</a>
                </div>'
            ];
        }
        $tot=$this->user_mod->get_all_admin_count();
        $respon['recordsTotal']=$tot;
        $respon['recordsFiltered']=$tot;
        $respon['data']=$json;
        echo json_encode($respon);
    }

    public function add_admin(){
        $this->form_validation->set_rules('pegawai','Pegawai','required|trim',
        ['required'=>'Pegawai Belum Di Pilih']); 
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $id=$this->input->post('pegawai',true);
            $cekAdmin=$this->user_mod->get_admin_BYID($id);
            $cek_user=$this->user_Mod->get_user($id);
            if($cekAdmin){
                $this->session->set_flashdata('pesanaddop','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan  '.$cek_user.' Sebagai Sekretaris Karena '.$cek_user.' Sudah Terdaftar Sebagai Sekeretaris
                </div>');  
                redirect("Managemen_Admin");
            }else{
                $data=[
                    'id'=>$id,
                    'role_id'=>1
                ];
                if($this->user_Mod->Add_admin($data)){
                    $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                     Berhasil Menambahkan  '.$cek_user.' Sebagai Sekretaris 
                    </div>');  
                    redirect("Managemen_Admin");
                }
            }
        }
    }

    public function hapus_admin($iduser,$id_admin){
        $cek_user=$this->user_Mod->get_user($iduser);
        if($this->user_Mod->del_Admin($id_admin)){
            $this->session->set_flashdata('pesanaddop','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus '.$cek_user.' Sebagai Admin
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