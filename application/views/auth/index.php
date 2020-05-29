  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-16 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <?php
            if (@$pilih_akun) { ?>
              <div class="row">
                <div class="col-lg-12">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Pilih Account</h1>
                    </div>
                    <div class="row">
                      <?php
                      foreach ($peguna as $pgn) {
                        if ($pgn->role_id == 1 && $pgn->status == 1) {
                          $role = "Admin";
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        } elseif ($pgn->role_id == 2 && $pgn->status == 1) {
                          $role = "Sekretaris";
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        } elseif ($pgn->role_id == 3 && $pgn->status == 1) {
                          $role = "Pegawai ";
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        } elseif ($pgn->role_id == 4 && $pgn->status == 1) {
                          $role = "Direktur";
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        } elseif ($pgn->role_id == 5 && $pgn->status == 1) {
                          $role = jabatanget($pgn->id_penguna);
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        } elseif ($pgn->role_id == 6 && $pgn->status == 1) {
                          $role = "Adum";
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        } elseif ($pgn->role_id == 7 && $pgn->status == 1) {
                          $role = "Admin Kepegawaian";
                          echo  '<div class="col-lg-6 mt-2">
                                <a href="' . base_url() . 'auth/pilih_Role/' . $pgn->role_id . '" class="btn btn-primary btn-user btn-block">' . $role . '</a>
                              </div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <div class="row">
                <div class="col-lg-12">
                  <div class="p-5">
                    <?= $this->session->flashdata('pesan'); ?>
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    </div>
                    <form class="user" action="<?= base_url() ?>Auth/login" method="POST">
                      <!-- <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                            <?= form_error('email', '<div class="text-danger"><i>', '</i></div>'); ?>
                          </div> -->
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputUser_name" name="user_name" placeholder="Masukan User Name..." value="<?= set_value('user_name'); ?>">
                        <?= form_error('user_name', '<div class="text-danger"><i>', '</i></div>'); ?>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-user" name="pass" id="exampleInputPassword" placeholder="Password">
                        <?= form_error('pass', '<div class="text-danger"><i>', '</i></div>') ?>
                      </div>
                      <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                          <input type="checkbox" class="custom-control-input" id="customCheck">
                          <label class="custom-control-label" for="customCheck">Remember Me</label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                      </button>
                    </form>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="<?= base_url() ?>auth/autlog/1">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                      <a class="small" href="<?= base_url() ?>auth/autlog/2">Create an Account!</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php }
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>