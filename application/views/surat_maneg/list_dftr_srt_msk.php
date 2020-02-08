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
        
            <h5 class="m-0 font-weight-bold text-secondary">List Surat Masuk</h5>
            </div>
            <div class="card-body">
                <a href="<?= base_url()?>Managemen_Surat" class="btn btn-primary btn-icon-split mb-3 "><span class="text">Tambah Surat Masuk</span>
                </a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Tanggal Surat Masuk</th>
                        <th>Asal Surat</th>
                        <th>Perihal</th>
                        <th>Sifat Surat</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                            foreach($srt_masuk as $sm){?>
                            <tr>
                                <td><?=$no?></td>
                                <td><?= nice_date($sm->tgl_surat_masuk, 'd-m-Y')?></td>
                                <td><?=$sm->asal_surat ?></td>
                                <td><?=$sm->perihal?></td>
                                <td><?=$sm->sifat_surat?></td>
                                <td>
                                    <div class="btn-group-vertical">
                                    <a href="<?= base_url()?>Managemen_Surat/detail_srt_masuk/<?=$sm->id_surat_masuk?>" class="btn btn-primary"> Detail </a>
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



