<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <?= $this->session->flashdata('pesanaddop'); ?>
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= validation_errors(); ?>
                </div>
            <?php  } ?>
            <!-- <div class="alert alert-info">
                    <strong><i class="fas fa-info-circle"></i> Info :</strong>
                    Jika User dihapus Role/Jabatan yang dimiliki User juga Akan Ikut terhapus !!!
                </div> -->
            <h5 class="m-0 font-weight-bold text-secondary">Laporan Absensi</h5>
        </div>
        <div class="card-body">
            <!-- <button type="button" class="btn btn-primary mb-3" id="aad_user" data-toggle="modal" data-target="#tbhuser">
                    Tambah User
                </button> -->
            <div class="row">
                <div class="col-sm-10">
                    <button type="button" class="btn btn-sm btn-dark" id="btn-ctk-perhari">
                        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Absensi Harian
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary">
                        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Absensi Bulanan
                    </button>
                </div>
                <div class="col-sm-2 mb-1">
                    <input type='text' readonly id='search_fromdate' class="waktu_absen form-control" placeholder="Pilih Tanggal">
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbl_absensi_all" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Absensi Masuk</th>
                                    <th>Absensi Pulang</th>
                                    <th>Keterangan Keberadaan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="cetak_absensi">
    <div class="modal-dialog modal-sm">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal_absensi">Cetak Persensi Harian</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="post" target="_blank">
                    <div class="form-group">
                        <input type="text" readonly class="form-control" name="tanggal" id="tgl_absen_cetak" placeholder="Pilih Tanggal">
                        <p id="pesan_eror"></p>
                    </div>
                    <button type="submit" class="btn btn-primary" id="cetak">Cetak</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>