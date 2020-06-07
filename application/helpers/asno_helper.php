<?php
// function menu dinamis
function Menu_dinamis()
{
  $ci = get_instance();

  $role_id = $ci->session->userdata('role_id');

  $querymnu = "SELECT menu.menu,call_child,  user_acess_menu.id_menu
             FROM user_acess_menu
             INNER JOIN menu ON menu.id_menu=user_acess_menu.id_menu WHERE user_acess_menu.role_id='$role_id' and menu.is_active=1 order by menu.posisi ASC";

  $menu = $ci->db->query($querymnu)->result_array();

  foreach ($menu as $mn) { ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?= $mn['call_child'] ?>" aria-expanded="true" aria-controls="collapseTwo1">
        <span><?= $mn['menu'] ?></span>
      </a>
      <div id="<?= $mn['call_child'] ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

        <div class="bg-white py-2 collapse-inner rounded">
          <?php
          $query = "SELECT * FROM sub_menu WHERE id_menu='$mn[id_menu]' and sub_menu.is_active_sub='1' ORDER by posisi_sub ASC";
          $sub_menu1 = $ci->db->query($query)->result_array();
          foreach ($sub_menu1 as $sb_mn) { ?>
            <a class="collapse-item" href="<?= base_url() ?><?= $sb_mn['url'] ?>">
              <i class="<?= $sb_mn['icon'] ?>"></i>
              <span><?= $sb_mn['title'] ?></span>
            </a>
          <?php } ?>
          <!-- <?php
                if ($ci->session->userdata('id_jabatan') == 1 && $mn['menu'] == "Disposis Surat") { ?>
                                  <a class="collapse-item" href="<?= base_url() ?>User/list_pengajuan_srt_klr">
                                    <i class="fa fa-envelope"></i>
                                    <span>List Surat Keluar</span>
                                  </a>
                                <?php } elseif ($ci->session->userdata('id_jabatan') == 4 && $mn['menu'] == "Disposis Surat") { ?>
                                  <a class="collapse-item" href="<?= base_url() ?>User/list_pengajuan_srt_klr">
                                    <i class="fa fa-envelope"></i>
                                    <span>List Surat Keluar</span>
                                  </a>
                                  <?php } elseif ($ci->session->userdata('id_jabatan') == 12 && $mn['menu'] == "Disposis Surat") { ?>
                                  <a class="collapse-item" href="<?= base_url() ?>User/list_pengajuan_srt_klr">
                                    <i class="fa fa-envelope"></i>
                                    <span>List Surat Keluar</span>
                                  </a>
                                  <?php } elseif ($ci->session->userdata('id_jabatan') == 13 && $mn['menu'] == "Disposis Surat") { ?>
                                  <a class="collapse-item" href="<?= base_url() ?>User/list_pengajuan_srt_klr">
                                    <i class="fa fa-envelope"></i>
                                    <span>List Surat Keluar</span>
                                  </a>
                                  <?php } elseif ($ci->session->userdata('id_jabatan') == 14 && $mn['menu'] == "Disposis Surat") { ?>
                                  <a class="collapse-item" href="<?= base_url() ?>User/list_pengajuan_srt_klr">
                                    <i class="fa fa-envelope"></i>
                                    <span>List Surat Keluar</span>
                                  </a> -->
          <!-- <?php }

                ?> -->
        </div>
      </div>
    </li>
    <hr class="sidebar-divider">
  <?php }
}

//function cek akses login dan hak acses menu
function is_login()
{
  $ci = get_instance();
  if (!$ci->session->userdata('email')) {
    $ci->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                        Silahkan Login Dulu!!
                                                        </div>');
    redirect('Auth');
  } else {
    $role_id = $ci->session->userdata('role_id');
    $controller = $ci->uri->segment(1);

    if ($controller == 'admin' || $controller == 'Admin') {
      $ctr = 1;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } elseif ($controller == 'operator' || $controller == 'Operator') {
      $ctr = 2;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } elseif ($controller == 'user' || $controller == 'User') {
      $ctr = 3;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } elseif ($controller == 'direktur' || $controller == 'Direktur') {
      $ctr = 4;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } elseif ($controller == 'adum' || $controller == 'Adum') {
      $ctr = 6;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } elseif ($controller == 'wadir' || $controller == 'Wadir') {
      $ctr = 5;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } elseif ($controller == 'admin_kepeg' || $controller == 'Admin_kepeg') {
      $ctr = 7;
      if ($ctr == $role_id) {
      } else {
        redirect('Blank_page');
      }
    } else {
      $get_ctrl = $ci->db->get_where('menu', ['ctrl_menu' => $controller])->row_array();
      $user_acces = $ci->db->get_where('user_acess_menu', [
        'role_id' => $role_id,
        'id_menu' => $get_ctrl['id_menu']
      ]);
      if ($user_acces->num_rows() < 1) {
        redirect('Blank_page');
      }
    }
  }
}

