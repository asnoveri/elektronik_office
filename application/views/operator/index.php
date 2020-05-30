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
             <?= $this->session->flashdata('pesanaddop'); ?>
           </div>
           <div class="card-body">
             <div class="text-center">
               <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url() ?>assets/images/undraw_posting_photo.svg" alt="">
             </div>
             <p>Sudah isi absenkah anda Hari ini....</p>
             <p id="md" class="shadow-lg text-center"></p>
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
               </div>

               <div class="col-sm-6 text-center mt-2">
                 <p><span class="badge badge-secondary"><?= $jadwal_absen->jam_masuk; ?></span></p>
               </div>
               <div class="col-sm-6 text-center mt-2">
                 <p><span class="badge badge-secondary"><?= $jadwal_absen->jam_keluar; ?></span></p>
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
                 <select name="ket_keberadaan" class="custom-select" id="sel-keberadaan">
                   <option value="piket kantor">Piket Kantor</option>
                   <option value="wfh">WFH</option>
                   <option value="izin (sakit/cuti)">Izin (Sakit / Cuti)</option>
                 </select>
               </div>
               <input id="id_jadwal" hidden value="<?= $jadwal_absen->id_jdwlabnsi ?>">
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