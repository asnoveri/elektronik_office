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
            <h5 class="m-0 font-weight-bold text-secondary">Laporan Absensi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 mb-2">
                    <div class="clearfix">
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
                        <button type="button" class="btn btn-sm btn-primary mt-3 float-right" id="btn-input-absen">
                            <i class="fas fa-plus fa-sm text-white-50 "></i> Input Absensi
                        </button>
                    </div>
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
                                    <th>Keterangan</th>
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

<div class="modal" id="modal_inputAbsen">
    <div class="modal-dialog ">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal_absensi">Input Absensi Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url() ?>Absensi/addInputAbsen" method="post">
                    <div class="form-group">
                        <label for="">Pilih Pegawai</label>
                        <select class="form-control" id="seluserInputAbsn" name="pegawai">
                            <option value=''>-- Pilih Pegawai --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="">Pilih Tanggal</label>
                                <input type="text" readonly class="form-control mb-3" name="tanggal" id="tgl_absen_user" placeholder="Pilih Tanggal">
                            </div>
                            <div class="col-sm-12">
                                <label for="">Pilih Keterangan Keberadaan</label>
                                <select name="ket_keberadaan" class="custom-select" id="ketIptabsnPeg">
                                    <option value="">Pilih Keterangan Keberadaan</option>
                                    <option value="piket kantor">Piket Kantor</option>
                                    <option value="piket kantor rengat">Piket Kantor Rengat</option>
                                    <option value="wfh">WFH</option>
                                    <option value="izin (sakit/cuti)">Izin (Sakit / Cuti)</option>
                                    <option value="dl">Perjalanan Dinas</option>
                                    <option value="lembur">Lembur</option>
                                </select>
                            </div>
                            <div class="col-sm-12 mt-2" id="pilihKet">
                                <label for="">Pilih Keterangan</label>
                                <select name="ket" class="custom-select custom-select-sm">
                                    <option value="">Pilih Keterangan</option>
                                    <option value="izin">Izin</option>
                                    <option value="cuti">Cuti</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="izin kusus">Izin Kusus</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="">Pilih Jam Masuk</label>
                                <input type="time" class="form-control mb-3" name="absensi_masuk">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="">Pilih Jam Masuk</label>
                                <input type="time" class="form-control mb-3" name="absensi_keluar">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-danger">Batal</button>
                </form>
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