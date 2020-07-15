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
            <div class="col-sm-6">
              <div class="form-group text-capitalize">
                <label class="font-weight-bold">Nama Lengkap</label>
                <input type="text" class="form-control" readonly value="<?= $user->fullname ?>">
              </div>
              <div class="form-group ">
                <label class="text-capitalize font-weight-bold">NIP</label>
                <input type="text" class="form-control" readonly value="<?= $user->nip ?>">
              </div>
              <div class="form-group ">
                <label class="text-capitalize font-weight-bold">User Name</label>
                <input type="text" class="form-control" readonly value="<?= $user->user_name ?>">
              </div>
              <div class="form-group ">
                <label class="text-capitalize font-weight-bold">Email</label>
                <input type="text" class="form-control" name="email" readonly value="<?= $user->email ?>">
              </div>
              <div class="form-group ">
                <label class="text-capitalize font-weight-bold">Jabatan</label>
                <p class="form-control" readonly>
                  <?php
                  foreach ($jabatankerja as $jabker) { ?>
                    <span class="badge badge-primary"><?= $jabker[0]->unitkerja ?></span>
                  <?php } ?>
                </p>
              </div>
            </div>
            <div class="col-sm-6">
              <?= $this->session->flashdata('erorogbr') ?>
              <div class="card" style="width:250px;">
                <img class="card-img-top img-thumbnail" src="<?= base_url() ?>assets/images/<?= $user->image ?>" alt="Card image">
                <div class="card-body">
                  <label class="card-text">Ubah Foto Profil</label>
                  <div class="custom-file">
                    <form action="#" method="POST" enctype='multipart/form-data' id="form_upload_foto">
                      <input type="file" class="custom-file-input" id="customFile1" name="gambar">
                      <input type="hidden" id="idgambar" value="<?= $user->id ?>" name="id" id="id">
                      <input type="hidden" id="role_id" value="<?= $this->session->userdata("role_id") ?>">
                      <label class="custom-file-label " for="customFile"> Pilih file</label>
                      <!-- <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                      </button> -->
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>