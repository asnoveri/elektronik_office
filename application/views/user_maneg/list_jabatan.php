    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">      
            <?= $this->session->flashdata('msgjbtn');?>   
            <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>  
            <h5 class="m-0 font-weight-bold text-secondary">List Jabatan Pegawai </h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tbhjbt">
                Tambah Jabatan
                </button>
                <div class="row">  
                    <div class="col-sm-7">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                            <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jabatn Pegawai</th>
                                        <th>action</th>
                                    </tr>
                            </thead>
                                <tbody>
                                <?php
                                $no=1;
                                    foreach ($jabatan as $jbt) {?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?= $jbt['jabatan']?></td>
                                                <td width="33%">
                                                    <a href="<?= base_url()?>User_Managemen/hapusjbt/<?= $jbt['id_jabatan']?>" class="btn btn-warning"> Hapus Jabatan   <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>    
                    </div>
                    <!-- <div class="col-sm-5">disinia aka di buat semacam gambar poktekes</div>                -->
                </div> 
            </div>
        </div>    
        <!-- Tambah Menu Modal -->
            <div class="modal" id="tbhjbt">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Jabatan</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url()?>User_Managemen/add_jabatan" method="POST">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control"  name="jabatan">   
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            </form>
                        </div>
                    </div>
            </div>
    </div>
<!-- /.container-fluid -->
    </div>
</div>
<!-- End of Main Content -->


