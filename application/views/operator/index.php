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
           </div>
           <div class="card-body">
             <div class="d-sm-flex align-items-center justify-content-between mb-4">
               <p class="font-weight-light font-italic " id="tgl"><?= longdate_indo($tgl); ?> </p>
               <p class="font-weight-light font-italic " id="jam"> </p>
             </div>
             <div class="text-center">
               <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url() ?>assets/images/undraw_posting_photo.svg" alt="">
             </div>
             <p>Sudah isi absenkah anda Hari ini....</p>
             <p id="md" class="shadow-lg text-center"></p>
             <div class="row">
               <div class="col-sm-6 text-center">
                 <a href="#" class="btn btn-primary btn-icon-split btn-sm" id="absensi">
                   <span class="icon text-white-50">
                     <i class="fas fa-info-circle"></i>
                   </span>
                   <span class="text">Absen Masuk</span>
                 </a>
                 </br>
                 <p id="am" class="text-dark font-italic"></p>
               </div>

               <div class="col-sm-6 text-center">
                 <a href="" class="btn btn-primary btn-icon-split btn-sm">
                   <span class="icon text-white-50">
                     <i class="fas fa-info-circle"></i>
                   </span>
                   <span class="text">Absen Pulang</span>
                 </a>
                 </br>
                 <p id="ap" class="text-dark font-italic"></p>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>

   </div>
   <!-- /.container-fluid -->

   </div>
   <!-- End of Main Content -->