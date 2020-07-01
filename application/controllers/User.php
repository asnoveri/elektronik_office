<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("login_Mod");
        $this->load->model("absensi_Mod");
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
            echo json_encode($pesan);
            die();
        } else {
            $judul = 'Dashboard';
            $halaman = 'user/index';
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


    public function profil_user()
    {
        $judul = 'Profil user';
        $halaman = 'user/profil_user';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function list_srt_msk_user()
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/surat_masuk';
        $data = '';
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function detail_srt_masuk_user($id, $idterus = "")
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/detail_srt_masuk_user';
        $data['detail_srt_masuk'] = $this->Surat_Mod->get_srtMSkBYID($id);
        $data['detail_srt_masuk_ter'] = $this->Surat_Mod->get_srtMSkBYID_terSingle($id, $idterus);
        $data['jabatan'] = $this->user_Mod->get_all_jabatan();
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function ubh_feedback_srtmsk_user()
    {
        $id = $this->input->post('id_terus', true);
        $data = [
            'id_feedback' => 2,
            'bg_porgres' => 'success'
        ];
        if ($this->Surat_Mod->edit_feedback_srtMSK($data, $id)) {
        }
    }

    public function add_suratmasuk_diteruskan($id, $idterus = "")
    {
        $this->form_validation->set_rules('instruksi', 'Instruksi', 'trim|max_length[200]
        ', ['max_length' => 'Instruksi Maksimal 200 Karakter tidak boleh lebih']);
        $this->form_validation->set_rules(
            'di_teruskan_ke',
            'Di_teruskan_ke',
            'required',
            ['required' => 'Teruskan Disposisi Surat Masuk Tidak Boleh Kosong']
        );

        if ($this->form_validation->run() == FALSE) {
            $this->detail_srt_masuk_user($id, $idterus);
        } else {
            $jbtn = $this->user_Mod->get_jbtnBYid($this->input->post('di_teruskan_ke', true));
            $data1 = [
                'id_surat_masuk' => $this->input->post('id_surat_masuk', true),
                'di_teruskan_ke' => $this->input->post('di_teruskan_ke', true),
                'di_kirimkan_oleh' => $this->session->userdata('id_jabatan'),
                'id_feedback' => '1',
                'bg_porgres' => 'primary',
                'instruksi' => $this->input->post('instruksi', true)
            ];
            $this->Surat_Mod->add_srt_msuk_diter($data1);
            $this->session->set_flashdata('pesan_surat1', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Berhasil Meneruskan Surat ke ' . $jbtn->jabatan . '
                </div>');
            redirect('User/list_srt_msk_user');
        }
    }

    public function status_srt_masuk_user($id_surat_masuk, $di_kirimkan_oleh)
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/status_surat_masuk';
        $data['surat_masukter'] = $this->Surat_Mod->get_srtMskditerByIdKirim($id_surat_masuk, $di_kirimkan_oleh);
        $data['surat_masuk'] = $this->Surat_Mod->get_srtMSkBYID($id_surat_masuk);
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function arsip_srt_masuk()
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/arsip_surat_masuk';
        $data = '';
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function detail_srt_masuk_userPerArsip($id, $idterus = "")
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/detail_srt_masuk_userPerArsip';
        $data['detail_srt_masuk'] = $this->Surat_Mod->get_srtMSkBYID($id);
        $data['detail_srt_masuk_ter'] = $this->Surat_Mod->get_srtMSkBYID_terSingle($id, $idterus);
        $data['jabatan'] = $this->user_Mod->get_all_jabatan();
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function arsipkan_surat_masuk()
    {
        $idterus = $this->input->post('idterus');
        $data = [
            'kondisi_surat' => 'Di Arsipkan'
        ];
        if ($this->Surat_Mod->edit_kondisiSrtMSK($idterus, $data) == true) {
            $this->session->set_flashdata('pesan_surat1', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Berhasil MengArsipkan Surat Masuk
                </div>');
            redirect('User/list_srt_msk_user');
        } else {
            $this->session->set_flashdata('pesan_surat1', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Gagal MengArsipkan Surat Masuk
                </div>');
            redirect('User/list_srt_msk_user');
        }
    }

    public function surat_keluar()
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/surat_keluar';
        $data['jabatan'] = $this->user_Mod->get_all_jabatan();
        $data['adum'] = $this->user_Mod->get_jbtnBYid(14);
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function add_surat_keluar()
    {
        $this->form_validation->set_rules('tgl_surat_keluar', 'Tgl_surat_keluar', 'required|trim', [
            'required' => 'Tanggal Surat Harus di pilih',
        ]);
        $this->form_validation->set_rules('no_surat_keluar', 'No_surat_keluar', 'required|trim', [
            'required' => 'No Surat Masuk Tidak Boleh Kosong',
        ]);
        $this->form_validation->set_rules('perihal', 'perihal', 'required|trim', [
            'required' => 'Perihal Tidak Boleh Kosong',
        ]);
        $this->form_validation->set_rules('sifat_surat', 'Sifat_surat', 'required|trim', [
            'required' => 'Sifat surat Harus di pilih',
        ]);

        if ($this->form_validation->run() == false) {
            $this->surat_keluar();
        } else {
            $upload_file_srt = $_FILES["file_surat"]["name"];
            if ($upload_file_srt) {
                $config['upload_path']          = "./assets/upload_file_surat/";
                $config['allowed_types']        = 'pdf|jpg';
                $config['max_size']             = 4096;
                $config['remove_spaces']        = true;
                //memangil libraires upload dan masukan configurasinya
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file_surat')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('pesan_surat_keluar', '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>'
                        . $error .
                        '</div>');
                    redirect('user/surat_keluar');
                } else {
                    $file = $this->upload->data('file_name');
                }
            } else {
                $this->session->set_flashdata('pesan_surat_keluar', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    File yang di Upload belum di pilih, Silahkan pilih dulu filenya
                </div>');
                redirect('user/surat_keluar');
            }
            $data = [
                'tgl_surat_keluar' => $this->input->post('tgl_surat_keluar', true),
                'no_surat_keluar' => $this->input->post('no_surat_keluar', true),
                'sifat_surat' => $this->input->post('sifat_surat', true),
                'asal_surat' => $this->session->userdata('id_jabatan'),
                'perihal' => $this->input->post('perihal', true),
                'id_feedback' => 8,
                'bg_porgres' => 'info',
                'file_surat' => $file
            ];

            if ($id_srt_keluar = $this->Surat_Mod->upload_SRT_keluar($data)) {
                $data1 = [
                    'id_surat_keluar' => $id_srt_keluar->id_surat_keluar,
                    'di_teruskan_ke_srt_klr' => 0,
                    'id_feedback_terSrtKlr' => '1',
                    'bg_porgres_srt_keluar' => 'primary'
                ];
                $this->Surat_Mod->add_srt_keluar_diter($data1);

                $this->session->set_flashdata('pesan_surat_keluar', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   Berhasil Mengajukan Disposisi Surat Keluar
                </div>');
                redirect('user/list_dftr_srt_keluarPerUser');
            } else {
                $this->session->set_flashdata('pesan_surat_keluar', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   gagal  Mengajukan Disposisi Surat Keluar
                </div>');
                redirect('user/list_dftr_srt_keluarPerUser');
            }
        }
    }

    public function list_dftr_srt_keluarPeruser()
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/list_dftr_srt_keluarPerUser';
        $data['srt_keluar'] = $this->Surat_Mod->get_all_srtkeluarPeruser($this->session->userdata('id_jabatan'));
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function lihatFile_suratKlr($id_surat_keluar)
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/Lihat_file_suratKLR';
        $data['srt_keluarbyId'] = $this->Surat_Mod->get_surat_keluarByid($id_surat_keluar);
        $data['pjbtn_mndt'] = $this->user_Mod->get_user_BYIDjabtan($data['srt_keluarbyId']->yang_mendisposisi);
        $this->template->TemplateGen($judul, $halaman, $data);
    }
    public function ubh_feedback_srtklr_user()
    {
        $id = $this->input->post('id_terus_srt_keluar', true);
        $data = [
            'id_feedback_terSrtKlr' => 2,
            'bg_porgres_srt_keluar' => 'success'
        ];
        $this->Surat_Mod->edit_feedback_srtkelter($data, $id);
        $id1 = $this->input->post('id_surat_keluar', true);
        $data1 = [
            'id_feedback' => 2,
            'bg_porgres' => 'success'
        ];
        $this->Surat_Mod->edit_feedback_srtkel($data1, $id1);
    }
    public function ubh_feedback_srtklr_useradmop()
    {
        $id = $this->input->post('id_terus_srt_keluar', true);
        $data = [
            'id_feedback_terSrtKlr' => 2,
            'bg_porgres_srt_keluar' => 'success'
        ];
        $this->Surat_Mod->edit_feedback_srtkelter($data, $id);
    }

    public function list_pengajuan_srt_klr()
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/list_pengajuan_srt_klr';
        $data['surat_keluarter'] = $this->Surat_Mod->get_surat_keluarterBY($this->session->userdata('id_jabatan'));
        foreach ($data['surat_keluarter'] as $skt) {
            $ambil_isi[] = $this->Surat_Mod->get_surat_keluarByid($skt->id_surat_keluar);
            $fdbk[] = $skt->id_feedback_terSrtKlr;
            $id_trsk[] = $skt->id_terus_srt_keluar;
        }
        $data['data_srtklr'] = $ambil_isi;
        $data['fedbk'] = $fdbk;
        $data['id_trsk'] = $id_trsk;
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function lihat_srt_klr($id_surat_keluar)
    {
        $judul = 'Disposisi Surat';
        $halaman = 'user/lihat_srt_klr';
        $data['srt_keluarbyId'] = $this->Surat_Mod->get_surat_keluarByid($id_surat_keluar);
        // $data['pjbtn_mndt']=$this->user_Mod->get_user_BYIDjabtan($data['srt_keluarbyId']->yang_mendisposisi);
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function add_feedback_srtkeluar()
    {
        $id1 = $this->input->post('id_surat_keluar', true);
        $data1 = [
            'id_feedback1' => $this->input->post('id_feedback1', true),
            'yang_mendisposisi' => $this->session->userdata('id_jabatan')
        ];
        $this->Surat_Mod->edit_feedback_srtkel($data1, $id1);
        redirect('user/list_pengajuan_srt_klr');
    }
}