//function cheked hak akses menu user
function cek_akses_user($id_menu, $role_id)
{
  $ci = get_instance();

  $isidata = $ci->db->get_where('user_acess_menu', [
    'role_id' => $role_id,
    'id_menu' => $id_menu
  ]);

  if ($isidata->num_rows() > 0) {
    return "checked";
  }
}

// function menampilkan jabatan user
function jabatanget($id)
{
  $ci = get_instance();
  $query = "SELECT `jabatan`.`id_jabatan`,`nama_jabatan`,`id_peguna`, `unit_kerja`.`unitkerja` FROM `jabatan`,`unit_kerja` WHERE `jabatan`.`nama_jabatan`=`unit_kerja`.`id_unitkerja` AND `jabatan`.`id_peguna`=$id AND jabatan.`status`=1";
  $jbt = $ci->db->query($query)->result();
  if (count($jbt) > 0) {
    foreach ($jbt as $row) {
      $jabatan[] = $row->unitkerja;
    }
    return implode(",<br><br>", $jabatan);
  } else {
    return $jbt[0]->unitkerja;
  }
}

function unitkerja($id)
{
  $ci = get_instance();
  $query = "SELECT `jabatan`.`id_jabatan`,`nama_jabatan`,`id_peguna`, `unit_kerja`.`unitkerja` FROM `jabatan`,`unit_kerja` WHERE `jabatan`.`id_unitkerja`=`unit_kerja`.`id_unitkerja` AND `jabatan`.`id_peguna`=$id AND jabatan.`status`=1";
  $jbt = $ci->db->query($query)->result();
  if (count($jbt) > 0) {
    foreach ($jbt as $row) {
      $jabatan[] = $row->unitkerja;
    }
    return implode(",<br><br>", $jabatan);
  } else {
    return $jbt[0]->unitkerja;
  }
}




// function menampilkan feedback surat
function feedback($id)
{
  $ci = get_instance();
  $fdbk = $ci->db->get_where('feedback_surat', ['id_feedback' => $id])->row();
  return $fdbk->feedback;
}


//function menampilkan surat keluar by admin/op alert
function get_data_srt_keluaradmn_op($role_id)
{ ?>
  <?php $ci = get_instance(); ?>
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bell fa-fw"></i>
      <!-- Counter - Alerts -->
      <?php
      $query =  "SELECT * FROM surat_keluar_diter,surat_keluar WHERE di_teruskan_ke_srt_klr=$role_id and id_feedback_terSrtKlr='1' and surat_keluar_diter.id_surat_keluar=surat_keluar.id_surat_keluar order by tgl_surat_keluar desc";
      $query1 = $ci->db->query($query)->result();
      if ($query1) { ?>
        <span class="badge badge-danger badge-counter">
          <?= count($query1); ?>
        </span>
      <?php } else { ?>

      <?php }
      ?>
    </a>
    <!-- Dropdown - Alerts -->
    <?php
    if ($query1) {
      $kondisi = "";
    } else {
      $kondisi = "hidden";
    }
    if (count($query1) == 0) {
      $hg = "auto";
    } elseif (count($query1) == 1) {
      $hg = "auto";
    } elseif (count($query1) == 2) {
      $hg = "235px";
    } elseif (count($query1) >= 3) {
      $hg = "313px";
    }
    ?>
    <div <?= $kondisi ?> class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in " aria-labelledby="messagesDropdown" style="overflow: auto; height:<?= $hg ?>">
      <h6 class="dropdown-header ">
        Disposisi Surat Keluar
      </h6>
      <?php
      foreach ($query1 as $sk) { ?>

        <?php
        $data_surat = $ci->db->get_where('surat_keluar', ['id_surat_keluar' => $sk->id_surat_keluar])->result();
        foreach ($data_surat as $ds) { ?>
          <a class="dropdown-item d-flex align-items-center ubah_feedback_skopadmn" data-id_terus_srt_klr="<?= $sk->id_terus_srt_keluar ?>" data-id_surat_keluar="<?= $sk->id_surat_keluar ?>" href="<?= base_url() ?>Managemen_Surat/detail_srt_keluar/<?= $sk->id_surat_keluar ?>">
            <div class="dropdown-list-image ">
              <div class="status-indicator bg-success mr-3"></div>
            </div>
            <div class="">
              <div class="text-truncate"><?= $ds->perihal ?></div>
              <div class="small text-gray-500">dari <?= jabatanget($ds->asal_surat) ?> / <?= nice_date($ds->tgl_surat_keluar, 'd-m-Y') ?></div>
            </div>
          </a>
        <?php } ?>
      <?php  } ?>
      <a class="dropdown-item text-center small text-gray-500" href="<?= base_url() ?>Managemen_Surat/srt_keluar">Tampilkan Semua Dispsosi Surat Keluar</a>
    </div>
  </li>
<?php }

