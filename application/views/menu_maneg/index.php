<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <?= $this->session->flashdata('pesan');
        if(validation_errors()){?>
            <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?= validation_errors();?>
            </div>
       <?php  } ?>
   
      <div class="alert alert-info">
        <strong>Info!</strong><br> 
                              1.  Seteleh menambahkan menu baru buatlah controller sesuai nama controller yang ada di list Menu <br>
                              2.  dan Tambahkan juga Sub Menu dari Menu yang telah dibuat disini <a href="<?= base_url()?>Menu_Managemen/list_sub_menu"><span class="badge badge-light">Sub_menu</span></a><br>
                              3.  dan atur hak akses dari menu disini <a href="<?= base_url()?>Menu_Managemen/acces_user"><span class="badge badge-success">Role Access</span></a> 
      </div>
      <h5 class="m-0 font-weight-bold text-secondary">List Menu</h5>
    </div>
    <div class="card-body">
    <button type="button" class="btn btn-primary mb-3" id="aad_menu" data-toggle="modal" data-target="#tbhModal">
      Tambah Menu
      </button>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Menu</th>
              <th>Nama Controllers</th>
              <th>Status</th>
              <th>Posisi Menu</th>
              <th width="34.9%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=1;
              foreach ($all_menu as $lst_mn) {?> 
              <tr>
                <td><?= $no?></td>
                <td><?= $lst_mn['menu'] ?></td>
                <td><?= $lst_mn['ctrl_menu']?></td>
                <td><?php 
                    if($lst_mn['is_active']==1){
                      echo "Aktiv";
                    }else{
                      echo "Non Aktiv";
                    }?>
                </td>
                <td><?= $lst_mn['posisi'] ?></td>
                <td class="centerd">
                  <a href="" data-toggle="modal" data-target="#tbhModal" class="btn btn-primary" id="edit_mn" data-id_men="<?=$lst_mn['id_menu'] ?>"> Edit <i class="fa fa-edit"></i></a>
                  <a href="<?= base_url()?>Menu_Managemen/aktiv_mnu/<?= $lst_mn['id_menu']?>" class="btn btn-success"> Aktivkan <i class="fa fa-check"></i></a>
                  <a href="<?= base_url()?>Menu_Managemen/nonaktiv_mnu/<?= $lst_mn['id_menu']?>" class="btn btn-warning"> Non Aktivkan <i class="fa fa-times-circle"></i></a>
                </td>
              </tr> 
            <?php $no++; } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Tambah Menu Modal -->
        <div class="modal" id="tbhModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="label_nm">Tambah Menu</h4>
                <button type="button" class="close" id="yuhu" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form action="<?= base_url()?>Menu_Managemen/addmenu" method="POST">
                    <div class="form-group">
                      <label>Judul Menu</label>
                      <input type="text" class="form-control" id="menu" name="menu">
                    </div>
                    <div class="form-group">
                      <label>Collapsed</label>
                      <input type="text" class="form-control" id="call_child"  name="call_child">
                    </div>
                    <div class="form-group">
                      <label>Posisi Menu</label>
                      <p id="pom"></p>
                      <input type="text" class="form-control" id="posisi_menu"  name="posisi">
                      <input type="hidden" name="id_menu" id="id_menu"> 
                    </div>
                    <button type="submit" class="btn btn-primary" id="tbl_proses">Tambah</button>
                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->


