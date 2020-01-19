<?php

        // function menu dinamis
        function Menu_dinamis(){
            $ci= get_instance();

             $role_id=$ci->session->userdata('role_id');
        
             $querymnu="SELECT menu.menu,call_child,  user_acess_menu.id_menu
             FROM user_acess_menu
             INNER JOIN menu ON menu.id_menu=user_acess_menu.id_menu WHERE user_acess_menu.role_id='$role_id' and menu.is_active=1 order by menu.posisi ASC";

             $menu=$ci->db->query($querymnu)->result_array();

             foreach ($menu as $mn ) {?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?= $mn['call_child']?>" aria-expanded="true"
                    aria-controls="collapseTwo1">
                    <span><?= $mn['menu']?></span>
                  </a>
                  <div id="<?= $mn['call_child']?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        
                          <div class="bg-white py-2 collapse-inner rounded">
                              <?php
                               $query="SELECT * FROM sub_menu WHERE id_menu='$mn[id_menu]' and sub_menu.is_active_sub='1' ORDER by posisi_sub ASC";
                               $sub_menu1= $ci->db->query($query)->result_array();
                                foreach($sub_menu1 as $sb_mn){?>
                                  <a class="collapse-item" href="<?= base_url()?><?= $sb_mn['url'] ?>">
                                        <i class="<?= $sb_mn['icon']?>"></i>
                                        <span><?= $sb_mn['title']?></span>
                                      </a>
                               <?php } ?>
        
                          </div>
                  </div>
                </li>
                <hr class="sidebar-divider">
              <?php } 
              
            }

            //function cek akses login dan hak acses menu
            function is_login(){
              $ci= get_instance();
              if(!$ci->session->userdata('email')){
                        $ci->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                        Silahkan Login Dulu!!
                                                        </div>');
                    redirect('Auth');  
              }else{
                $role_id=$ci->session->userdata('role_id');
                $controller = $ci->uri->segment(1);

                if($controller=='admin' || $controller=='Admin'){
                  $ctr=1;
                    if($ctr==$role_id){
                    }else{
                      redirect('Blank_page');
                    }
                }elseif($controller=='operator'||$controller=='Operator'){
                  $ctr=2;
                    if($ctr==$role_id){
                    }else{
                    redirect('Blank_page');
                    }
                }elseif($controller=='user'||$controller=='User'){
                  $ctr=3;
                    if($ctr==$role_id){
                    }else{
                    redirect('Blank_page');
                    }
                }else{
                  $get_ctrl=$ci->db->get_where('menu',['ctrl_menu'=>$controller])->row_array();
                  $user_acces=$ci->db->get_where('user_acess_menu',[
                    'role_id' => $role_id,
                    'id_menu' => $get_ctrl['id_menu']
                  ]);

                  if($user_acces->num_rows() < 1){
                    redirect('Blank_page');
                  }
                }

                
                
              }
                
            }


            function cek_akses_user($id_menu,$role_id){
              $ci= get_instance();

              $isidata=$ci->db->get_where('user_acess_menu',[
                'role_id'=>$role_id,
                'id_menu'=>$id_menu
                ]);

                if($isidata->num_rows() > 0){
                  return "checked";
                }
            
            }

            function user_aktiv($is_active){
              $ci= get_instance();
              if($is_active==1){?>
              <option value="<?=$is_active?>"> Aktiv  </option>
                <option value="0"> Non Aktiv  </option>;
             <?php } elseif($is_active==0){?>
                <option value="<?=$is_active?>"> Non Aktiv  </option>
                <option value="1"> Aktiv  </option>;
             <?php } 
            }

?>