   <!-- Begin Page Content -->
   <div class="container-fluid">

     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
     </div>

     <!-- Content Row -->
     <div class="row">
       <!-- wfh -->
       <div class="col-xl-3 col-md-6 mb-4">
         <div class="card border-left-primary shadow h-100 py-2">
           <div class="card-body">
             <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                 <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">WFH</div>
                 <div class="h5 mb-0 font-weight-bold text-gray-800" id="wfh"></div>
               </div>
               <div class="col-auto">
                 <i class="fas fa-briefcase fa-2x text-gray-300"></i>
               </div>
             </div>
           </div>
         </div>
       </div>

       <!-- piket Kantor -->
       <div class="col-xl-3 col-md-6 mb-4">
         <div class="card border-left-info shadow h-100 py-2">
           <div class="card-body">
             <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                 <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Piket Kantor</div>
                 <div class="h5 mb-0 font-weight-bold text-gray-800" id="pkt"></div>
               </div>
               <div class="col-auto">
                 <i class="fas fa-briefcase fa-2x text-gray-300"></i>
               </div>
             </div>
           </div>
         </div>
       </div>

       <!-- izin(skit/cuti) -->
       <div class="col-xl-3 col-md-6 mb-4">
         <div class="card border-left-success shadow h-100 py-2">
           <div class="card-body">
             <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                 <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Izin (Sakit/Cuti)</div>
                 <div class="h5 mb-0 font-weight-bold text-gray-800" id="izn"></div>
               </div>
               <div class="col-auto">
                 <i class="fas fa-briefcase fa-2x text-gray-300"></i>
               </div>
             </div>
           </div>
         </div>
       </div>

       <!-- Jumlah Pegawai -->
       <div class="col-xl-3 col-md-6 mb-4">
         <div class="card border-left-danger shadow h-100 py-2">
           <div class="card-body">
             <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                 <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Pegawai</div>
                 <div class="h5 mb-0 font-weight-bold text-gray-800" id="jml_peg"></div>
               </div>
               <div class="col-auto">
                 <i class="fas fa-fad fa-users fa-2x text-gray-300"></i>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>

     <div class="row">
       <!-- Content Column -->
       <div class="col-lg-12 mb-4">

         <!-- Project Card Example -->
         <div class="card shadow mb-4">
           <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary">Data Absensi </h6>
             <p class="font-italic font-weight-light" style="font-size:12px;"><?= longdate_indo($tgl); ?></p>
           </div>
           <div class="card-body">
             <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm "><i class="fas fa-download fa-sm text-white-50"></i> Cetak Absensi</a>
             <div class="table-responsive mt-3">
               <table class="table table-bordered" id="data_absensi" width="100%" cellspacing="0">
                 <thead>
                   <tr>
                     <th>#</th>
                     <th>Nama Pegawai</th>
                     <th>Tanggal</th>
                     <th>Absen Masuk</th>
                     <th>Absen Keluar</th>
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

   <!-- /.container-fluid -->

   </div>
   <!-- End of Main Content -->