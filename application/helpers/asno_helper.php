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

            //function cheked hak akses menu user
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

            // function combo box status user
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

            // function menampilkan jabatan user
            function jabatanget($id){
              $ci= get_instance();
              $jbt=$ci->db->get_where('jabatan_user',['id_jabatan'=>$id])->row();
              return $jbt->jabatan;
            }

            // function menampilkan feedback surat
            function feedback($id){
              $ci= get_instance();
              $fdbk=$ci->db->get_where('feedback_surat',['id_feedback'=>$id])->row();
              return $fdbk->feedback;
            }

            // function combo box menampilkan jabata user
            function jabtan_combo($id){
              $ci= get_instance();
              $jbt=$ci->db->get_where('jabatan_user',['id_jabatan'=>$id])->row();
              $jbt1=$ci->db->get('jabatan_user')->result();
              if($id){?>
                   <option> <?= $jbt->jabatan?>  </option>;
                   <?php
                      foreach($jbt1 as $jb){?>
                        <option value="<?=$jb->id_jabatan?>"> <?= $jb->jabatan?>  </option>;
                      <?php }
                   ?>
              <?php } 
            }

            // function menampilakn alert surat 
            function get_data_srt_masuk($id_jabatan){?>
              <?php $ci= get_instance();?>
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <?php 
                         $query= "SELECT * FROM surat_masuk_diter WHERE di_teruskan_ke=$id_jabatan and id_feedback='1'
                         ";
                         $query1=$ci->db->query($query)->result();
                       if($query1){?>
                         <span class="badge badge-danger badge-counter">
                             <?= count($query1);?>
                         </span>
                       <?php }else{?>
                         
                       <?php }
                   ?>
                </a>
                <!-- Dropdown - Alerts -->
                       <?php
                            if($query1){
                             $kondisi="";
                            }else{
                             $kondisi="hidden";
                            }
                        ?>
                <div <?= $kondisi?> class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                      <h6 class="dropdown-header bg-success ">
                        Alerts Center
                      </h6>
                      <?php
                          foreach ($query1 as $smk){?>
                              
                              <?php
                               $data_surat= $ci->db->get_where('surat_masuk',['id_surat_masuk'=>$smk->id_surat_masuk])->result(); 
                                foreach($data_surat as $ds){?>
                                <?php
                                    if($ds->tipe_surat=="Surat Masuk"){?>
                                      <a class="dropdown-item d-flex align-items-center ubah_feedback" data-id_terus_srt_msk="<?=$smk->id_terus ?>"  href="<?= base_url()?>user/detail_srt_masuk_user/<?=$smk->id_surat_masuk?>">
                                   <?php  } elseif($ds->tipe_surat="Surat Keluar"){?>
                                      <a class="dropdown-item d-flex align-items-center" href="<?= base_url()?>User">
                                   <?php }?>
                                  <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                      <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                  </div>
                                  <div>
                                    <div class="small text-gray-500"><?= nice_date($ds->tgl_surat_masuk, 'd-m-Y')?></div>
                                    <span class="font-weight-bold"><?= $ds->tipe_surat?></span></br>
                                    <p class="font-weight-tiny"><?= $ds->perihal?></p>
                                    <span class="font-weight-bold"><?= $ds->asal_surat?></span></br>
                                  </div>
                              </a>
                                <?php }?>
                       <?php  }?>
                      <a class="dropdown-item text-center small text-gray-500" href="<?= base_url()?>User/list_srt_msk_user">Show All Alerts</a>
                </div>
              </li>
           <?php }

          //  function menampilkan data surat masuk ke dalam tabel per id user
            function get_tabel_srt_msk_peruser($id_jabatan){?>
              <?php $ci= get_instance();
              $query= "SELECT * FROM surat_masuk_diter WHERE di_teruskan_ke=$id_jabatan";
              $query1=$ci->db->query($query)->result();?>
               
                        <?php
                        foreach ($query1 as $smk){?>
                        <?php
                               $data_surat= $ci->db->get_where('surat_masuk',['id_surat_masuk'=>$smk->id_surat_masuk])->result(); 
                              
                                foreach($data_surat as $sm){  ?>
                                    <ul class="list-group" id="myList">
                                      <li class="list-group-item">
                                        <div class="row">
                                          <div class="col-sm-1">
                                          <?php
                                              if($smk->id_feedback==1){?>
                                                <span class="mr-2">
                                                  <a href="#" data-toggle="tooltip" data-placement="right" title="Surat Masuk Belum di Lihat!"> 
                                                    <i class="fas fa-circle text-success" data-toggle="tooltip" data-placement="right"></i>
                                                  </a>
                                               </span>
                                              <?php }elseif($smk->id_feedback==2){?>
                                                <span class="mr-2">
                                                  <i class="fas fa-circle text-gray-500"></i>
                                                </span>
                                              <?php }
                                          ?>
                                          </div>
                                          <div class="col-sm-4">
                                            <a href="<?= base_url()?>user/detail_srt_masuk_user/<?=$sm->id_surat_masuk?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?=$smk->id_terus ?>"> 
                                              <span class="text-gray-500 font-weight-lighter font-italic"><?= nice_date($sm->tgl_surat_masuk, 'd-m-Y')?> -</span>
                                              <span class="text-black-50 font-font-weight-bolder text-uppercase"><?=$sm->asal_surat ?></span>
                                            </a>
                                          </div>
                                          <div class="col-sm-7">
                                            <a href="<?= base_url()?>user/detail_srt_masuk_user/<?=$sm->id_surat_masuk?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?=$smk->id_terus ?>"> 
                                              <span class="text-gray-500 text-capitalize "><?=$sm->perihal?></span>
                                            </a>
                                          </div>
                                        </div>
                                      </li>
                                    </ul>
                                      <?php ?> 
                                <?php  }?>
                        <?php  }?>    
            <?php }                          

?>