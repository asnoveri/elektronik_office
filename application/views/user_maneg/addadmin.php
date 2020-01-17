<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <?= $this->session->flashdata('pesantambah');?>
             <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>
            <h5 class="m-0 font-weight-bold text-secondary">List Admin</h5>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" id="aad_admn" data-toggle="modal" data-target="#tbhModal">
            Tambah Admin
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach ($admin_all_list as $admnls) {?> 
                        <tr>
                            <td><?= $no?></td>
                            <td><?= $admnls['fullname'] ?></td>
                            <td><?= $admnls['email']?></td>
                            <td class="centerd">
                            <a href="" data-toggle="modal" data-target="#tbhModal" class="btn btn-primary" id="edit_admn" data-id_admin="<?=$admnls['id'] ?>"> Ubah Password <i class="fa fa-edit"></i></a>
                            <a href="<?= base_url()?>Managemen_Admin/hapus_admin/<?= $admnls['id']?>" class="btn btn-warning"> Hapus Admin <i class="fa fa-times-circle"></i></a>
                            </td>
                        </tr> 
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
     <!-- Tambah Menu Modal -->
     <div class="modal" id="tbhModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="label_tbhadmin">Tambah Admin</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form action="<?= base_url()?>Managemen_admin/add_admin" method="POST">
                    <div class="form-group">
                      <label id="nm">Nama Lengkap</label>
                      <input type="text" class="form-control"  name="fullname" id="fullname">
                      <input type="hidden" id="id" name="id">
                    </div>
                    <div class="form-group">
                      <label id=em>Email</label>
                      <input type="text"  class="form-control"  name="email" id="email">
                    </div>
                    <div class="form-group" id="pase">
                      <label>Password</label>
                      <input type="password" class="form-control" name="pass" id="pass"> 
                    </div>
                    <div class="form-group">
                      <label id="lbpas">Password Verification</label>
                      <input type="password" class="form-control" name="pass1" id="pass1"> 
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn_add_admn">Tambah</button>
                    <button type="reset" class="btn btn-danger">Batal</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
</div>        