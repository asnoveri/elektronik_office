    <div class="container-fluid">

        <!-- 404 Error Text -->
        <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Page Not Found</p>
        <p class="text-gray-500 mb-0">Sepertinya Halaman yang ingin Anda Akses tidak di Temukan Atau Anda tidak Memiliki Hak Akses</p>
        <?php
            if($this->session->userdata('role_id')== 1){?>
                <a href="<?= base_url()?>admin">&larr; Back to Dashboard</a>
        <?php }elseif($this->session->userdata('role_id')== 2) {?>
                <a href="<?= base_url()?>operator">&larr; Back to Dashboard</a>
        <?php }elseif($this->session->userdata('role_id')== 3){?>
            <a href="<?= base_url()?>user">&larr; Back to Dashboard</a>
        <?php } ?>
        </div>

    </div>  
</div>    