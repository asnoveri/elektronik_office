    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <!-- <a href="<?= base_url()?>Managemen_Surat/list_dftr_srt_msk" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Masuk</span></a> -->
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">    
            <h5 class="m-0 font-weight-bold text-secondary">Kelola Alur Surat Masuk</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#alur_srt_msk">Alur Surat Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#alur_srt_keluar">Alur Surat Keluar</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane container active" id="alur_srt_msk">
                        
                    </div>
                    <div class="tab-pane container fade" id="alur_srt_keluar">
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>


