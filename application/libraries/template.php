<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    class template{
        protected $CI;
               
        public function __construct()
        {
        
                $this->CI =& get_instance();
                $this->CI->load->model('user_Mod');
                $this->CI->load->model('menu_Mod');
                   
        }
        //libraries  function untuk mengataur template dan halam secara lebih dinamis 
        public function TemplateGen($judul=null,$halaman=null,$data1=null){
            // data1 adalah data yang dikirmkan dari controller
            // data doank adalah data yang set pada libraries
            $data['judul']=$judul;
            $data['data_user']=$this->CI->user_Mod->get_data_user($this->CI->session->userdata('role_id'),$this->CI->session->userdata('id_jabatan'),$this->CI->session->userdata('email'));
            
            $this->CI->load->view('general_templates/header',$data);
            $this->CI->load->view('general_templates/sidebar');
            $this->CI->load->view('general_templates/topbar',$data);
            $this->CI->load->view($halaman,$data1);
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

    
?>