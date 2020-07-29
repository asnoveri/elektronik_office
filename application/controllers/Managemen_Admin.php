<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Managemen_Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_mod');
        is_login();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index($param = "")
    {
        if ($param == 'get_admin') {
            $length = intval($this->input->post('length'));
            $start = intval($this->input->post('start'));
            $draw = intval($this->input->post('draw'));
            $order = $this->input->post('order');
            $search = $this->input->post('search');
            $search = $search['value'];
            $col = 0;
            $dir = "";
            $id = 1;
            if (!empty($order)) {
                foreach ($order as $or) {
                    $dir = $or['dir'];
                }
            }
            if ($dir != 'asc' && $dir != 'desc') {
                $dir = 'desc';
            }
            $data = $this->user_mod->get_allpenguna($length, $start, $dir, $search, $id);
            $json = [];
            $no = 1 + $start;
            foreach ($data as $row) {
                $json[] = [
                    $no++,
                    $row->fullname,
                    $row->user_name,
                    $row->email,
                    '<div class="btn-group-vertical w-100">
                    <a href="' . base_url() . 'Managemen_Admin/hapus_admin/' . $row->id . '/' . $row->id_penguna . '" type="button" class="btn btn-warning" >Delete</a>
                    </div>'
                ];
            }
            $tot1 = $this->user_mod->get_allpengunan_count($id, $search);
            $tot = count($tot1);
            $respon['recordsTotal'] = $tot;
            $respon['recordsFiltered'] = $tot;
            $respon['data'] = $json;
            echo json_encode($respon);
            die();
        }

        $judul = "Kelola Admin";
        $halaman = 'user_maneg/addadmin';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function add_admin()
    {
        $this->form_validation->set_rules(
            'pegawai',
            'Pegawai',
            'required|trim',
            ['required' => 'Pegawai Belum Di Pilih']
        );
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $id = $this->input->post('pegawai', true);
            $cek_user = $this->user_Mod->get_user($id);
            $role_id = 1;
            if ($this->user_mod->get_penguna_BYID($id, $status = 1, $role_id)) {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menambahkan  ' . $cek_user . ' Sebagai Admin Karena ' . $cek_user . ' Sudah Terdaftar Sebagai Admin
                </div>');
                redirect("Managemen_Admin");
            } elseif ($cekpenguna = $this->user_mod->get_penguna_BYID($id, $status = 0, $role_id)) {
                $id_penguna = $cekpenguna->id_penguna;
                $data = [
                    'status' => 1
                ];
                if ($this->user_Mod->ubahstatus($id_penguna, $data)) {
                    $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  ' . $cek_user . ' Sebagai Admin 
                        </div>');
                    redirect("Managemen_Admin");
                }
            } elseif ($this->user_mod->get_penguna_BYID($id, $status = '', $role_id) == false) {
                $data = [
                    'id' => $id,
                    'role_id' => 1,
                    'status' => 1
                ];
                if ($this->user_Mod->Add_Penguna($data)) {
                    $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Menambahkan  ' . $cek_user . ' Sebagai Admin 
                    </div>');
                    redirect("Managemen_Admin");
                }
            }
        }
    }

    public function hapus_admin($iduser, $id_penguna)
    {
        $cek_user = $this->user_Mod->get_user($iduser);
        $data = [
            'status' => 0
        ];
        if ($this->user_Mod->ubahstatus($id_penguna, $data, $id)) {
            $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus ' . $cek_user . ' Sebagai Admin
            </div>');
            redirect("Managemen_Admin");
        } else {
            $this->session->set_flashdata('pesantambah', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus Admin 
                </div>');
            redirect("Managemen_Admin");
        }
    }

    public function admn_kep($param = '')
    {
        if ($param == 'listadmnkepeg') {
            $length = intval($this->input->post('length'));
            $start = intval($this->input->post('start'));
            $draw = intval($this->input->post('draw'));
            $order = $this->input->post('order');
            $search = $this->input->post('search');
            $search = $search['value'];
            $col = 0;
            $dir = "";
            $id = 7;
            if (!empty($order)) {
                foreach ($order as $or) {
                    $dir = $or['dir'];
                }
            }
            if ($dir != 'asc' && $dir != 'desc') {
                $dir = 'desc';
            }

            $data = $this->user_Mod->get_allpenguna($length, $start, $dir, $search, $id);
            $json = [];
            $no = 1 + $start;
            foreach ($data as $row) {
                $json[] = [
                    $no++,
                    $row->fullname,
                    $row->user_name,
                    $row->email,
                    '<div class="btn-group-vertical w-100">
                    <a href="' . base_url() . 'Managemen_Admin/deladmn_kep/' . $row->id . '/' . $row->id_penguna . '" type="button" class="btn btn-warning" >Delete</a>
                    </div>'
                ];
            }
            $tot1 = $this->user_mod->get_allpengunan_count($id, $search);
            $tot = count($tot1);
            $respon['draw'] = $draw;
            $respon['recordsTotal'] = $tot;
            $respon['recordsFiltered'] = $tot;
            $respon['data'] = $json;
            echo json_encode($respon);
            die();
        }

        $judul = "Kelola Admin";
        $halaman = 'user_maneg/list_amn_kep';
        $this->template->TemplateGen($judul, $halaman);
    }

    public function deladmn_kep($iduser, $id_penguna)
    {
        $cek_user = $this->user_Mod->get_user($iduser);
        $cek_wadir = $this->user_Mod->get_wadir($iduser);
        $data = [
            'status' => 0
        ];
        if ($this->user_Mod->ubahstatus($id_penguna, $data)) {
            $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              Berhasil Menghapus ' . $cek_user . ' Sebagai Admin Kepegawaiaan
            </div>');
            redirect("Managemen_Admin/admn_kep");
        } else {
            $this->session->set_flashdata('pesantambah', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Gagal Menghapus ' . $cek_user . ' Sebagai Admin Kepegawaiaan
                </div>');
            redirect("Managemen_Admin/admn_kep");
        }
    }

    public function add_admn_kepeg()
    {
        $this->form_validation->set_rules(
            'pegawai',
            'Pegawai',
            'required|trim',
            ['required' => 'Pegawai Belum Di Pilih']
        );
        if ($this->form_validation->run() == FALSE) {
            $this->admn_kep();
        } else {
            $id = $this->input->post('pegawai', true);
            $cek_user = $this->user_Mod->get_user($id);
            $role_id = 7;
            if ($this->user_mod->get_penguna_BYID($id, $status = 1, $role_id)) {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                       Gagal Menambahkan  ' . $cek_user . ' Sebagai Admin Kepegawaian Karena ' . $cek_user . ' Sudah Terdaftar Sebagai Admin Kepegawaian
                    </div>');
                redirect("Managemen_Admin/admn_kep");
            } elseif ($cekpenguna = $this->user_mod->get_penguna_BYID($id, $status = 0, $role_id)) {
                $id_penguna = $cekpenguna->id_penguna;
                $data = [
                    'status' => 1
                ];
                if ($this->user_Mod->ubahstatus($id_penguna, $data)) {
                    $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil Menambahkan  ' . $cek_user . ' Sebagai Admin Kepegawaiaan
                            </div>');
                    redirect("Managemen_Admin/admn_kep");
                }
            } elseif ($this->user_mod->get_penguna_BYID($id, $status = '', $role_id) == false) {
                $data = [
                    'id' => $id,
                    'role_id' => 7,
                    'status' => 1
                ];
                if ($this->user_Mod->Add_Penguna($data)) {
                    $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Berhasil Menambahkan  ' . $cek_user . ' Sebagai Admin Kepegawaiaan
                        </div>');
                    redirect("Managemen_Admin/admn_kep");
                }
            }
        }
    }
}
