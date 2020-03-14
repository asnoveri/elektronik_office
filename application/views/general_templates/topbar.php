    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- <h2>Disposisi Poltekkes Riau</h2> -->
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

        

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">            
            <!-- Nav Item - Alerts -->

        <?php
        if($this->session->userdata('id_jabatan')== 1 || $this->session->userdata('id_jabatan')== 4 || $this->session->userdata('id_jabatan'== 12) || $this->session->userdata('id_jabatan'== 13) || $this->session->userdata('id_jabatan')== 14 ){?>  
              <?= get_data_srt_keluar($data_user['id_jabatan'])?>
              <?= get_data_srt_masuk($data_user['id_jabatan'])?>
        <?php } elseif($data_user['role_id'] == 1){?>
        <?php }else {?>
          <?= get_data_srt_masuk($data_user['id_jabatan'])?>
      <?php } ?>
            

      
            <!-- Nav Item - Messages -->
           
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $data_user['fullname'] ?>
                  <sup>
                    <?php
                      if($data_user['role_id']==1 || $data_user['role_id']==2 ){
                        echo $data_user['role_name'];
                      }else{
                        echo $data_user['jabatan'];
                      }
                    ?>
                  </sup>
                </span>
                <img class="img-profile rounded-circle" src="<?= base_url()?>assets/images/<?= $data_user['image']?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <?php if($data_user['role_id'] == 1){?>

                <a class="dropdown-item" href="<?= base_url()?>admin/profil_admin">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['role_name']?>
                </a>
              <?php } elseif($data_user['role_id'] == 2 ){?>
                <a class="dropdown-item" href="<?= base_url()?>Operator/profil_op">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['role_name']?>
                </a>
              <?php } else {?>
                <a class="dropdown-item" href="<?= base_url()?>user/profil_user">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= @$data_user['jabatan']?>
                </a> 
              <?php } ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->