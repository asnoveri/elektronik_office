    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-secondary">List Surat Masuk</h5>
            </div>
            <div class="card-body">
               <?= get_tabel_srt_msk_peruser($this->session->userdata('id_jabatan'))?>
            </div>
        </div>
    </div>
</div>



