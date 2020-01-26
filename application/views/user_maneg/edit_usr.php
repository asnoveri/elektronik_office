    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
        <a href="<?= base_url()?>User_Managemen/list_all_user/<?=$id?>" class="btn btn-success btn-icon-split"><span class="icon text-white"> <i class="fas fa-arrow-left"></i></span><span class="text">List User / Pegawai</span></a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">   
            <?= $this->session->flashdata('pesanaddop')?>
            <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>   
            <h5 class="m-0 font-weight-bold text-secondary">Edit User / Pegawai</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url()?>User_Managemen/do_edit_user/<?=$iduser?>/<?=$id?>" method="POST"  enctype='multipart/form-data' id="form_upload_foto">
                    <div class="row">  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control"  name="fullname" value="<?= $pegawai->fullname?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text"  class="form-control"  name="email" value="<?= $pegawai->email?>">
                            </div>
                            <div class="form-group">
                                <label for="jbtn">Jabatan</label>
                                <select class="form-control"  name='id_jabatan'>  
                                <option value="<?= $pegawai->id_jabatan?>"><?= jabatanget($pegawai->id_jabatan);?></option>
                                <?php foreach($list_jabatan as $jbt){?>  
                                    <option value="<?= $jbt['id_jabatan']?>"><?= $jbt['jabatan']?></option>
                                <?php }?>
                                </select>
                            </div>
                            <br>
                            <br>
                            <br>
                            <input type="hidden" value="<?= $pegawai->id?>" name="idgambar" id="idgambar">
                            <input type="hidden" value="<?= $id?>" name="role_id" id="role_id">
                            <button type="submit" class="btn btn-primary" >Edit User / Pegawai</button>
                            <button type="reset" class="btn btn-danger">Batal</button>
                        </div>    
                        <div class="col-sm-6">
                            <?= $this->session->flashdata('erorogbr') ?>
                            <div class="card" style="width:250px;">
                                    <img class="card-img-top img-thumbnail" src="<?= base_url()?>assets/images/<?= $pegawai->image?>" alt="Card image">
                                    <div class="card-body">
                                    <label class="card-text">Ubah Foto Profil</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="gambar">
                                            <label class="custom-file-label" for="customFile">Pilih file</label>
                                        </div>
                                    </div>
                            </div>
                        </div>             
                    </div> 
                </form>
            </div>
        </div>    
    </div>
</div>


