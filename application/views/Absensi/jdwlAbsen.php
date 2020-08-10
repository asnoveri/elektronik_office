   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Page Heading -->
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
       </div>
       <?= $this->session->flashdata('pesanaddop'); ?>
       <div class="row">
           <div class="col-xl-7 col-lg-7">
               <div class="card shadow mb-4">
                   <!-- Card Header - Dropdown -->
                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                       <h6 class="m-0 font-weight-bold text-primary text-capitalize">
                           Jadwal Absensi
                       </h6>
                   </div>
                   <!-- Card Body -->
                   <div class="card-body">
                       <div class="table-responsive">
                           <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
                               Edit Jadwal
                           </button>
                           <table class="table table-bordered">
                               <thead>
                                   <tr>
                                       <th>#</th>
                                       <th>Jadwal</th>
                                       <th>Jadwal Absensi Masuk</th>
                                       <th>Jadwal Absensi Pulang</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                    $no = 1;
                                    foreach ($jadwal_absensi as $ja) { ?>
                                       <tr>
                                           <td><?= $no ?></td>
                                           <td>
                                               <?php
                                                if ($ja->tipejadwal == 'sk-normal') {
                                                    echo "Senen - Kamis";
                                                } else if ($ja->tipejadwal == 'jmt-normal') {
                                                    echo "Jum'at";
                                                }
                                                ?>
                                           </td>
                                           <td><?= $ja->jam_masuk ?></td>
                                           <td><?= $ja->jam_keluar ?></td>
                                       </tr>
                                   <?php $no++;
                                    }
                                    ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Absensi</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form action="<?= base_url() ?>Absensi/jdwl_absensi/add" method="POST">
                           <?php
                            foreach ($jadwal_absensi as $jab) { ?>
                               <?php
                                if ($jab->tipejadwal == 'sk-normal') {
                                    echo "Senen - Kamis";
                                } else if ($jab->tipejadwal == 'jmt-normal') {
                                    echo "Jum'at";
                                }
                                ?>
                               <div class=" row">
                                   <input type="text" hidden value="<?= $jab->id_jdwlabnsi ?>" name="id_jdwlabnsi[]">
                                   <div class="col-sm-6">
                                       <div class="input-group mb-3">
                                           <div class="input-group-prepend">
                                               <span class="input-group-text" id="basic-addon1"> Masuk</span>
                                           </div>
                                           <input type="time" class="form-control" name="jam_masuk[]" value="<?= $jab->jam_masuk ?>">
                                       </div>
                                   </div>
                                   <div class="col-sm-6">
                                       <div class="input-group mb-3">
                                           <div class="input-group-prepend">
                                               <span class="input-group-text" id="basic-addon1"> Pulang</span>
                                           </div>
                                           <input type="time" class="form-control" name="jam_keluar[]" value="<?= $jab->jam_keluar ?>">
                                       </div>
                                   </div>
                               </div>
                           <?php }
                            ?>
                           <button type="submit" class="btn btn-primary">Edit</button>
                           <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
   </div>