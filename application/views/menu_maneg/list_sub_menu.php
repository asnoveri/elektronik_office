<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800"><?= $judul?></h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <?= $this->session->flashdata('pesan1');
        if(validation_errors()){?>
            <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?= validation_errors();?>
            </div>
       <?php  } ?>
   
       <div class="alert alert-info">
        <strong><i class="fas fa-info-circle"></i>Info!</strong><br> 
                              1.  Jika Parent Menu Belum ada, belum tampil di combobox atau belum di buat silahkan Tambahkan Menu baru disini <a href="<?= base_url()?>Menu_Managemen"><span class="badge badge-light">menu</span></a> <br>
                              2.  dan atur hak akses dari menu disini <a href="<?= base_url()?>Menu_Managemen/acces_user"><span class="badge badge-success">Role Access</span></a> 
      </div>
      <h5 class="m-0 font-weight-bold text-secondary">List Sub Menu</h5>
    </div>
    <div class="card-body">
    <button type="button" class="btn btn-primary mb-3" id="add_sb_mn" data-toggle="modal" data-target="#tbhsubmenu">
      Tambah Sub Menu
      </button>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Sub Menu</th>
              <th>Parent Menu</th>
              <th>Url Sub Menu</th>
              <th>Status</th>
              <th>Posisi Sub Menu</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=1;
              foreach ($all_sub_menu as $lst_mn) {?> 
              <tr>
                <td><?= $no?></td>
                <td><?= $lst_mn['title'] ?></td>
                <td><?= $lst_mn['menu'] ?></td>
                <td><?= $lst_mn['url'] ?></td>
                <td><?php 
                    if($lst_mn['is_active_sub']==1){
                      echo "Aktiv";
                    }else{
                      echo "Non Aktiv";
                    }?>
                </td>
                <td><?= $lst_mn['posisi_sub'] ?></td>
                <td>
                    <div class="btn-group-vertical">
                        
                        
                        <a href="#" class="btn btn-primary" id="edit_sb_mn" data-toggle="modal" data-target="#tbhsubmenu" data-id_submn="<?= $lst_mn['id_submenu']?>"> Edit <i class="fa fa-edit"></i></a>
                        
                        
                        
                        
                        <a href="<?= base_url()?>Menu_Managemen/aktiv_sub_mnu/<?= $lst_mn['id_submenu']?>" class="btn btn-success"> Aktivkan <i class="fa fa-check"></i></a>
                        <a href="<?= base_url()?>Menu_Managemen/nonaktiv_sub_mnu/<?= $lst_mn['id_submenu']?>" class="btn btn-warning"> Non Aktivkan <i class="fa fa-times-circle"></i></a>
                    </div>
                </td>
              </tr> 
            <?php $no++; } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Tambah Menu Modal -->
        <div class="modal" id="tbhsubmenu">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="lbl_sb_mn">Tambah Sub Menu</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form action="<?= base_url()?>Menu_Managemen/addSubmenu" method="POST">
                    <div class="form-group">
                        <label>Sub Menu</label>
                        <input type="text" class="form-control" id="sub_menu" name="sub_menu">
                    </div>
                    <div class="form-group">
                        <label for="id_menu">Parent Menu</label>
                       <select class="form-control" id="id_menu" name='id_menu'>  
                        <?php foreach($Parent_menu as $p_mnu){?>  
                            <option value="<?= $p_mnu['id_menu']?>"><?= $p_mnu['menu']?></option>
                        <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Url</label>
                        <p id="note"></p>
                        <input type="text" class="form-control" id="url"  name="url">
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" class="form-control" id="icon"  name="icon">
                    </div>
                    <div class="form-group">
                        <label>Posisi Sub Menu</label>
                        <p id="pos1"></p>
                        <p id="pos"></p>
                        <input type="text" class="form-control" id="posisi_sub"  name="posisi_sub">
                        <input type="hidden" id="id_submenu" name="id_submenu">
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn_sb_mn">Tambah</button>
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

