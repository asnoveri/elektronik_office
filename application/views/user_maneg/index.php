    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">        
            <h5 class="m-0 font-weight-bold text-secondary">List Role User</h5>
            </div>
            <div class="card-body">
                <div class="row">  
                    <div class="col-sm-6">
                        <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Role</th>
                                    <th>action</th>
                                </tr>
                                </thead>
                            <tbody>
                            <?php
                            $no=1;
                                foreach ($user_all_rolelist as $uall) {?>
                                        <tr>
                                            <td><?=$no?></td>
                                            <td><?= $uall['role_name']?></td>
                                            <td>
                                                <a href="<?= base_url()?>User_Managemen/list_all_user/<?= $uall['role_id']?>" class="btn btn-success"> List <?= $uall['role_name']?> 
                                                </a>
                                            </td>
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


