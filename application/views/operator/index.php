   <!-- Begin Page Content -->
   <div class="container-fluid">

     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800"><?= $judul ?> </h1>
     </div>

     <!-- Content Row -->
     <div class="row">
       <div class="col-lg-6 mb-4">

         <!-- Illustrations -->
         <div class="card shadow mb-4">
           <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-secondary">Absensi</h6>
             <?= $this->session->flashdata('erorabsen'); ?>
             <div id="pesan-eror" style="display: none;">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
             </div>
           </div>
           <div class="card-body">
             <div class="text-center">
               <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url() ?>assets/images/undraw_posting_photo.svg" alt="">
             </div>
             <div class="alert alert-secondary" role="alert">
               <p>Sudah isi absenkah anda Hari ini....??</p>
               <marquee>
                 <p class="text-danger font-italic" style="font-size:12px;"> * NOTE : Setelah melakukan Pengambilan Absensi, Silahkan di Cek Masuk / Tidaknya Absensi Anda Pada Tabel list Absensi</p>
               </marquee>
             </div>
             <!-- <p id="md" class="shadow-lg text-center"></p> -->
             <div class="row">
               <div class="col-sm-6 text-center">
                 <a href="#" class="btn btn-primary btn-icon-split btn-sm" id="absen-masuk">
                   <span class="icon text-white-50">
                     <i class="fas fa-info-circle"></i>
                   </span>
                   <span class="text">Absen Masuk</span>
                 </a>
               </div>

               <div class="col-sm-6 text-center">
                 <a href="" class="btn btn-primary btn-icon-split btn-sm" id="absen-pulang">
                   <span class="icon text-white-50">
                     <i class="fas fa-info-circle"></i>
                   </span>
                   <span class="text">Absen Pulang</span>
                 </a>
                 <input type="hidden" class="usrket" value="<?= @$cek_absenKel->ket_keberadaan ?>"></input>
               </div>

               <div class="col-sm-6 text-center mt-2">
                 <p><span class="badge badge-secondary"><?= $jadwal_absen->jam_masuk; ?></span></p>
               </div>

               <div class="col-sm-6 text-center mt-2">
                 <p><span class="badge badge-secondary jk" data-id="<?= $jadwal_absen->jam_keluar; ?>" data-role="<?= $this->session->userdata('role_id'); ?>"><?= $jadwal_absen->jam_keluar; ?></span></p>
               </div>
             </div>
           </div>
         </div>
       </div>
       <div class="col-lg-6 mb-4">

         <!-- Illustrations -->
         <div class="card shadow mb-4">
           <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-secondary">List Absensi Anda</h6>
           </div>
           <div class="card-body">
             <div class="row">
               <div class="col-sm-3 mb-1">
                 <input type='text' readonly id='search_fromdate1' class="waktu_absen form-control" placeholder="Pilih Tanggal">
               </div>
               <div class="col-sm-12">
                 <div class="table-responsive">
                   <table class="table table-bordered" id="tbl_absensi_forUser" width="100%" cellspacing="0">
                     <thead>
                       <tr>
                         <th>#</th>
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
     </div>


     <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal_absn">
       <div class="modal-dialog modal-sm">
         <div class="modal-content">
           <div class="modal-header">
             <h4 class="modal-title"> Absen Masuk</h4>
             <button type="button" class="close" data-dismiss="modal">×</button>
           </div>

           <!-- Modal body -->
           <div class="modal-body">
             <form>
               <div class="form-group">
                 <label>Keterangan / Keberadaan hari ini</label>
                 <?php
                  $tgl = get_indo_libur(date('Y-m-d'));
                  if ($tgl == "tanggal merah hari Sabtu" || $tgl == "tanggal Merah Hari Minggu") { ?>
                   <select name="ket_keberadaan" class="custom-select" id="sel-keberadaan">
                     <option value="lembur">Lembur</option>
                   </select>
                 <?php } else { ?>
                   <select name="ket_keberadaan" class="custom-select" id="sel-keberadaan">
                     <option value="piket kantor">Piket Kantor</option>
                     <option value="piket kantor rengat">Piket Kantor Rengat</option>
                     <option value="wfh">WFH</option>
                     <option value="izin (sakit/cuti)">Izin (Sakit / Cuti)</option>
                     <option value="dl">Perjalanan Dinas</option>
                   </select>
                 <?php } ?>
               </div>
               <input id="id_jadwal" hidden value="<?= $jadwal_absen->id_jdwlabnsi ?>">
               <input id="role_id" hidden value="<?= $this->session->userdata('role_id'); ?>">
               <button type="button" class="btn btn-primary" id="btn-kirim" data-dismiss="modal">Kirim</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
   <!-- /.container-fluid -->
   </div>
   <!-- End of Main Content -->