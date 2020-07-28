<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <?= $this->session->flashdata('pesanaddop'); ?>
            <h5 class="m-0 font-weight-bold text-secondary">Laporan Absensi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 mb-2">
                    <button type="button" class="btn btn-sm btn-primary mt-3" id="btn-ctk-perhari">
                        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Absensi Harian
                    </button>
                    <button type="button" class="btn btn-sm btn-info mt-3" id="btn-ctk-lembur">
                        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Absensi Lembur
                    </button>
                    <button type="button" class="btn btn-sm btn-success mt-3" id="btn-ctk-perbulan">
                        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Rekap Perpriode
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-3" id="btn-ctk-perbulan1">
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


<div class="modal" id="cetak_absensi">
    <div class="modal-dialog modal-sm">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal_absensi">Cetak Persensi Bulanan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="post" target="_blank">
                    <div class="form-group" id="slcgrp">
                        <select class="form-control" id="selusercetak" name="pegawai">
                            <option value=''>-- Pilih Pegawai --</option>
                        </select>
                    </div>
                    <div class="form-group" id="form-input-grp">
                        <input type="text" readonly class="form-control" name="tanggal" id="tgl_absen_cetak" placeholder="Pilih Tanggal">
                        <p id="pesan_eror"></p>
                        <input type="text" readonly class="form-control" name="tanggal1" id="tgl_absen_cetak1" placeholder="Pilih Tanggal Akhir">
                        <p id="pesan_eror1"></p>
                    </div>
                    <button type="submit" class="btn btn-primary" id="cetak">Cetak</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>