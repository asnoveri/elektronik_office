  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
          <img class="img-profile rounded-circle" width="50" height="45" src="<?= base_url() ?>assets/images/pkr.png">
        </div>
        <div class="sidebar-brand-text mx-3">Elektronik Office
        </div>
      </a>
      <hr class="sidebar-divider">
      <!-- untuk menampilkan dashboard sesuai role id -->
      <?php
      if ($this->session->userdata('role_id') == 1) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>Admin">
            <span>Dashboard</span></a>
        </li>
      <?php } elseif ($this->session->userdata('role_id') == 2) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>Operator">
            <span>Dashboard</span></a>
        </li>
      <?php } elseif ($this->session->userdata('role_id') == 3) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>User">
            <span>Dashboard</span></a>
        </li>
      <?php } elseif ($this->session->userdata('role_id') == 4) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>Direktur">
            <span>Dashboard</span></a>
        </li>
      <?php } elseif ($this->session->userdata('role_id') == 5) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>Wadir">
            <span>Dashboard</span></a>
        </li>
      <?php } elseif ($this->session->userdata('role_id') == 6) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>Adum">
            <span>Dashboard</span></a>
        </li>
      <?php } elseif ($this->session->userdata('role_id') == 7) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>Admin_kepeg">
            <span>Dashboard</span></a>
        </li>
      <?php } ?>
      <hr class="sidebar-divider">
      <!-- menampilkan menu dinamis dari asno_helper -->

      <?= Menu_dinamis() ?>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->