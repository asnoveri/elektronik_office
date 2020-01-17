    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">      
            <?= $this->session->flashdata('pesan2');?> 
                <div class="row">  
                    <div class="col-sm-8">    
                            <h5 class="m-0 font-weight-bold text-secondary">List Role User</h5>
                    </div>
                    <div class="col-sm-2">
                        <a href="<?= base_url()?>Menu_Managemen/acces_user">
                            <h5><span class="badge badge-success"> Role Acces User << </span></h5>
                        </a>
                    </div>
                </div>   
            </div>
            <div class="card-body">
                <div class="row">  
                    <div class="col-sm-6">
                        <h5><?= $role['role_name'] ?></h5>
                        <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Hak Akses</th>
                                </tr>
                                </thead>
                            <tbody>
                            <?php
                            $no=0;
                                foreach ($all_cek_menu as $allcm) {?>
                                        <tr>
                                            <?php
                                                if($allcm['menu'] !='Menu Managemen'){?>
                                            <td><?=$no?></td>
                                            <td><?= $allcm['menu']?></td>
                                            <td class="centerd">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"  
                                                    <?=cek_akses_user($allcm['id_menu'],$role['role_id'])?>
                                                    data-role="<?= $role['role_id']?>"
                                                    data-menu="<?= $allcm['id_menu']?>"
                                                    >
                                                </div>
                                            </td>
                                            <?php }else{?>
                                               <?php } ?>
                                        </tr>
                                        <?php $no++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
        </div>    
    </div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->


