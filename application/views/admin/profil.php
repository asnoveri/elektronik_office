   <!-- Begin Page Content -->
   <div class="container-fluid">

     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
     </div>

     <!-- Content Row -->
     <div class="row">
       <?= $this->session->flashdata('erorabsen'); ?>
       <a href="#" class="btn btn-primary btn-icon-split btn-sm" id="cek_lokasi">
         <span class="icon text-white-50">
           <i class="fas fa-info-circle"></i>
         </span>
         <span class="text">Cek Lokasi</span>
       </a>
     </div>

   </div>
   <!-- /.container-fluid -->

   </div>
   <!-- End of Main Content -->