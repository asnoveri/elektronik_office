    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <?= $this->session->flashdata('pesan_surat1');?>
        
            <h5 class="m-0 font-weight-bold text-secondary">List Pengajuan Disposisi Surat Keluar</h5>
            </div>
            <div class="card-body">
                <a href="<?= base_url()?>User/surat_keluar" class="btn btn-primary btn-icon-split mb-3 "><span class="text">Tambah Surat Keluar</span>
                </a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Tanggal Surat Keluar</th>
                        <th>Perihal</th>
                        <th>Sifat Surat</th>
                        <th>Status Pengajuan</th>
                        <th>Disposisi</th>
                        <th>Penjabat PenDisposisi</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                            foreach($srt_keluar as $sk){?>
                            <tr>
                                <td><?=$no?></td>
                                <td><?= nice_date($sk->tgl_surat_keluar, 'd-m-Y')?></td>
                                <td><?=$sk->perihal?></td>
                                <td><?=$sk->sifat_surat?></td>
                                <td><button class="btn btn-<?= $sk->bg_porgres?>"><?= feedback($sk->id_feedback)?></button> </td>
                                <td><?php
                                        if($sk->id_feedback1==7){?>
                                            <button class="btn btn-warning"><?= feedback($sk->id_feedback1)?></button> 
                                        <?php } elseif($sk->id_feedback1==9) {?>
                                            <button class="btn btn-danger"><?= feedback($sk->id_feedback1)?></button> 
                                        <?php }
                                    ?>
                                </td>   
                                <td><?php
                                        if($sk->id_feedback1==7){?>
                                           <?= jabatanget($sk->yang_mendisposisi)?>
                                        <?php }  elseif($sk->id_feedback1==9) {?>
                                            <?= jabatanget($sk->yang_mendisposisi)?>
                                        <?php }
                                    ?>
                                </td>    
                                <td class="text-center">
                                    <div class="btn-group-vertical">
                                    <a href="<?= base_url()?>user/lihatFile_suratKlr/<?=$sk->id_surat_keluar?>" class="btn btn-primary" > Detail </a>
                                    </div>
                                </td>
                            </tr> 
                          <?php $no++; }?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




