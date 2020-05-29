<?php

defined('BASEPATH') or exit('No direct script access allowed');

class template
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('user_Mod');
        $this->CI->load->model('menu_Mod');
        date_default_timezone_set('Asia/Jakarta');
    }

    //libraries  function untuk mengataur template dan halam secara lebih dinamis 
    public function TemplateGen($judul = null, $halaman = null, $data1 = null)
    {
        // data1 adalah data yang dikirmkan dari controller
        // data doank adalah data yang set pada libraries
        // $waktu=$this->CI->db->select_max('tanggal');
        // $query = $this->CI->db->get_where('log',['tipe_login'=>$this->CI->session->userdata('role_id'),
        // 'id_user'=>$this->CI->session->userdata('id')])->row();
        // $datestring = '%d-%m-%Y';
        // $time = "1579428763";
        // echo mdate($datestring, $time);
        // if(time()- $query->tanggal > (60*15) ){
        //    redirect('Auth/logout');
        // }
        $data['judul'] = $judul;
        $data['data_user'] = $this->CI->user_Mod->get_data_user($this->CI->session->userdata('role_id'), $this->CI->session->userdata('id'));
        $this->CI->load->view('general_templates/header', $data);
        $this->CI->load->view('general_templates/sidebar');
        $this->CI->load->view('general_templates/topbar', $data);
        $this->CI->load->view($halaman, $data1);
        $this->CI->load->view('general_templates/footer');
    }

    // public function usertml($halaman=null,$data1=null){
    //     $data['judul']='User';
    //     $data['data_user']=$this->CI->user_Mod->get_data_user($this->CI->session->userdata('role_id'));
    //     $data['menu']=$this->CI->menu_Mod->menu($this->CI->session->userdata('role_id'));
    //     $this->CI->load->view('general_templates/header',$data);
    //     $this->CI->load->view('general_templates/sidebar',$data);
    //     $this->CI->load->view('general_templates/topbar',$data);
    //     $this->CI->load->view("admin/index",$data);
    //     $this->CI->load->view('general_templates/footer');   
    // }

    // public function operatortml($halaman=null,$data1=null){
    //     $data['judul']='Operator';
    //     $data['data_user']=$this->CI->user_Mod->get_data_user($this->CI->session->userdata('role_id'));
    //     $data['menu']=$this->CI->menu_Mod->menu($this->CI->session->userdata('role_id'));
    //     $this->CI->load->view('general_templates/header',$data);
    //     $this->CI->load->view('general_templates/sidebar',$data);
    //     $this->CI->load->view('general_templates/topbar',$data);
    //     $this->CI->load->view("admin/index");
    //     $this->CI->load->view('general_templates/footer');   
    // }    
}
