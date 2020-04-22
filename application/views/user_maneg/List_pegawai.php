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
                
            <h5 class="m-0 font-weight-bold text-secondary">List Pegawai Poltekkes</h5>
            </div>
            <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" id="tbhpegawai">
            Tambah Pegawai
            </button>
                <div class="row">  
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabl_pegawai" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pegawai</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Unit Kerja</th>
                                        <th>Jabatan</th>
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

    <div class="modal" id="modal_adum">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="label_Tambpeg">Tambah Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url()?>User_Managemen/add_adum" method="POST">
                        <div class="form-group">
                            <label>Pilih Pegawai</label>
                            <!-- <input type="text" class="form-control" id="pegawai" name="id"> -->
                            <select class="form-control" id="sel1" name="pegawai"> 
                                <option value=''>-- Pilih Pegawai --</option>   
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="tbl_prosessk">Tambah</button>
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->


