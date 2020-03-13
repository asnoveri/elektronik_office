
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
                        $no=1;
                            foreach($srt_keluar as $sk){?>
                            <tr>
                                <td><?=$no?></td>
                                <td><?= nice_date($sk->tgl_surat_keluar, 'd-m-Y')?></td>
                                <td><?=jabatanget($sk->asal_surat) ?></td>
                                <td><?=$sk->perihal?></td>
                                <td><?=$sk->sifat_surat?></td>
                                <td>
                                    <div class="btn-group-vertical">
                                    <a href="<?= base_url()?>Managemen_Surat/detail_srt_keluar/<?=$sk->id_surat_keluar?>" class="btn btn-primary"> Detail </a>
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


