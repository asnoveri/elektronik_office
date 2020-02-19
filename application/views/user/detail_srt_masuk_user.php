    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User/list_srt_msk_user" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Masuk</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4" >
            <div class="card-header py-3">    
            <h5 class="m-0 font-weight-bold text-secondary">Detail Surat Masuk</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#detail_surat_masuk_user">Informasi Detail Surat Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#file_srtmsk_user" id="fl_in_mesage">File Surat Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#action_srt_msk_user" id="action_srt_msk">Action</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane container active" id="detail_surat_masuk_user">
                        <div class="card shadow mt-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-secondary text-center">
                                    <span>Politeknik Kesehatan Kemenkes Riau</span> 
                                </h5>
                                <p class="m-0 font-weight-bold text-secondary text-center">Lembar Disposisi</p>
                            </div>
                            <div class="card-body py-2 ">
                                <div class="row border-bottom" >
                                    <div class ="col-sm-6">
                                        <p><span class="font-weight-bold"> Tanggal Surat Masuk : <?= nice_date($detail_srt_masuk->tgl_surat_masuk, 'd-m-Y')?> </span></p>
                                    </div>
                                    <div class ="col-sm-6">
                                        <p><span  class="font-weight-bold"> Sifat Surat : <?=$detail_srt_masuk->sifat_surat?></span></p>
                                    </div>
                                </div>
                                <div class="row border-bottom" >
                                    <div class ="col-sm-12">
                                        <p><span  class="font-weight-bold">Kode :</span></p>
                                    </div>
                                </div>
                                <div class="border-bottom" >
                                    <div class="row">
                                        <div class ="col-sm-4">
                                            <p><span  class="font-weight-bold">Tanggal / Nomor Surat </span></p>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold">: <?= $detail_srt_masuk->no_surat?></span></p>
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class ="col-sm-4">
                                            <p><span  class="font-weight-bold">Asal  Surat </span></p>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold">: <?= $detail_srt_masuk->asal_surat?> </span></p>
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class ="col-sm-4">
                                            <p><span  class="font-weight-bold">Isi Ringkas</span></p>
                                            <?= $this->session->userdata('id_jabatan')?>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold">: <?= $detail_srt_masuk->perihal ?> </span></p>
                                        </div>
                                    </div>    
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="file_srtmsk_user">
                        <div class="card shadow mt-4" >    
                            <div class="card-body py-2  pdfview" data-pdf="<?= $detail_srt_masuk->file_surat ?>">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="action_srt_msk_user">
                        <div class="card shadow mt-4" >    
                            <div class="card-header py-3">
                                <p class="m-0 font-weight-bold text-secondary text-center">Aksi Disposisi Surat Masuk</p>
                            </div>
                            <div class="card-body">
                                <form  method="POST" action="<?= base_url()?>user/add_suratmasuk_diteruskan">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="hidden" class="form-control" name="id_surat_masuk" value="<?= $detail_srt_masuk_ter->id_surat_masuk?>">
                                            <div class="form-group ">
                                                <label for="">Teruskan Disposisi Surat Masuk</label>
                                                <select  class="custom-select custom-select mb-" name="di_teruskan_ke">
                                                    <option selected>Pilih</option>
                                                    <?php
                                                        foreach($jabatan as $jbt){?>
                                                            <option value="<?=$jbt['id_jabatan']?>"> <?= $jbt['jabatan']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="">Instruksi</label>
                                                <input type="text" class="form-control" name="instruksi">
                                            </div> -->
                                            <button type="submit" class="btn btn-primary" >Teruskan</button>
                                             <button type="reset" class="btn btn-danger">Batal</button>
                                    </div>        
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>


