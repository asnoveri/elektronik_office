
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Tanggal Surat Keluar</th>
                        <th>Asal Surat Keluar</th>
                        <th>Perihal</th>
                        <th>Sifat Surat</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                            foreach($srt_keluar as $sk){?>
                            <tr>
                                <td>
                                    <?php
                                        if($feeback[$i]==1){?>
                                            <span class="mr-2">
                                                <a href="#" data-toggle="tooltip" data-placement="right" title="Surat Keluar Belum di Lihat!"> 
                                                    <i class="fas fa-circle text-success" data-toggle="tooltip" data-placement="right"></i>
                                                </a>
                                            </span>
                                    <?php }elseif($feeback[$i]==2){?>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-gray-500"></i>
                                            </span>
                                    <?php }
                                    ?>
                                </td>
                                <td><?= nice_date($sk->tgl_surat_keluar, 'd-m-Y')?></td>
                                <td><?=jabatanget($sk->asal_surat) ?></td>
                                <td><?=$sk->perihal?></td>
                                <td><?=$sk->sifat_surat?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                                            <i class="fas fa-fw fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php
                                                if($feeback[$i]==1){?>
                                                    <a href="<?= base_url()?>Managemen_Surat/detail_srt_keluar/<?=$sk->id_surat_keluar?>" class="dropdown-item ubah_feedback_skopadmn" data-id_terus_srt_klr="<?=$id_terus_srt_keluar[$i] ?>"> Detail </a>
                                                <?php } elseif($feeback[$i]==2){?>
                                                    <a href="<?= base_url()?>Managemen_Surat/detail_srt_keluar/<?=$sk->id_surat_keluar?>" class="dropdown-item"> Detail </a>
                                                    <a href="<?= base_url()?>Managemen_Surat/status_srt_keluar_kepjbt/<?=$sk->id_surat_keluar?>" class="dropdown-item"> Status Surat Keluar Teruskan </a>
                                                <?php }
                                            ?>
                                        </div>    
                                    </div>          
                                </td>
                            </tr> 
                        <?php  $i++; }?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


