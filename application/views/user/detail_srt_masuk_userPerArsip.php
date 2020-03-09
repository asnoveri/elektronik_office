    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
            <a href="<?= base_url()?>User/arsip_srt_masuk" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Masuk Di Arsipkan</span></a>
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
                <h5 class="m-0 font-weight-bold text-secondary">Detail Surat Masuk Di Arsipkan</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#detail_surat_masuk_user">Informasi Detail Surat Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#file_srtmsk_user" id="fl_in_mesage">File Surat Masuk</a>
                    </li>
                </ul>
                <div class="tab-content mt-4">
                    <div class="tab-pane container active" id="detail_surat_masuk_user">
                        <div class="row border-bottom" >
                            <div class ="col-sm-12 font-weight-bold text-secondary text-center">
                                <span>Politeknik Kesehatan Kemenkes Riau</span> <br>
                                <small class="m-0 font-weight-bold text-secondary text-center">Lembar Disposisi</small>
                            </div> 
                        </div>
                        <div class="row border-bottom" >
                            <div class ="col-sm-6">
                                <p><span class="font-weight-normal"> Tanggal Surat Masuk : <?= nice_date($detail_srt_masuk->tgl_surat_masuk, 'd-m-Y')?> </span></p>
                            </div>
                            <div class ="col-sm-6">
                                <p><span  class="font-weight-normal"> Sifat Surat : <?=$detail_srt_masuk->sifat_surat?></span></p>
                            </div>
                        </div>
                        <div class="row border-bottom" >
                            <div class ="col-sm-12">
                                <p><span  class="font-weight-normal">Kode :</span></p>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal">Tanggal / Nomor Surat </span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: <?= $detail_srt_masuk->no_surat?></span></p>
                            </div>
                        </div>    
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal">Asal  Surat </span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: <?= $detail_srt_masuk->asal_surat?> </span></p>
                            </div>
                        </div>    
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal">Isi Ringkas</span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: <?= $detail_srt_masuk->perihal ?> </span></p>
                            </div>
                        </div>
                                    <?php
                                    // jika pengirim 14/adum dan peneriman direktur
                                        if($detail_srt_masuk_ter->di_kirimkan_oleh== 14 & jabatanget($this->session->userdata('id_jabatan'))=='Direktur') {?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Untuk Di Ketahui <?= jabatanget($this->session->userdata('id_jabatan'))?> Poltekkes Riau </span></p>
                            </div>
                        </div>    
                                            
                                    <?php 
                                     // jika pengirim 14/adum dan peneriman Wakil Direktur 1
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==14 & jabatanget($this->session->userdata('id_jabatan'))=='Wakil Direktur 1'){?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Untuk Di Ketahui <?= jabatanget($this->session->userdata('id_jabatan'))?> Poltekkes Riau </span></p>
                            </div>
                        </div>
                                    <?php 
                                     // jika pengirim 14/adum dan peneriman Wakil Direktur 2
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==14 & jabatanget($this->session->userdata('id_jabatan'))=='Wakil Direktur 2'){?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Untuk Di Ketahui <?= jabatanget($this->session->userdata('id_jabatan'))?> Poltekkes Riau </span></p>
                            </div>
                        </div>
                                    <?php 
                                 // jika pengirim 14/adum dan peneriman Wakil Direktur 3
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==14 & jabatanget($this->session->userdata('id_jabatan'))=='Wakil Direktur 3'){?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Untuk Di Ketahui <?= jabatanget($this->session->userdata('id_jabatan'))?> Poltekkes Riau </span></p>
                            </div>
                        </div>
                                    <?php 
                                 // jika pengirim 14/direktur dan peneriman Wakil Direktur 1
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==1 & jabatanget($this->session->userdata('id_jabatan'))=='Wakil Direktur 1'){?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Diketahui Direktur Poltekkes Kemenkes Riau </span></p>
                            </div>
                        </div>
                                    <?php 
                                 // jika pengirim 14/adum dan peneriman Wakil Direktur 2
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==1 & jabatanget($this->session->userdata('id_jabatan'))=='Wakil Direktur 2'){?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Diketahui Direktur Poltekkes Kemenkes Riau </span></p>
                            </div>
                        </div>
                                    <?php 
                                 // jika pengirim 14/adum dan peneriman Wakil Direktur 3
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==1 & jabatanget($this->session->userdata('id_jabatan'))=='Wakil Direktur 3'){?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal"><?= jabatanget($detail_srt_masuk_ter->di_kirimkan_oleh)?></span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Diketahui Direktur Poltekkes Kemenkes Riau </span></p>
                            </div>
                        </div>       
                                    <?php
                                    // jika pengirim 0/admin/operator
                                }else if($detail_srt_masuk_ter->di_kirimkan_oleh==0){?>  
                                    <?php }else{?>
                        <div class="row border-bottom">
                            <div class ="col-sm-4">
                                <p><span  class="font-weight-normal">Wakil Direktur / KA. Sub Adum</span></p>
                            </div>
                            <div class ="col-sm-8">
                                <p><span  class="font-weight-normal">: Diketahui Direktur Poltekkes Kemenkes Riau </span></p>
                            </div>
                        </div>    
                                    <?php }?>
                        <div class="row">            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Di Teruskan Kepada</th>
                                        <th class="text-center">Instruksi/Informasi Direktur</th>
                                    </tr>
                                </thead>   
                                <tbody>      
                                    <tr>
                                        <td><?= jabatanget($detail_srt_masuk_ter->di_teruskan_ke) ?></td>
                                        <td class="text-capitalize"><?= $detail_srt_masuk_ter->instruksi?></td>
                                    </tr>
                                </tbody>
                            </table>      
                        </div>             
                    </div>
                    <div class="tab-pane container fade" id="file_srtmsk_user">
                        <div class="card-body py-2  pdfview" data-pdf="<?= $detail_srt_masuk->file_surat ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>


