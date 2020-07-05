    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
      </div>

      <!-- Content Row -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <!-- <?= $this->session->flashdata('pesanaddop') ?>
          <?php if (validation_errors()) { ?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?= validation_errors(); ?>
            </div>
          <?php  } ?> -->
          <h5 class="m-0 font-weight-bold text-secondary"><?= $judul ?> <?= $user->fullname ?></h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
              <?= $this->session->flashdata('erorogbr') ?>
              <div class="card">
                <img class="card-img-top img-thumbnail" src="<?= base_url() ?>assets/images/<?= $user->image ?>" alt="Card image">
                <div class="card-body">
                  <label class="card-text">Ubah Foto Profil</label>
                  <div class="custom-file">
                    <form action="#" method="POST" enctype='multipart/form-data' id="form_upload_foto">
                      <input type="file" class="custom-file-input" id="customFile1" name="gambar">
                      <input type="hidden" id="idgambar" value="<?= $user->id ?>" name="id" id="id">
                      <input type="hidden" id="role_id" value="<?= $this->session->userdata("role_id") ?>">
                      <label class="custom-file-label" for="customFile">Pilih file</label>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <p class="card-text text-capitalize">nama lengkap</p>
              <p class="card-text text-capitalize">NIP</p>
              <p class="card-text text-capitalize">user name</p>
              <p class="card-text text-capitalize">email</p>
              <p class="card-text text-capitalize">jabatan</p>

            </div>
            <div class="col-sm-6">
              <p class="card-text text-capitalize">: <?= $user->fullname ?></p>
              <p class="card-text text-capitalize">: <?= $user->nip ?></p>
              <p class="card-text ">: <?= $user->user_name ?></p>
              <p class="card-text ">: <?= $user->email ?></p>
              <p class="card-text ">:
                <?php
                foreach ($jabatankerja as $jabker) { ?>
                  <span class="badge badge-primary"><?= $jabker[0]->unitkerja ?></span>
                <?php }
                ?>
              </p>

              <!-- <form action="<?= base_url() ?>User_Managemen/do_edit_user" method="POST" enctype='multipart/form-data' id="form_upload_foto">
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" class="form-control" name="fullname" value="<?= $user->fullname ?>">
                </div>
                <div class="form-group">
                  <label>NIP</label>
                  <input type="text" class="form-control" name="nip" value="<?= $user->nip ?>">
                </div>
                <div class="form-group">
                  <label>User Name</label>
                  <input type="text" class="form-control" name="user_name" value="<?= $user->user_name ?>">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" value="<?= $user->email ?>">
                </div>
                <input type="hidden" id="idgambar" value="<?= $user->id ?>" name="id" id="id">
                <button type="submit" class="btn btn-primary">Edit User</button>
                <button type="reset" class="btn btn-danger">Batal</button>
              </form> -->
            </div>
          </div>
        </div>
      </div>
    </div>