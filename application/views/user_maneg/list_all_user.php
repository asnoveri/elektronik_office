<?php
    if($role['role_id']==2){?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User_Managemen/" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List User</span></a></a>
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
            <h5 class="m-0 font-weight-bold text-secondary">List <?= $role['role_name']?></h5>
        </div>

        <div class="card-body">
            <a href="<?= base_url()?>User_managemen/addform/<?=$role['role_id']?>" class="btn btn-primary mb-3"> Tambah <?= $role['role_name']?> </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th width="34.9%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach ($user_all_list as $u_allt) {?> 
                        <tr>
                            <td><?= $no?></td>
                            <td><?= $u_allt['fullname'] ?></td>
                            <td><?= $u_allt['email']?></td>
                            <td width="20%">
                                <div class="btn-group-vertical">
                                    <a href="" data-toggle="modal" data-target="#editpass_op" class="btn btn-info" id="tbl_editop" data-id_op="<?=$u_allt['id'] ?>"> Ubah Password <i class="fa fa-edit"></i></a>
                                    <a href="<?= base_url()?>User_Managemen/delOP/<?=$u_allt['id'] ?>/<?=$role['role_id']?>" class="btn btn-warning"> Hapus Operator   <i class="fas fa-trash"></i></i></a>
                                </div>
                            </td>
                        </tr> 
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
       
    </div>
</div>
   
    <!-- /.container-fluid -->
    <?php }elseif($role['role_id']==3) { ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User_Managemen/"class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List User</span></a></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <?= $this->session->flashdata('pesanaddop') ?>
            <h5 class="m-0 font-weight-bold text-secondary">List <?= $role['role_name']?></h5>
        </div>

        <div class="card-body">
                 <a href="<?= base_url()?>User_managemen/addform/<?=$role['role_id']?>" class="btn btn-primary mb-3"> Tambah <?= $role['role_name']?> </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th width="34.9%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach ($user_all_list as $u_allt) {?> 
                        <tr id="tr">
                            <td><?= $no?></td>
                            <td><?= $u_allt['fullname'] ?></td>
                            <td><?= $u_allt['email']?></td>
                            <td>
                                <select class="form-control jbt"  name="id_jabatan" data-id_jbtn="<?=$u_allt['id_jabatan']?>"
                                data-role_id="<?=$role['role_id']?>" data-id_user=<?= $u_allt['id'] ?>>  
                                    <?=jabtan_combo($u_allt['id_jabatan'])?>
                                </select> 
                            </td>
                            <td>
                                <select class="form-control status"  name="status" data-idst="<?=$u_allt['is_active']?>"
                                data-role_id="<?=$role['role_id']?>" data-id_user=<?= $u_allt['id'] ?>>  
                                    <?=user_aktiv($u_allt['is_active'])?>
                                </select>
                            </td>
                            <td width="20%">
                                <div class="btn-group-vertical">
                                    <a href="<?= base_url()?>User_Managemen/edit_user/<?=$u_allt['id'] ?>/<?=$role['role_id']?>"  class="btn btn-primary"> Edit <i class="fa fa-edit"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#editpass_op" class="btn btn-info" id="tbl_editop" data-id_op="<?=$u_allt['id'] ?>"> Ubah Password <i class="fa fa-edit"></i></a>
                                    <a href="<?= base_url()?>User_Managemen/delUser/<?=$u_allt['id'] ?>/<?=$role['role_id']?>" class="btn btn-warning"> Hapus User   <i class="fas fa-trash"></i></i></a>
                                </div>
                            </td>
                        </tr> 
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
    <?php }else{
        redirect("User_Managemen");
    } ?>
 <div class="modal" id="editpass_op">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="label_tbhadmin">Ubah Password </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form action="<?= base_url()?>User_Managemen/edit_operator/<?=$role['role_id']?>" method="POST">
                    <div class="form-group">
                      <label id="nl">Nama Lengkap</label>
                      <input type="text" class="form-control"  name="fullname" id="fullnameop">
                      <input type="hidden" id="id" name="id">
                    </div>
                    <div class="form-group">
                      <label id="em">Email</label>
                      <input type="text"  class="form-control"  name="email" id="emailop">
                    </div>
                    <div class="form-group">
                      <label>Masukan Password Baru</label>
                      <input type="password" class="form-control" name="pass1" id="pass1op"> 
                    </div>
                    <button type="submit" class="btn btn-primary" >Edit Password</>
                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                  </form>
              </div>
            </div>
          </div>
<!-- End of Main Content -->
</div>
