    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User/list_dftr_srt_keluarPerUser" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-right"></i></span><span class="text">List Surat Keluar</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">   
            <?= $this->session->flashdata('pesan_surat_keluar')?>
            <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>   
            <h5 class="m-0 font-weight-bold text-secondary">Ajukan Disposisi Surat Keluar</h5>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart(base_url("user/add_surat_keluar")); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Tanggal Surat Keluar</label>
                                <input type="text" class="form-control" id="datetimepicker1" autocomplete="off" name="tgl_surat_keluar" value="<?=set_value('tgl_surat_keluar') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Sifat Surat Keluar</label>
                                <select name="sifat_surat" class="custom-select custom-select mb-3">
                                    <option selected> Pilih Sifat Surat </option>
                                    <option value="Rahasia"> Rahasia </option>
                                    <option value="Penting"> Penting </option>
                                    <option value="Biasa"> Biasa </option>
                                    <option value="Segera"> Segera </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Upload Surat Keluar</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input"  name="file_surat">
                                    <label class="custom-file-label" for="customFile">Pilih file Surat Masuk</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">No Surat Keluar</label>
                                <input type="text" class="form-control" name="no_surat_keluar" value="<?=set_value('no_surat_keluar') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Perihal</label>
                                <input type="text" class="form-control" name="perihal"  value="<?=set_value('perihal') ?>">
                            </div>
                        </div>
                    </div>
              
                    <button type="submit" class="btn btn-primary" >Upload</button>
                    <button type="reset" class="btn btn-danger">Batal</button>
                </form>
            </div>
        </div>    
    </div>
</div>


