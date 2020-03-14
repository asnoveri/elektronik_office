    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>Managemen_Surat/srt_keluar" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Keluar</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">      
                <h5 class="m-0 font-weight-bold text-secondary">Status Surat Keluar Teruskan</h5>
               " <span class="text-black-50 font-font-weight-bolder text-uppercase"><?= jabatanget($surat_keluar->asal_surat) ?></span> -
                <span class="text-gray-500 font-weight-lighter font-italic"><?= nice_date($surat_keluar->tgl_surat_keluar, 'd-m-Y')?></span> "
            </div>
            <div class="card-body">  
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                            <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Surat Keluar Teruskan</th>
                                        <th>Status</th>
                                        <!-- <th>Feddback</th> -->
                                    </tr>
                            </thead>
                                <tbody>
                                <?php
                                $no=1;
                                    foreach ($surat_keluarter as $skt) {?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?= jabatanget($skt->di_teruskan_ke_srt_klr)?></td>
                                                <td>
                                                    <button type="button" class="w-100 btn btn-<?=$skt->bg_porgres_srt_keluar?>"><?= feedback($skt->id_feedback_terSrtKlr)?></button>
                                                </td>
                                                <!-- <td class="text-capitalize">
                                                    <?php 
                                                        if($sm->id_feedback==5){
                                                            echo $sm->di_tindak_lanjuti;
                                                        }else{
                                                        }
                                                    ?>
                                                </td> -->
                                            </tr>
                                            <?php $no++; } ?>
                                </tbody>
                            </table>
                    <!-- <div class="col-sm-5">disinia aka di buat semacam gambar poktekes</div>                -->
                </div> 
            </div>
        </div>    
<!-- /.container-fluid -->
    </div>
</div>
<!-- End of Main Content -->


