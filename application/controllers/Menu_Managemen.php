<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Managemen extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        is_login();
      
    }

    //menu managemen

    public function index(){
        $judul="Menu Managemen";
        $halaman='menu_maneg/index';
        $data['all_menu']=$this->menu_Mod->get_all_menu();
        $this->template->TemplateGen($judul,$halaman,$data);  
        

    }

    public function nonaktiv_mnu($id){
        $menu=$this->menu_Mod->cek_menu_is_active($id);
       if($menu['is_active']==0){
           $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Gagal MenonAktifkan Menu Karena Menu Sudah Non Aktiv
                       </div>');
                       $this->index(); 
        }else{
               $data=[
                   'is_active'=>'0'
               ];
               $this->menu_Mod->edit_menu_is_active($id,$data);
               $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  Berhasil MenonAktifkan Menu
                               </div>');
                               $this->index(); 
        }
         redirect('menu_Managemen');
       
       
    }

    public function aktiv_mnu($id){
        $menu=$this->menu_Mod->cek_menu_is_active($id);
       if($menu['is_active']==1){
           $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Gagal MengAktifkan Menu Karena Menu Sudah  Aktiv
                       </div>');
                       $this->index();  
        }else{
               $data=[
                   'is_active'=>'1'
               ];
               $this->menu_Mod->edit_menu_is_active($id,$data);
               $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  Berhasil MengAktifkan Menu
                               </div>');
                               $this->index();  
        }
        redirect('menu_Managemen');
       
    }


    public function addmenu(){            
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim',
            ['required'=> 'Field  Menu Tidak Boleh Kosong']
        );
        $this->form_validation->set_rules('call_child','Call_child','required|trim|alpha_dash|alpha',
        ['required'=> 'Field  Collapsed Tidak Boleh Kosong','alpha_dash'=>'field Collapses Tidak Mengizinkan Spasi Pada Karakter Yang di Masukkan','alpha'=>'Angka dan Karakter Lain Tidak di Izinkan, Field Collpases Hanya Mengizinkan Karakter Huruf ']
        );
        $this->form_validation->set_rules('posisi','Posisi','required|numeric|trim|max_length[2]',
            ['required'=> 'Field  Posisi Tidak Boleh Kosong ','max_length'=>'Tidak di Izinkan Memasukkan Lebih Dari 2 Karakter Angka Pada Field  Posisi','numeric'=>' Huruf dan Karakter Lain Tidak di Izinkan, Field  Posisi Hanya Mengizinkan Karakter Angka']
        );

        
        if ($this->form_validation->run() == FALSE){
            $this->index(); 
        }else{

        // untuk mengubah spasi menjadi under score "_" 
           $menu_name=$this->input->post('menu',true);  
           $ctrl_mn=str_replace(" ", "_", $menu_name);  
           
              $data=[
                  'menu'=> $this->input->post('menu',true),
                  'ctrl_menu'=> $ctrl_mn,
                  'is_active'=> '1'
              ];

            //   untuk mencek data apaka sudah ada atau belum di database
            if($this->menu_Mod->cek_menu_is_insert($data)->num_rows() > 0){
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan Menu Baru, Menu Sudah Ada Pada Database
                </div>');  
                redirect('Menu_managemen');
            }else{
                $menu_name=$this->input->post('menu',true);  
                $ctrl_mn=str_replace(" ", "_", $menu_name);  
                
                   $data1=[
                       'menu'=> $this->input->post('menu',true),
                       'ctrl_menu'=> $ctrl_mn,
                       'call_child'=> $this->input->post('call_child',true),
                       'posisi'=> $this->input->post('posisi',true),
                       'is_active'=> '1'
                   ];

                $add=$this->menu_Mod->add_menu($data1);
                if($add){
                    $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Berhasil Menambahkan Menu Baru
                    </div>');
                    redirect('Menu_Managemen');
                }
                $this->index(); 
            }
            
        }
        // redirect('menu_Managemen'); 
    }


    public function list_sub_menu(){
        $judul="Sub Menu Managemen";
        $halaman='menu_maneg/list_sub_menu';
        $data['all_sub_menu']=$this->menu_Mod->get_all_sub_menu();
        $data['Parent_menu']=$this->menu_Mod->get_all_menu_is_active();
        $this->template->TemplateGen($judul,$halaman,$data);  
    }



    public function addSubmenu(){
        $this->form_validation->set_rules('sub_menu', 'Sub_menu', 'required|trim',
            ['required'=> 'Field  Sub Menu Tidak Boleh Kosong']
        );
        $this->form_validation->set_rules('id_menu', 'Id_menu', 'required|trim',
        ['required'=> 'Field  Parent Menu Tidak Boleh Kosong']
        );
        $this->form_validation->set_rules('url','Url','required|trim',
        ['required'=> 'Field  Url Tidak Boleh Kosong']
        );
        $this->form_validation->set_rules('icon','Icon','required|trim',
        ['required'=> 'Field  Icon Tidak Boleh Kosong']
        );
        $this->form_validation->set_rules('posisi_sub','Posisi_sub','required|numeric|trim|max_length[2]',
            ['required'=> 'Field  Posisi Sub Menu Tidak Boleh Kosong ','max_length'=>'Tidak di Izinkan Memasukkan Lebih Dari 2 Karakter Angka Pada Field  Posisi Sub Menu','numeric'=>' Huruf dan Karakter Lain Tidak di Izinkan, Field Posisi Sub Menu Hanya Mengizinkan Karakter Angka']
        );


        if ($this->form_validation->run() == FALSE){

            $this->list_sub_menu(); 
        }else{
              $data=[
                  'title'=> $this->input->post('sub_menu',true),
                  'id_menu'=> $this->input->post('id_menu',true),
                  'url'=> $this->input->post('url',true),
                  
              ];

              if($this->menu_Mod->cek_submenu_is_insert($data)->num_rows() > 0){
                $this->session->set_flashdata('pesan1','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan Sub Menu Baru, Sub Menu Sudah Ada Pada Database
                </div>');
                redirect('Menu_Managemen/list_sub_menu'); 
              }else{
                $data1=[
                    'title'=> $this->input->post('sub_menu',true),
                    'id_menu'=> $this->input->post('id_menu',true),
                    'url'=> $this->input->post('url',true),
                    'icon'=> $this->input->post('icon',true),
                    'posisi_sub'=> $this->input->post('posisi_sub',true),
                    'is_active_sub'=> '1'
                ];
                  $add=$this->menu_Mod->add_Submenu($data1);
                  if($add){
                      $this->session->set_flashdata('pesan1','<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                         Berhasil Menambahkan Sub Menu Baru
                      </div>');
                     redirect('Menu_Managemen/list_sub_menu');                       
                  }

              }
        }
        // redirect('menu_Managemen/list_sub_menu');
       
    }



    public function nonaktiv_sub_mnu($id){
        $submenu=$this->menu_Mod->cek_Sub_menu_is_active($id);
       if($submenu['is_active_sub']==0){
           $this->session->set_flashdata('pesan1','<div class="alert alert-danger alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Gagal MenonAktifkan Sub Menu Karena Sub Menu Sudah Non Aktiv
                       </div>');
                       $this->list_sub_menu(); 
        }else{
               $data=[
                   'is_active_sub'=>'0'
               ];
               $this->menu_Mod->edit_sub_menu_is_active($id,$data);
               $this->session->set_flashdata('pesan1','<div class="alert alert-success alert-dismissible">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  Berhasil MenonAktifkan Sub Menu
                               </div>');
                               $this->list_sub_menu(); 
        }
        redirect('menu_Managemen/list_sub_menu');
       
    }



    public function aktiv_sub_mnu($id){
        $sub_menu=$this->menu_Mod->cek_Sub_menu_is_active($id);
       if($sub_menu['is_active_sub']==1){
           $this->session->set_flashdata('pesan1','<div class="alert alert-danger alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Gagal MengAktifkan Sub Menu Karena Menu Sudah  Aktiv
                       </div>');
                       $this->list_sub_menu();  
        }else{
               $data=[
                   'is_active_sub'=>'1'
               ];
               $this->menu_Mod->edit_sub_menu_is_active($id,$data);
               $this->session->set_flashdata('pesan1','<div class="alert alert-success alert-dismissible">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  Berhasil MengAktifkan Sub Menu
                               </div>');
                               $this->list_sub_menu();  
        }
        redirect('menu_Managemen/list_sub_menu');
       
    }

    

    public function get_menu_byid(){
    //data dari jquery ditangkap dengan mengunakan yang dibawah
        $id=$this->input->post('id_menu',true);
        
        $data=$this->menu_Mod->get_menuBYID($id);

    // echo json_encode digunakan untuk mengembalikan data berupa json
       echo json_encode($data) ;  
    }
    
    public function edit_menu(){
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim',
        ['required'=> 'Field  Menu Tidak Boleh Kosong']
        );
        $this->form_validation->set_rules('call_child','Call_child','required|trim|alpha_dash|alpha',
        ['required'=> 'Field  Collapsed Tidak Boleh Kosong','alpha_dash'=>'field Collapses Tidak Mengizinkan Spasi Pada Karakter Yang di Masukkan','alpha'=>'Angka dan Karakter Lain Tidak di Izinkan, Field Collpases Hanya Mengizinkan Karakter Huruf ']
        );
        $this->form_validation->set_rules('posisi','Posisi','required|numeric|trim|max_length[2]',
            ['required'=> 'Field  Posisi Tidak Boleh Kosong ','max_length'=>'Tidak di Izinkan Memasukkan Lebih Dari 2 Karakter Angka Pada Field  Posisi','numeric'=>' Huruf dan Karakter Lain Tidak di Izinkan, Field  Posisi Hanya Mengizinkan Karakter Angka']
        );


        if ($this->form_validation->run() == FALSE){

            $this->index(); 
        }else{
            $menu_name=$this->input->post('menu',true);  
            $ctrl_mn=str_replace(" ", "_", $menu_name);  
               
            $data=[
                'menu'=> $this->input->post('menu',true),
                'ctrl_menu'=> $ctrl_mn,
                'call_child'=> $this->input->post('call_child',true),
                'posisi'=> $this->input->post('posisi',true)
            ];

            $id=$this->input->post('id_menu',true);
           
            $kirim =$this->menu_Mod->edit_menu($id,$data);

            if($kirim=== true){
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Edit Menu 
                </div>');
                redirect('Menu_Managemen');
                
            }else{
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Tidak ada data menu yang di ubah 
                </div>');
                redirect('Menu_Managemen');
                
            }
        }
        
    }


    public function get_submenu_byid(){
        $id=$this->input->post('id_submenu',true);
        
        $data=$this->menu_Mod->get_submenuBYID($id);
        echo json_encode($data) ;
    }




    public function edit_submenu(){
    $this->form_validation->set_rules('sub_menu', 'Sub_menu', 'required|trim',
    ['required'=> 'Field  Sub Menu Tidak Boleh Kosong']);
    $this->form_validation->set_rules('id_menu', 'Id_menu', 'required|trim',
    ['required'=> 'Field  Parent Menu Tidak Boleh Kosong']
    );
    $this->form_validation->set_rules('url','Url','required|trim',
    ['required'=> 'Field  Url Tidak Boleh Kosong']
    );
    $this->form_validation->set_rules('icon','Icon','required|trim',
    ['required'=> 'Field  Icon Tidak Boleh Kosong']
    );
    $this->form_validation->set_rules('posisi_sub','Posisi_sub','required|numeric|trim|max_length[2]',
        ['required'=> 'Field  Posisi Sub Menu Tidak Boleh Kosong ','max_length'=>'Tidak di Izinkan Memasukkan Lebih Dari 2 Karakter Angka Pada Field  Posisi Sub Menu','numeric'=>' Huruf dan Karakter Lain Tidak di Izinkan, Field Posisi Sub Menu Hanya Mengizinkan Karakter Angka']
    );


    if ($this->form_validation->run() == FALSE){

        $this->list_sub_menu(); 
    }else{
          $data=[
              'title'=> $this->input->post('sub_menu',true),
              'id_menu'=> $this->input->post('id_menu',true),
              'url'=> $this->input->post('url',true),
              'icon'=> $this->input->post('icon',true),
              'posisi_sub'=> $this->input->post('posisi_sub',true)
          ];

         $id=$this->input->post('id_submenu',true);

            $kirim =$this->menu_Mod->edit_sub_menu($id,$data);

            if($kirim=== true){
                $this->session->set_flashdata('pesan1','<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Edit Sub Menu 
                </div>');
                redirect('menu_Managemen/list_sub_menu');  
                
            }else{
                $this->session->set_flashdata('pesan1','<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Edit Sub Menu 
                </div>');
            redirect('menu_Managemen/list_sub_menu');  
            }

        }
       
       
    }


    public function cek_posisi_sub_menu(){
        $data=[
            'id_menu'   => $this->input->post('id_menu',true),
            'posisi_sub'=> $this->input->post('posisi_sub',true),
            'is_active_sub' => 1
        ];
       $cek=$this->menu_Mod->cek_posisiSMN($data);
       echo json_encode($cek);
        
    }

    public function cek_posisi_menu(){
           $posisi_menu= $this->input->post('posisi_menu');
            $cek=$this->menu_Mod->cek_posisiMN($posisi_menu);
            echo json_encode($cek);
        
    }

    public function acces_user(){
        $judul="Role Access User ";
        $halaman='menu_maneg/acces_user';
        $data['user_all']=$this->user_Mod->get_all_role();
        
        $this->template->TemplateGen($judul,$halaman,$data);  
        
    }

    public function cek_akses_menu($id){
       $judul="Role Access Menu ";
       $halaman='menu_maneg/cek_akses_menu';
       $data['role']=$this->user_Mod->get_user_BYID($id);
       $data['all_cek_menu']=$this->menu_Mod->get_all_menu_is_active();
        
       $this->template->TemplateGen($judul,$halaman,$data);  
    }

    public function ubah_access(){
        $data=[
            'role_id'=>$this->input->post('role_id',true),
            'id_menu'=>$this->input->post('id_menu',true)
        ];
        
           $cek=$this->menu_Mod->user_akses($data);
        
        if($cek==true){
            $this->session->set_flashdata('pesan2','<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                Berhasil Mengubah Role Akses 
            </div>');
        }
    }
 

}


?>