<?php
    if($role['role_id']==2){?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User_Managemen/"><span class="badge badge-success"> << List User</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <!-- <?= $this->session->flashdata('pesan');
                if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?> -->
            <h5 class="m-0 font-weight-bold text-secondary">List <?= $role['role_name']?></h5>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" id="aad_menu" data-toggle="modal" data-target="#tbhModal">
            Tambah <?= $role['role_name']?>
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
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
                            <td><?php 
                                if($u_allt['is_active']==1){
                                echo "Aktiv";
                                }else{
                                echo "Non Aktiv";
                                }?>
                            </td>
                            <td width="20%">
                                <div class="btn-group-vertical">
                                    <a href="" data-toggle="modal" data-target="#tbhModal" class="btn btn-primary" id="edit_mn" data-id_men="<?=$u_allt['role_id'] ?>"> Edit <i class="fa fa-edit"></i></a>
                                    <a href="<?= base_url()?>" class="btn btn-success"> Aktivkan <i class="fa fa-check"></i></a>
                                    <a href="<?= base_url()?>" class="btn btn-warning"> Non Aktivkan <i class="fa fa-times-circle"></i></a>
                                </div>
                            </td>
                        </tr> 
                        <?php $no++; } ?>
                    </tbody>
                </table>
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
        <a href="<?= base_url()?>User_Managemen/"><span class="badge badge-success"> << List User</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <!-- <?= $this->session->flashdata('pesan');
                if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?> -->
            <h5 class="m-0 font-weight-bold text-secondary">List <?= $role['role_name']?></h5>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" id="aad_menu" data-toggle="modal" data-target="#tbhModal">
            Tambah <?= $role['role_name']?>
            </button>
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
                        <tr>
                            <td><?= $no?></td>
                            <td><?= $u_allt['fullname'] ?></td>
                            <td><?= $u_allt['email']?></td>
                            <td><?= $u_allt['jabatan']?></td>
                            <td><?php 
                                if($u_allt['is_active']==1){
                                echo "Aktiv";
                                }else{
                                echo "Non Aktiv";
                                }?>
                            </td>
                            <td width="20%">
                                <div class="btn-group-vertical">
                                    <a href="" data-toggle="modal" data-target="#tbhModal" class="btn btn-primary" id="edit_mn" data-id_men="<?=$u_allt['role_id'] ?>"> Edit <i class="fa fa-edit"></i></a>
                                    <a href="<?= base_url()?>" class="btn btn-success"> Aktivkan <i class="fa fa-check"></i></a>
                                    <a href="<?= base_url()?>" class="btn btn-warning"> Non Aktivkan <i class="fa fa-times-circle"></i></a>
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

<!-- End of Main Content -->
</div>