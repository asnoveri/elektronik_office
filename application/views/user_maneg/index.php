    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">  
                <?= $this->session->flashdata('pesanaddop');?>
                <?php if(validation_errors()){?>
                        <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?= validation_errors();?>
                        </div>
                <?php  } ?>
            <h5 class="m-0 font-weight-bold text-secondary">List User</h5>
            </div>
            <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" id="aad_user" data-toggle="modal" data-target="#tbhuser">
            Tambah User
            </button>
                <div class="row">  
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Foto</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            </div>
        </div>    
    </div>

    <div class="modal" id="tbhuser">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="label_Tambah">Tambah User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form action="<?= base_url()?>User_Managemen/add_user" method="POST">
                    <div class="form-group" id="fullname">
                        <label>Nama lengkap</label>
                        <input type="text" class="form-control"  name="fullname">
                    </div>
                    <div class="form-group"  id="user_name">
                        <label>User Name</label>
                        <input type="text" class="form-control" name="user_name">
                    </div>
                    <div class="form-group" id="email">
                        <label>Email</label>
                        <input type="text" class="form-control"  name="email">
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input type="password" class="form-control" id="pass"  name="pass">
                        <input type="hidden" id="id"  name="id">
                    </div>
                    <div class="form-group">
                        <label>Ulang Kata Sandi</label>
                        <input type="password" class="form-control" id="pass1"  name="pass1">
                    </div>
                    <button type="submit" class="btn btn-primary" id="tbl_proses">Tambah</button>
                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </form>
              </div>
            </div>
          </div>
        </div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->


