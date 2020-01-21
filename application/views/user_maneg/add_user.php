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
            <?php   if(validation_errors()){?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors();?>
                    </div>
            <?php  } ?>   
            <h5 class="m-0 font-weight-bold text-secondary">Tambah User / Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="row">  
                    <div class="col-sm-6">
                    <form action="<?= base_url()?>User_Managemen/add_user/<?=$id?>" method="POST">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control"  name="fullname" value="<?= set_value('fullname')?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text"  class="form-control"  name="email" value="<?= set_value('email')?>">
                        </div>
                        <div class="form-group">
                            <label for="jbtn">Jabatan</label>
                            <select class="form-control"  name='id_jabatan'>  
                            <option value="">Pilih Jabatan</option>
                            <?php foreach($list_jabatan as $jbt){?>  
                                <option value="<?= $jbt['id_jabatan']?>"><?= $jbt['jabatan']?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pass" value="<?= set_value('pass')?>"> 
                        </div>
                        <div class="form-group">
                            <label>Password Verification</label>
                            <input type="password" class="form-control" name="pass1" value="<?= set_value('pass1')?>"> 
                        </div>
                        <button type="submit" class="btn btn-primary" >Tambah</button>
                        <button type="reset" class="btn btn-danger">Batal</button>
                    </form>
                    </div>             
                </div> 
            </div>
        </div>    
    </div>
</div>


