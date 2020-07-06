    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $judul ?></h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?= $this->session->flashdata('pesanaddop') ?>
                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= validation_errors(); ?>
                    </div>
                <?php  } ?>
                <h5 class="m-0 font-weight-bold text-secondary"><?= $judul ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <form action="<?= base_url() ?>Operator/do_edit_pass" method="POST">
                            <div class="form-group">
                                <label>Kata Sandi</label>
                                <input type="password" class="form-control" id="pass" name="pass">
                            </div>
                            <div class="form-group">
                                <label>Ulang Kata Sandi</label>
                                <input type="password" class="form-control" id="pass1" name="pass1">
                            </div>
                            <button type="submit" class="btn btn-primary">Edit</button>
                            <button type="reset" class="btn btn-danger">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>