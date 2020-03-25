    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
            <a href="<?= base_url()?>User/list_pengajuan_srt_klr" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Keluar</span></a>
        </div>
        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>  
            <h5 class="m-0 font-weight-bold text-secondary">Detail Disposisi Surat Keluar</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#detail_surat_masuk">Informasi Detail Disposisi Surat Keluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#file_srtmsk" id="fl_in_mesage">File Disposisi Surat Keluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#action_srt_msk_user" id="action_srt_msk">Action</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane container active" id="detail_surat_masuk">
                        <div class="card shadow mt-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-secondary text-center text-capitalize">
                                    <span>Politeknik Kesehatan Kemenkes Riau</span> 
                                </h5>
                                <p class="m-0 font-weight-bold text-secondary text-center text-capitalize">Lembar Pengajuan Disposisi </p>
                                <p class="m-0 font-weight-bold text-secondary text-center text-capitalize">Surat Keluar</p>
                            </div>
                            <div class="card-body py-2 ">
                                <div class="row border-bottom" >
                                    <div class ="col-sm-6">
                                        <p><span class="font-weight-bold text-capitalize"> Tanggal Surat Keluar : <?= nice_date($srt_keluarbyId->tgl_surat_keluar, 'd-m-Y')?> </span></p>
                                    </div>
                                    <div class ="col-sm-6">
                                        <p><span  class="font-weight-bol text-capitalized"> Sifat Surat : <?=$srt_keluarbyId->sifat_surat?></span></p>
                                    </div>
                                </div>
                                <div class="row border-bottom" >
                                    <div class ="col-sm-12">
                                        <p><span  class="font-weight-bold text-capitalize">Kode :</span></p>
                                    </div>
                                </div>
                                <div class="border-bottom" >
                                    <div class="row">
                                        <div class ="col-sm-4">
                                            <p><span  class="font-weight-bold text-capitalize">Tanggal / Nomor Surat </span></p>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold text-capitalize">: <?= $srt_keluarbyId->no_surat_keluar?></span></p>
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class ="col-sm-4">
                                            <p><span  class="font-weight-bold text-capitalize">Asal Surat Keluar </span></p>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold text-capitalize">: <?=jabatanget($srt_keluarbyId->asal_surat) ?>
                                            </span></p>
                                        </div>
                                    </div>   
                                    <div class="row">
                                        <div class ="col-sm-4">
                                            <p><span  class="font-weight-bold text-capitalize">Perihal</span></p>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold text-capitalize">: <?= $srt_keluarbyId->perihal ?> 
                                            </span></p>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="file_srtmsk">
                        <div class="card shadow mt-4" >    
                            <div class="card-body py-2  pdfview" data-pdf="<?= $srt_keluarbyId->file_surat ?>">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="action_srt_msk_user">
                        <div class="row">
                            <div class="col-sm-6">
                                <form  method="POST" action="<?= base_url()?>user/add_feedback_srtkeluar/<?=$srt_keluarbyId->id_surat_keluar?>">
                                    <input type="hidden" class="form-control" name="id_surat_keluar" value="<?= $srt_keluarbyId->id_surat_keluar?>">
                                    <div class="form-group mt-3">
                                            <label for="">Pilih Action Disposisi Surat Keluar</label>
                                            <select  class="custom-select custom-select " name="id_feedback1">
                                                <option value="" selected>Pilih</option>
                                                <option value="7"> Setujui</option>
                                                <option value="9"> Tolak</option>
                                            </select>
                                    </div>        
                                    <!-- <div class="form-group">
                                    <label for="">Instruksi</label>
                                        <textarea class="form-control" rows="3" id="comment" name="instruksi"></textarea>
                                    </div>  -->
                                            <button type="submit" class="btn btn-primary" >Teruskan</button>
                                            <button type="reset" class="btn btn-danger">Batal</button>
                                </form>
                            </div>
                                <!-- <div class="form-group">
                                    <label for="">Instruksi</label>
                                        <input type="text" class="form-control" name="instruksi">
                                </div>  -->   
                    </div>
                </div>
            </div>
        </div>
    </div>




