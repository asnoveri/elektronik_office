    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User/list_srt_msk_user" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List Surat Masuk</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">      
                <h5 class="m-0 font-weight-bold text-secondary">Status Surat Masuk Teruskan</h5>
               " <span class="text-black-50 font-font-weight-bolder text-uppercase"><?=$surat_masuk->asal_surat ?></span> -
                <span class="text-gray-500 font-weight-lighter font-italic"><?= nice_date($surat_masuk->tgl_surat_masuk, 'd-m-Y')?></span> "
            </div>
            <div class="card-body">  
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                            <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Surat Masuk Teruskan</th>
                                        <th>Status</th>
                                        <!-- <th>Feddback</th> -->
                                    </tr>
                            </thead>
                                <tbody>
                                <?php
                                $no=1;
                                    foreach ($surat_masukter as $sm) {?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?= jabatanget($sm->di_teruskan_ke)?></td>
                                                <td>
                                                    <button type="button" class="w-100 btn btn-<?=$sm->bg_porgres?>"><?= feedback($sm->id_feedback)?></button>
                                                </td>
                                                <!-- <td class="text-capitalize">
                                                    <?php 
                                                        if($sm->id_feedback==5){
                                                            echo $sm->di_tindak_lanjuti;
                                                        }else{
                                                        }
                                                    ?>
                                                </td> -->
                                            </tr>
                                            <?php $no++; } ?>
                                </tbody>
                            </table>
                    <!-- <div class="col-sm-5">disinia aka di buat semacam gambar poktekes</div>                -->
                </div> 
            </div>
        </div>    
        <!-- Tambah Menu Modal -->
            <div class="modal" id="tbhjbt">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Jabatan</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url()?>User_Managemen/add_jabatan" method="POST">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control"  name="jabatan">   
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            </form>
                        </div>
                    </div>
            </div>
    </div>
<!-- /.container-fluid -->
    </div>
</div>
<!-- End of Main Content -->


