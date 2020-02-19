    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>Managemen_Surat/list_dftr_srt_msk" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Masuk</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4" >
            <div class="card-header py-3">    
            <h5 class="m-0 font-weight-bold text-secondary">Detail Surat Masuk</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#detail_surat_masuk">Informasi Detail Surat Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#file_srtmsk" id="fl_in_mesage">File Surat Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#history_srt_msk" id="history_srt">History</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane container active" id="detail_surat_masuk">
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
                                            <p><span  class="font-weight-bold">si Ringkas</span></p>
                                        </div>
                                        <div class ="col-sm-6">
                                            <p><span  class="font-weight-bold">: <?= $detail_srt_masuk->perihal ?> 
                                            </span></p>
                                        </div>
                                    </div>    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="file_srtmsk">
                        <div class="card shadow mt-4" >    
                            <div class="card-body py-2  pdfview" data-pdf="<?= $detail_srt_masuk->file_surat ?>">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="history_srt_msk">
                        <div class="card shadow mt-4" >    
                            <div class="progress">
                            <!-- <?php
                                foreach($detail_srt_masuk_ter as $dtrsmk){?>
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?=$dtrsmk->bg_porgres?>" role="progressbar" style="width: 30%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                    <?php if( $dtrsmk->di_kirimkan_oleh == 0){?>
                                    <?php }else {?>
                                        <?= " Surat Masuk Dari ". jabatanget($dtrsmk->di_kirimkan_oleh)?>
                                        <?php } ?>
                                    <?= feedback($dtrsmk->id_feedback);?>   <?=jabatanget($dtrsmk->di_teruskan_ke)?>
                                    </div>
                                    
                                <?php } ?>     -->
                            </div>
                            <div class="card-body">
                            <?php
                                foreach($detail_srt_masuk_ter as $dtrsmk){?>
                                <h4 class="small font-weight-bold">
                                <?php 
                                    if( $dtrsmk->di_kirimkan_oleh == 0){?>
                                    <?php }else {?>
                                            <?= " Surat Masuk Dari ". jabatanget($dtrsmk->di_kirimkan_oleh)?>
                                    <?php } ?>
                                    <?= feedback($dtrsmk->id_feedback);?>   <?=jabatanget($dtrsmk->di_teruskan_ke)?>
                                    <span class="float-right">
                                        <?php 
                                        if($dtrsmk->id_feedback==1){
                                            echo $prog="50%";
                                        }elseif($dtrsmk->id_feedback==2){
                                            echo $prog="100%";
                                        }elseif($dtrsmk->id_feedback==3){
                                            echo $prog="100%";
                                        }    
                                        ?>
                                     </span>
                                </h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?=$dtrsmk->bg_porgres?>" role="progressbar" style="width: <?= $prog ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <?php } ?>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>