//function menampilkan surat keluar alert
function get_data_srt_keluar($id_jabatan)
{ ?>
  <?php $ci = get_instance(); ?>
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bell fa-fw"></i>
      <!-- Counter - Alerts -->
      <?php
      $query =  "SELECT * FROM surat_keluar_diter,surat_keluar WHERE di_teruskan_ke_srt_klr=$id_jabatan and id_feedback_terSrtKlr='1' and surat_keluar_diter.id_surat_keluar=surat_keluar.id_surat_keluar order by tgl_surat_keluar desc";
      $query1 = $ci->db->query($query)->result();
      if ($query1) { ?>
        <span class="badge badge-danger badge-counter">
          <?= count($query1); ?>
        </span>
      <?php } else { ?>

      <?php }
      ?>
    </a>
    <!-- Dropdown - Alerts -->
    <?php
    if ($query1) {
      $kondisi = "";
    } else {
      $kondisi = "hidden";
    }
    if (count($query1) == 0) {
      $hg = "auto";
    } elseif (count($query1) == 1) {
      $hg = "auto";
    } elseif (count($query1) == 2) {
      $hg = "235px";
    } elseif (count($query1) >= 3) {
      $hg = "313px";
    }
    ?>
    <div <?= $kondisi ?> class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in " aria-labelledby="messagesDropdown" style="overflow: auto; height:<?= $hg ?>">
      <h6 class="dropdown-header ">
        Disposisi Surat Keluar
      </h6>
      <?php
      foreach ($query1 as $sk) { ?>

        <?php
        $data_surat = $ci->db->get_where('surat_keluar', ['id_surat_keluar' => $sk->id_surat_keluar])->result();
        foreach ($data_surat as $ds) { ?>
          <a class="dropdown-item d-flex align-items-center ubah_feedback_sk" data-id_terus_srt_klr="<?= $sk->id_terus_srt_keluar ?>" data-id_surat_keluar="<?= $sk->id_surat_keluar ?>" href="<?= base_url() ?>user/lihat_srt_klr/<?= $sk->id_surat_keluar ?>">
            <div class="dropdown-list-image ">
              <div class="status-indicator bg-success mr-3"></div>
            </div>
            <div class="">
              <div class="text-truncate"><?= $ds->perihal ?></div>
              <div class="small text-gray-500">dari <?= jabatanget($ds->asal_surat) ?> / <?= nice_date($ds->tgl_surat_keluar, 'd-m-Y') ?></div>
            </div>
          </a>
          <!-- <a class="dropdown-item d-flex align-items-center ubah_feedback" data-id_terus_srt_msk="<?= $smk->di_teruskan_ke_srt_klr ?>"  href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>">
                                        <div class="dropdown-list-image mr-3">
                                          <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div class="">
                                          <?php
                                          if ($smk->di_kirimkan_oleh == 0) {
                                            $pengirim = "Admin/Operator";
                                          } else {
                                            $pengirim = jabatanget($smk->di_kirimkan_oleh);
                                          }
                                          ?>
                                          <div class="text-truncate"><?= $ds->perihal ?></div>
                                          <div class="small text-gray-500">dari <?= $ds->asal_surat ?> / <?= nice_date($ds->tgl_surat_masuk, 'd-m-Y') ?></div>
                                        </div>
                                      </a> -->
        <?php } ?>
      <?php  } ?>
      <a class="dropdown-item text-center small text-gray-500" href="<?= base_url() ?>User/list_pengajuan_srt_klr">Tampilkan Semua Dispsosi Surat Keluar</a>
    </div>
  </li>
<?php }
// function menampilakn alert surat masuk
function get_data_srt_masuk($id_jabatan)
{ ?>
  <?php $ci = get_instance(); ?>
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-envelope fa-fw"></i>
      <!-- Counter - Alerts -->
      <?php
      $query = $query = "SELECT * FROM surat_masuk_diter,surat_masuk WHERE di_teruskan_ke=$id_jabatan and id_feedback='1' and surat_masuk_diter.id_surat_masuk=surat_masuk.id_surat_masuk order by tgl_surat_masuk desc";
      $query1 = $ci->db->query($query)->result();
      if ($query1) { ?>
        <span class="badge badge-danger badge-counter">
          <?= count($query1); ?>
        </span>
      <?php } else { ?>

      <?php }
      ?>
    </a>
    <!-- Dropdown - Alerts -->
    <?php
    if ($query1) {
      $kondisi = "";
    } else {
      $kondisi = "hidden";
    }
    if (count($query1) == 0) {
      $hg = "auto";
    } elseif (count($query1) == 1) {
      $hg = "auto";
    } elseif (count($query1) == 2) {
      $hg = "235px";
    } elseif (count($query1) >= 3) {
      $hg = "313px";
    }
    ?>
    <div <?= $kondisi ?> class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in " aria-labelledby="messagesDropdown" style="overflow: auto; height:<?= $hg ?>">
      <h6 class="dropdown-header ">
        Disposisi Surat Masuk
      </h6>
      <?php
      foreach ($query1 as $smk) { ?>

        <?php
        $data_surat = $ci->db->get_where('surat_masuk', ['id_surat_masuk' => $smk->id_surat_masuk])->result();
        foreach ($data_surat as $ds) { ?>

          <a class="dropdown-item d-flex align-items-center ubah_feedback" data-id_terus_srt_msk="<?= $smk->id_terus ?>" href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>">
            <div class="dropdown-list-image ">
              <div class="status-indicator bg-success mr-3"></div>
            </div>
            <div class="">
              <?php
              if ($smk->di_kirimkan_oleh == 0) {
                $pengirim = "Admin/Operator";
              } else {
                $pengirim = jabatanget($smk->di_kirimkan_oleh);
              }
              ?>
              <div class="text-truncate"><?= $ds->perihal ?></div>
              <div class="small text-gray-500">dari <?= $ds->asal_surat ?> / <?= nice_date($ds->tgl_surat_masuk, 'd-m-Y') ?></div>
            </div>
          </a>
        <?php } ?>
      <?php  } ?>
      <a class="dropdown-item text-center small text-gray-500" href="<?= base_url() ?>User/list_srt_msk_user">Tampilkan Semua Disposisi Surat Masuk</a>
    </div>
  </li>
<?php }

