<?php

use SebastianBergmann\Environment\Console;

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
            $id = $this->session->userdata('id');
            $tgl = date("Y-m-d");
            $id_jdwlabnsi = $this->input->post('id_jdwlabnsi', true);
            $absen_masuk = $this->input->post('absensi_masuk', true);
            $ket_keberadaan = $this->input->post('ket_keberadaan', true);
            $cek_absen = $this->absensi_Mod->cek_absensiMasuk($id_jdwlabnsi, $id, $tgl);
            if ($cek_absen) {
                $pesan = "Anda Sudah Melakukan Pengambilan Absen Masuk";
                $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . $pesan .
                    '</div>');
            } else {
                $data = [
                    'id' => $id,
                    'tanggal' => $tgl,
                    'absensi_masuk' => $absen_masuk,
                    'ket_keberadaan' => $ket_keberadaan,
                    'id_jdwlabnsi' => $id_jdwlabnsi
                ];
                if ($this->absensi_Mod->add_absensi($data) == true) {
                    $pesan = "Berhasil Melakukan Pengambilan Absen Masuk";
                    $this->session->set_flashdata('erorabsen', '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                        . $pesan .
                        '</div>');
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
                    if ($this->absensi_Mod->update_absensi($id_absensi, $data) == true) {
                        $pesan = "Berhasil Melakukan Pengambilan Absen Pulang ";
                        $this->session->set_flashdata('erorabsen', '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                            . $pesan .
                            '</div>');
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
                    }
                } else {
                    $pesan = "Anda Sudah Melakukan Pengambilan Absen Pulang";
                    $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                        . $pesan .
                        '</div>');
                }
            } else {
                $pesan = "Belum Bisa Pengambilan Absen Pulang";
                $this->session->set_flashdata('erorabsen', '<div class="alert alert-primary alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . $pesan .
                    '</div>');
            }
            echo json_encode($pesan);
            die();
        } else {
            $id = $this->session->userdata('id');
            $tgl = date("Y-m-d");
            $judul = 'Dashboard';
            $halaman = 'operator/index';
            $data['jadwal_absen'] = $this->absensi_Mod->get_jadwal_absensi();
            $data['cek_absenKel'] = $this->absensi_Mod->cek_absensikeluar($id, $tgl);
            // print_r($data['cek_absenKel']);
            // die();
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
            $config['max_size']             = 1024;
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
                    'image' => $this->upload->data('file_name'),
                ];

                // print_r($new_images);
                $this->user_Mod->Update_images($new_images, $id);
            }
        }
    }


    public function editpasswd()
    {
        $judul = 'Edit KataSandi';
        $halaman = 'operator/editktasandi';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function do_edit_pass()
    {
        $id = $this->session->userdata('id');
        $this->form_validation->set_rules(
            'pass',
            'Pass',
            'required|trim|min_length[6]|matches[pass1]',
            [
                'required' => 'Kata Sandi Tidak Boleh Kosong',
                'min_length' => 'Kata Sandi Harus Lebih dari 6 Karakter',
                'matches' => 'Kata Sandi yang Di Inputkan Tidak sama'
            ]
        );
        $this->form_validation->set_rules(
            'pass1',
            'Pass1',
            'required|trim|min_length[6]|matches[pass]',
            [
                'required' => 'Ulang Kata Sandi Tidak Boleh Kosong',
                'min_length' => 'Kata Sandi Harus Lebih dari 6 Karakter',
                'matches' => 'Kata Sandi yang Di Inputkan Tidak sama'
            ]
        );
        if ($this->form_validation->run() == FALSE) {
            $this->editpasswd();
        } else {
            $data = [
                'pass'      => password_hash($this->input->post('pass1', true), PASSWORD_DEFAULT),
            ];
            if ($this->user_Mod->edit_userBYid($data, $id)) {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Berhasil edit Kata sandi User  
                        </div>');
                redirect("Operator/editpasswd");
            } else {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Gagal edit Kata Sandi User  
                        </div>');
                redirect("Operator/editpasswd");
            }
        }
    }



    public function getJarakUSer()
    {
        $latitude1       = $this->input->post('latitudeUser', true);
        $longitude1      = $this->input->post('longitudeUser', true);

        $latitude2          = 0.525254;
        $longitude2         = 101.434762;

        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        $jarak_akhri = round($distance, 2);

        if ($jarak_akhri <= 0.2) {
            $this->index("add_absensi", $this->input->post());
        } else {
            $pesan = "Tidak Dapat Melakukan Pengambilan Absen Masuk, Karena Anda Tidak Berada Di wilayah Kantor";
            $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>'
                . $pesan . $jarak_akhri .
                '</div>');
            echo json_encode($pesan);
        }
        die();
    }

    public function getJarakUSerPulang()
    {
        $latitude1       = $this->input->post('latitudeUser', true);
        $longitude1      = $this->input->post('longitudeUser', true);

        $latitude2          = 0.525254;
        $longitude2         = 101.434762;

        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        $jarak_akhri = round($distance, 2);

        if ($jarak_akhri <= 0.2) {
            $this->index("add_absn_plng", $this->input->post());
        } else {
            $pesan = "Tidak Dapat Melakukan Pengambilan Absen Pulang, Karena Anda Tidak Berada Di wilayah Kantor";
            $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>'
                . $pesan . $jarak_akhri .
                '</div>');
            echo json_encode($pesan);
        }
        die();
    }

    public function getJarakUserRengat()
    {
        $latitude1       = $this->input->post('latitudeUser', true);
        $longitude1      = $this->input->post('longitudeUser', true);

        $latitude2          = -0.393169;
        $longitude2         = 102.446646;

        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        $jarak_akhri = round($distance, 2);

        if ($jarak_akhri <= 0.03) {
            $this->index("add_absensi", $this->input->post());
        } else {
            $pesan = "Tidak Dapat Melakukan Pengambilan Absen Masuk, Karena Anda Tidak Berada Di wilayah Kantor";
            $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>'
                . $pesan . $jarak_akhri .
                '</div>');
            echo json_encode($pesan);
        }
        die();
    }


    public function getJarakUSerPulangRengat()
    {
        $latitude1       = $this->input->post('latitudeUser', true);
        $longitude1      = $this->input->post('longitudeUser', true);

        $latitude2          = -0.393169;
        $longitude2         = 102.446646;

        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        $jarak_akhri = round($distance, 2);

        if ($jarak_akhri <= 0.03) {
            $this->index("add_absn_plng", $this->input->post());
        } else {
            $pesan = "Tidak Dapat Melakukan Pengambilan Absen Pulang, Karena Anda Tidak Berada Di wilayah Kantor";
            $this->session->set_flashdata('erorabsen', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>'
                . $pesan . $jarak_akhri .
                '</div>');
            echo json_encode($pesan);
        }
        die();
    }
}
