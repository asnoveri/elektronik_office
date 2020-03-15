    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-secondary">List Surat Keluar</h5>
                <?= $this->session->flashdata('pesan_surat1');?>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <div class="form-inline">
                            <label class="mr-sm-3">Tanggal:</label>
                            <input class="form-control" id="datetimepicker" type="text" placeholder="Pilih Tanggal.." >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-inline">
                            <label class="mr-sm-3">Search:</label>
                            <input class="form-control" id="myInput" type="text" placeholder="Cari disini.." >
                        </div>
                    </div>
                </div>
                <table class="table  " id="myList">
                    <thead>
                        <tr></tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        foreach($data_srtklr as $dsk){?>
                        <tr>
                            <td style="width:90px">
                                <?php
                                    if($fedbk[$i]==1){?>
                                        <span class="mr-2">
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="Surat Keluar Belum di Lihat!"> 
                                                <i class="fas fa-circle text-success" data-toggle="tooltip" data-placement="right"></i>
                                            </a>
                                        </span>
                                    <?php }elseif($fedbk[$i]==2){?>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-gray-500"></i>
                                        </span>
                                        <?php }
                                        ?>
                            </td>
                            <td style="width:200px">
                                <a class="ubah_feedback_sk text-decoration-none ubah_feedback_sk" data-id_terus_srt_klr="<?= $id_trsk[$i]?>"data-id_surat_keluar="<?=$dsk->id_surat_keluar ?>" href="<?= base_url()?>user">
                                    <span class="text-gray-500 font-weight-lighter font-italic"><?= nice_date($dsk->tgl_surat_keluar, 'd-m-Y')?> -</span>
                                    <span class="text-black-50 font-font-weight-bolder text-uppercase"><?=jabatanget($dsk->asal_surat) ?></span>
                                </a>
                            </td>
                            <td style="width:400px">
                                <a class="ubah_feedback_sk text-decoration-none ubah_feedback_sk" data-id_terus_srt_klr="<?= $id_trsk[$i]?>"data-id_surat_keluar="<?=$dsk->id_surat_keluar ?>" href="<?= base_url()?>user">
                                    <span class="text-gray-500 text-capitalize "><?=$dsk->perihal?></span>
                                </a>
                            </td>
                            <td style="width:110px">
                                <a class="ubah_feedback_sk text-decoration-none ubah_feedback_sk" data-id_terus_srt_klr="<?= $id_trsk[$i]?>"data-id_surat_keluar="<?=$dsk->id_surat_keluar ?>" href="<?= base_url()?>user">
                                    <span class="text-gray-500 font-weight-lighter font-italic">
                                        <?= $dsk->sifat_surat?>
                                    </span>
                                </a>
                            </td>
                            <td style="width:90px">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-fw fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php
                                            if($fedbk[$i]==1){?>
                                            <a class="dropdown-item ubah_feedback_sk" data-id_terus_srt_klr="<?= $id_trsk[$i]?>"data-id_surat_keluar="<?=$dsk->id_surat_keluar ?>" href="<?= base_url()?>user/">Lihat Surat Keluar</a>
                                        <?php }elseif($fedbk[$i]==2){?>
                                            <a class="dropdown-item ubah_feedback_sk" data-id_terus_srt_klr="<?= $id_trsk[$i]?>"data-id_surat_keluar="<?=$dsk->id_surat_keluar ?>" href="<?= base_url()?>user/">Lihat Surat Keluar</a>
                                            <a class="dropdown-item" href="<?= base_url()?>user/">Arsipkan SuratS Keluar</a>
                                        <?php }?>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; }
                    ?>
                    </tbody>
                </table>      
            </div>
        </div>
    </div>
</div>