//  function menampilkan data surat masuk ke dalam tabel per id user
function get_tabel_srt_msk_peruser($id_jabatan)
{ ?>
  <?php $ci = get_instance();
  $query = "SELECT * FROM surat_masuk_diter,surat_masuk WHERE di_teruskan_ke=$id_jabatan and surat_masuk_diter.id_surat_masuk=surat_masuk.id_surat_masuk and surat_masuk_diter.kondisi_surat='' order by tgl_surat_masuk desc";
  $query1 = $ci->db->query($query)->result(); ?>

  <?php
  foreach ($query1 as $smk) { ?>
    <?php
    $data_surat = $ci->db->get_where('surat_masuk', ['id_surat_masuk' => $smk->id_surat_masuk])->result();

    foreach ($data_surat as $sm) {  ?>
      <table class="table" id="myList">
        <thead>
          <tr></tr>
        </thead>
        <tbody>
          <tr>
            <td style="width:90px">
              <?php
              if ($smk->id_feedback == 1) { ?>
                <span class="mr-2">
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Surat Masuk Belum di Lihat!">
                    <i class="fas fa-circle text-success" data-toggle="tooltip" data-placement="right"></i>
                  </a>
                </span>
              <?php } elseif ($smk->id_feedback == 2) { ?>
                <span class="mr-2">
                  <i class="fas fa-circle text-gray-500"></i>
                </span>
              <?php }
              ?>
            </td>
            <td style="width:200px">
              <a href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?= $smk->id_terus ?>">
                <span class="text-gray-500 font-weight-lighter font-italic"><?= nice_date($sm->tgl_surat_masuk, 'd-m-Y') ?> -</span>
                <span class="text-black-50 font-font-weight-bolder text-uppercase"><?= $sm->asal_surat ?></span>
              </a>
            </td>
            <td style="width:400px">
              <a href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?= $smk->id_terus ?>">
                <span class="text-gray-500 text-capitalize "><?= $sm->perihal ?></span>
              </a>
            </td>
            <td style="width:110px">
              <a href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?= $smk->id_terus ?>">
                <span class="text-gray-500 font-weight-lighter font-italic">
                  <?php
                  if ($smk->di_kirimkan_oleh == 0) {
                    echo "(Admin/Operator)";
                  } else {
                    echo "(" . jabatanget($smk->di_kirimkan_oleh) . ")";
                  }
                  ?>
                </span>
              </a>
            </td>
            <td style="width:90px">
              <div class="dropdown">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-fw fa-cog"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item ubah_feedback1" data-id_terus_srt_msk="<?= $smk->id_terus ?>" href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>">Lihat Surat Masuk</a>
                  <?php
                  if ($smk->id_feedback == 1) { ?>
                  <?php } elseif ($smk->id_feedback == 2) { ?>
                    <form action="<?= base_url() ?>user/arsipkan_surat_masuk" method="post">
                      <input type="hidden" name="idterus" value="<?= $smk->id_terus ?>">
                      <button type="submit" class="dropdown-item">Arsipkan Surat Masuk</button>
                    </form>
                    <!-- <a class="dropdown-item" href="<?= base_url() ?>user/arsipkan_surat_masuk/<?= $smk->id_surat_masuk ?>">Arsipkan Surat Masuk</a> -->
                    <a class="dropdown-item" href="<?= base_url() ?>user/status_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $ci->session->userdata('id_jabatan') ?>">Status Surat Masuk Teruskan</a>
                  <?php }
                  ?>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <?php ?>
    <?php  } ?>
  <?php  } ?>
<?php }


