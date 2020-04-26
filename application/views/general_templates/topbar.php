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
            
      
            <!-- Nav Item - Messages -->
           
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $data_user['fullname'] ?>
                  <sup>
                    <?php
                      if($data_user['role_id']==1 || $data_user['role_id']==2 || $data_user['role_id']==4 || $data_user['role_id']==6 ||$data_user['role_id']==7){
                        echo $data_user['role_name'];
                      }elseif($data_user['role_id']==3 || $data_user['role_id']==5){
                        echo "Pegawai Poltekkes Riau";
                        // echo $data_user['jabatan'];
                        // echo jabatanget($data_user['id_penguna']);
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
                  Profile <?= $data_user['role_name']?> "(<?= $data_user['fullname'] ?>)"
                </a>
              <?php } elseif($data_user['role_id'] == 2 ){?>
                <a class="dropdown-item" href="<?= base_url()?>Operator/profil_op">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['role_name']?> "(<?= $data_user['fullname'] ?>)"
                </a>
                <?php } elseif($data_user['role_id'] == 3 ){?>
                <a class="dropdown-item" href="<?= base_url()?>User/profil_user">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['fullname'] ?>
                </a>
              <?php } elseif($data_user['role_id'] == 4 ){?>
                <a class="dropdown-item" href="<?= base_url()?>Direktur/profil_dr">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['role_name']?> "(<?= $data_user['fullname'] ?>)"
                </a>
              <?php } elseif($data_user['role_id'] == 5 ){?>
                <a class="dropdown-item" href="<?= base_url()?>Wadir/profil_wadir">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= jabatanget($data_user['id_penguna'])?> "(<?= $data_user['fullname'] ?>)"
                </a>
                <?php } elseif($data_user['role_id'] == 6 ){?>
                <a class="dropdown-item" href="<?= base_url()?>Adum/profil_adum">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['role_name']?> "(<?= $data_user['fullname'] ?>)"
                </a> 
                <?php } elseif($data_user['role_id'] == 7 ){?>
                <a class="dropdown-item" href="<?= base_url()?>admin_kepeg/profil_adminkepg">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile <?= $data_user['role_name']?> "(<?= $data_user['fullname'] ?>)"
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