    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>Managemen_Surat/list_dftr_srt_msk" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-right"></i></span><span class="text">List Surat Masuk</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">   
            <?= $this->session->flashdata('pesan_surat')?>
            <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>   
            <h5 class="m-0 font-weight-bold text-secondary">Tambahkan Surat Masuk</h5>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart(base_url("Managemen_Surat/add_surat")); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Tanggal Surat Masuk</label>
                                <input type="text" class="form-control" id="datetimepicker1" autocomplete="off" name="tgl_surat_masuk" value="<?=set_value('tgl_surat_masuk') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Asal Surat Masuk</label>
                                <input type="text" class="form-control" name="asal_surat" value="<?=set_value('asal_surat') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Sifat Surat</label>
                                <select name="sifat_surat" class="custom-select custom-select mb-3">
                                    <option selected> Pilih Sifat Surat </option>
                                    <option value="Rahasia"> Rahasia </option>
                                    <option value="Penting"> Penting </option>
                                    <option value="Biasa"> Biasa </option>
                                    <option value="Segera"> Segera </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Upload Surat Masuk</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input"  name="file_surat">
                                    <label class="custom-file-label" for="customFile">Pilih file Surat Masuk</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">No Surat Masuk</label>
                                <input type="text" class="form-control" name="no_surat" value="<?=set_value('no_surat') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Perihal</label>
                                <input type="text" class="form-control" name="perihal"  value="<?=set_value('perihal') ?>">
                            </div>
                            <div class="form-group ">
                                <label for="">Di Teruskan Ke</label>
                                <div class="diter">
                                    <input type="hidden" readonly  class=" form-control" name="di_teruskan_ke" value="<?= $adum->id_jabatan ?>">
                                    <input type="text" readonly  class=" form-control" value="<?= $adum->jabatan ?>">
                                </div>
                                <select  class="custom-select custom-select mb-3 slt">
                                    <option selected>Pilih</option>
                                    <?php
                                        foreach($jabatan as $jbt){?>
                                            <option value="<?=$jbt['id_jabatan']?>"> <?= $jbt['jabatan']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="">
                                <div class="custom-control custom-checkbox mt-1">
                                    <input type="checkbox" class="custom-control-input cekter" id="customCheck" name="example1">
                                    <label class="custom-control-label" for="customCheck">Ubah Di Teruskan</label>
                                </div>
                            </div>    
                            <!-- <div class="form-group">
                                <label for="">Instruksi</label>
                                <input type="text" class="form-control" name="instruksi"  value="<?=set_value('instruksi') ?>">
                            </div> -->
                        </div>
                    </div>
              
                    <button type="submit" class="btn btn-primary" >Tambah</button>
                    <button type="reset" class="btn btn-danger">Batal</button>
                </form>
            </div>
        </div>    
    </div>
</div>