//function menampilakn surat masuk yang sudah di arsipkan
function get_tabel_srt_msk_peruser_DIarsipkan($id_jabatan)
{ ?>
  <?php $ci = get_instance();
  $query = "SELECT * FROM surat_masuk_diter,surat_masuk WHERE di_teruskan_ke=$id_jabatan and surat_masuk_diter.id_surat_masuk=surat_masuk.id_surat_masuk and surat_masuk_diter.kondisi_surat='Di Arsipkan' order by tgl_surat_masuk desc";
  $query1 = $ci->db->query($query)->result(); ?>

  <?php
  foreach ($query1 as $smk) { ?>
    <?php
    $data_surat = $ci->db->get_where('surat_masuk', ['id_surat_masuk' => $smk->id_surat_masuk])->result();
    foreach ($data_surat as $sm) {  ?>
      <table class="table  " id="myList">
        <thead>
          <tr></tr>
        </thead>
        <tbody>
          <tr>
            <td style="width:90px">
              <?php
              if ($smk->id_feedback == 1) { ?>
                <span class="mr-2">
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Surat Masuk Belum di Lihat!">
                    <i class="fas fa-circle text-success" data-toggle="tooltip" data-placement="right"></i>
                  </a>
                </span>
              <?php } elseif ($smk->id_feedback == 2) { ?>
                <span class="mr-2">
                  <i class="fas fa-circle text-gray-500"></i>
                </span>
              <?php }
              ?>
            </td>
            <td style="width:200px">
              <a href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?= $smk->id_terus ?>">
                <span class="text-gray-500 font-weight-lighter font-italic"><?= nice_date($sm->tgl_surat_masuk, 'd-m-Y') ?> -</span>
                <span class="text-black-50 font-font-weight-bolder text-uppercase"><?= $sm->asal_surat ?></span>
              </a>
            </td>
            <td style="width:400px">
              <a href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?= $smk->id_terus ?>">
                <span class="text-gray-500 text-capitalize "><?= $sm->perihal ?></span>
              </a>
            </td>
            <td style="width:110px">
              <a href="<?= base_url() ?>user/detail_srt_masuk_user/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>" class="ubah_feedback1 text-decoration-none" data-id_terus_srt_msk="<?= $smk->id_terus ?>">
                <span class="text-gray-500 font-weight-lighter font-italic">
                  <?php
                  if ($smk->di_kirimkan_oleh == 0) {
                    echo "(Admin/Operator)";
                  } else {
                    echo "(" . jabatanget($smk->di_kirimkan_oleh) . ")";
                  }
                  ?>
                </span>
              </a>
            </td>
            <td style="width:90px">
              <div class="dropdown">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-fw fa-cog"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" data-id_terus_srt_msk="<?= $smk->id_terus ?>" href="<?= base_url() ?>user/detail_srt_masuk_userPerArsip/<?= $smk->id_surat_masuk ?>/<?= $smk->id_terus ?>">Lihat Surat Masuk Di Arsipkan</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <?php ?>
    <?php  } ?>
  <?php  } ?>
<?php }
?>