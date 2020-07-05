<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("absensi_Mod");
        $this->load->model("login_Mod");
        $this->load->model('user_Mod');
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index($param = "")
    {
        if ($param == 'add_absensi') {
            $id_jdwlabnsi = $this->input->post('id_jdwlabnsi', true);
            $id = $this->session->userdata('id');
            $tgl = date("Y-m-d");
            $absen_masuk = $this->input->post('absensi_masuk', true);
            $ket_keberadaan = $this->input->post('ket_keberadaan', true);
            $cek_absen = $this->absensi_Mod->cek_absensiMasuk($id_jdwlabnsi, $id, $tgl);
            if ($cek_absen) {
                $pesan = "Anda Sudah Mengambil Absen Masuk";
            } else {
                $data = [
                    'id' => $id,
                    'tanggal' => $tgl,
                    'absensi_masuk' => $absen_masuk,
                    'ket_keberadaan' => $ket_keberadaan,
                    'id_jdwlabnsi' => $id_jdwlabnsi
                ];
                if ($this->absensi_Mod->add_absensi($data)) {
                    $pesan = "Absen Masuk Anda Sudah Terkirim";
                }
                $log = [
                    'tanggal' => time(),
                    'aksi' => "Absensi",
                    'Keterangan' => "Ambil Absen Masuk",
                    'ip' => $this->input->ip_address(),
                    'tipe_login' => $this->session->userdata('role_id'),
                    'id_user' => $this->session->userdata('id'),
                    'status' => 1
                ];
                $this->login_Mod->addlog($log);
            }
            echo json_encode($pesan);
            die();
        } elseif ($param == 'add_absn_plng') {
            $id = $this->session->userdata('id');
            $tgl = date("Y-m-d");
            $absen_keluar = $this->input->post('absen_keluar', true);
            $cek_absenKel = $this->absensi_Mod->cek_absensikeluar($id, $tgl);
            $jadwl_absen = $this->absensi_Mod->get_jadwal_absensi();

            $jamkel1 = new DateTime($jadwl_absen->jam_keluar);
            $jamkel2 = new DateTime($absen_keluar);
            if ($jamkel2 >= $jamkel1) {
                if ($cek_absenKel->absensi_keluar == "00:00:00") {
                    $id_absensi = $cek_absenKel->id_absensi;
                    $data = [
                        'absensi_keluar' => $absen_keluar
                    ];
                    if ($this->absensi_Mod->update_absensi($id_absensi, $data)) {
                        $pesan = "Absen Pulang Anda Sudah Terkirim ";
                    }
                    $log = [
                        'tanggal' => time(),
                        'aksi' => "Absensi",
                        'Keterangan' => "Ambil Absen Pulang",
                        'ip' => $this->input->ip_address(),
                        'tipe_login' => $this->session->userdata('role_id'),
                        'id_user' => $this->session->userdata('id'),
                        'status' => 1
                    ];
                    $this->login_Mod->addlog($log);
                } else {
                    $pesan = "Anda Sudah Mengambil Absen Pulang";
                }
            } else {
                $pesan = "Belum Bisa Mengambil Absen Pulang";
            }
            echo json_encode($pesan);
            die();
        } else {
            $judul = 'Dashboard';
            $halaman = 'operator/index';
            $data['jadwal_absen'] = $this->absensi_Mod->get_jadwal_absensi();
            $this->template->TemplateGen($judul, $halaman, $data);
        }
    }

    public function getAbsensiUser_id()
    {
        $length = intval($this->input->post('length'));
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $order = $this->input->post('order');
        $search = $this->input->post('search');
        $search = $search['value'];
        $searchByFromdate = $this->input->post('searchByFromdate');
        $col = 0;
        $dir = "";
        $where = "";

        if ($searchByFromdate != '') {
            $where = $searchByFromdate;
        }

        if (!empty($order)) {
            foreach ($order as $or) {
                $col = $or['column'];
                $dir = $or['dir'];
            }
        }

        if ($dir != 'asc' && $dir != 'desc') {
            $dir = 'desc';
        }

        $valid_columns = [
            1 => 'tanggal',
            2 => 'absensi_masuk',
            3 => 'absensi_keluar',
            4 => 'ket_keberadaan'
        ];

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $id_user = $this->session->userdata('id');
        $dta = $this->absensi_Mod->get_all_absensi_userid($length, $start, $order, $dir, $search, $where, $id_user);
        $json = [];
        $no = $start + 1;
        foreach ($dta as $data) {
            $bad_date = $data->tanggal;
            $tgl = nice_date($bad_date, 'd-m-Y');
            $json[] = [
                $no++,
                $tgl,
                $data->absensi_masuk,
                $data->absensi_keluar,
                $data->ket_keberadaan,
            ];
        }
        $tot = $this->absensi_Mod->get_all_absensi_userid_count($where, $id_user);
        $respon = [
            'draw' => $draw,
            'recordsTotal' => $tot,
            'recordsFiltered' => $tot,
            'data' => $json
        ];
        echo json_encode($respon);
        die();
    }


    public function profil_op()
    {
        $judul = 'Profil ';
        $halaman = 'operator/profil_operator';
        $data['user'] = $this->user_Mod->get_userEdit($this->session->userdata('id'));
        $peguna = $this->user_Mod->get_penguna_user($this->session->userdata('id'));
        foreach ($peguna as $pgn) {
            // echo $pgn->id_penguna . "<br>";
            $jabatan = $this->user_Mod->get_jabatan_user($pgn->id_penguna);
            for ($i = 0; $i < count($jabatan); $i++) {
                // echo $jabatan[$i]->id_unitkerja . "<br>";
                $jabatankerja[] = $this->user_Mod->get_unitkerja_user($jabatan[$i]->nama_jabatan);
            }
        }
        $data['jabatankerja'] = $jabatankerja;
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function do_edit_uploadimage()
    {
        $id = $this->input->post('id', true);
        $data = $this->user_Mod->get_userEdit($id);

        //mencek jika ada gambar yang akan di upload
        $upload_image = $_FILES["gambar"]["name"];
        if ($upload_image) {
            $config['upload_path']          = "./assets/images/";
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048;
            $config['remove_spaces']        = true;

            //memangil libraires upload dan masukan configurasinya
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('erorogbr', '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . $error .
                    '</div>');
            } else {
                $old_images = $data->image;
                //mencek images lama yang tersimpan di drektory sistem tidak sama dengan  default.jpg
                if ($old_images != 'default.png') {
                    //   jika tidak sama hapus image selain default.jpg
                    unlink(FCPATH . '/assets/images/' . $old_images);
                }
                $new_images = [
                    // $this->upload->data('file_name')->untuk mengmbil nama dari file yang di upload
                    'image' => $this->upload->data('file_name')
                ];
                $this->user_Mod->Update_images($new_images, $id);
            }
        }
    }
}
