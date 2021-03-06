<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        $this->load->model('absensi_Mod');
        $this->load->model('login_Mod');
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index($param = "")
    {
        if ($param == "getlist_all_absensi") {
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
                1 => 'fullname',
                2 => 'tanggal',
                3 => 'absensi_masuk',
                4 => 'absensi_keluar',
                5 => 'ket_keberadaan',
            ];

            if (!isset($valid_columns[$col])) {
                $order = null;
            } else {
                $order = $valid_columns[$col];
            }

            $dta = $this->absensi_Mod->get_all_absensi_everyday($length, $start, $order, $dir, $search, $where);
            $json = [];
            $no = $start + 1;
            foreach ($dta as $data) {
                if ($data->ket_keberadaan == 'piket kantor') {
                    $combo = '<div class="form-group "> 
                                <select name="ket" class="custom-select custom-select-sm" id="edt_ketKeb" data-absensi_id=' . $data->id_absensi . '>
                                <option selected value="piket kantor">' . $data->ket_keberadaan . '</option>
                                <option value="piket kantor rengat">Piket Kantor Rengat</option>
                                <option value="wfh">WFH</option>
                                <option value="izin (sakit/cuti)">Izin (sakit/cuti)</option>
                                <option value="dl">Perjalanan Dinas</option>
                                <option value="lembur">Lembur</option>
                                </select>
                            </div>';
                    $combo2 = '';
                } else if ($data->ket_keberadaan == 'piket kantor rengat') {
                    $combo = '<div class="form-group "> 
                                <select name="ket" class="custom-select custom-select-sm" id="edt_ketKeb" data-absensi_id=' . $data->id_absensi . '>
                                <option selected value="piket kantor rengat">' . $data->ket_keberadaan . '</option>
                                <option value="piket kantor">Piket Kantor </option>
                                <option value="wfh">WFH</option>
                                <option value="izin (sakit/cuti)">Izin (sakit/cuti)</option>
                                <option value="dl">Perjalanan Dinas</option>
                                <option value="lembur">Lembur</option>
                                </select>
                            </div>';
                    $combo2 = '';
                } else if ($data->ket_keberadaan == 'wfh') {
                    $combo = '<div class="form-group "> 
                                <select name="ket" class="custom-select custom-select-sm" id="edt_ketKeb" data-absensi_id=' . $data->id_absensi . '>
                                <option selected  value="wfh">' . $data->ket_keberadaan . '</option>
                                <option value="piket kantor">Piket Kantor </option>
                                <option value="piket kantor rengat">Piket Kantor Rengat</option>
                                <option value="izin (sakit/cuti)">Izin (sakit/cuti)</option>
                                <option value="dl">Perjalanan Dinas</option>
                                <option value="lembur">Lembur</option>
                                </select>
                            </div>';
                    $combo2 = '';
                } else if ($data->ket_keberadaan == 'dl') {
                    $combo = '<div class="form-group "> 
                                <select name="ket" class="custom-select custom-select-sm" id="edt_ketKeb" data-absensi_id=' . $data->id_absensi . '>
                                <option selected  value="dl"> Perjalanan Dinas </option>
                                <option value="piket kantor">Piket Kantor </option>
                                <option value="piket kantor rengat">Piket Kantor Rengat</option>
                                <option value="wfh">WFH</option>
                                <option value="izin (sakit/cuti)">Izin (sakit/cuti)</option>
                                <option value="lembur">Lembur</option>
                                </select>
                            </div>';
                    $combo2 = '';
                } else if ($data->ket_keberadaan == 'izin (sakit/cuti)') {
                    $combo = '<div class="form-group "> 
                                <select name="ket" class="custom-select custom-select-sm" id="edt_ketKeb" data-absensi_id=' . $data->id_absensi . '>
                                <option selected  value="izin (sakit/cuti)">' . $data->ket_keberadaan . '</option>
                                <option value="piket kantor">Piket Kantor </option>
                                <option value="piket kantor rengat">Piket Kantor Rengat</option>
                                <option value="wfh">WFH</option>
                                <option value="dl">Perjalanan Dinas</option>
                                <option value="lembur">Lembur</option>
                                </select>
                            </div>';

                    $combo2 = '<div class="form-group "> 
                                <select name="ket2" class="custom-select custom-select-sm" id="edt_ketKeb2" data-absensi_id2=' . $data->id_absensi . '>
                                <option selected  value=' . $data->ket . '>' . $data->ket . '</option>
                                <option value="izin">Izin</option>
                                <option value="cuti">Cuti</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin kusus">Izin Kusus</option>
                                </select>
                            </div>';
                } else if ($data->ket_keberadaan == 'lembur') {
                    $combo = '<div class="form-group "> 
                                <select name="ket" class="custom-select custom-select-sm" id="edt_ketKeb" data-absensi_id=' . $data->id_absensi . '>
                                <option selected  value="lembur">' . $data->ket_keberadaan . '</option>
                                <option value="piket kantor">Piket Kantor </option>
                                <option value="piket kantor rengat">Piket Kantor Rengat</option>
                                <option value="wfh">WFH</option>
                                <option value="izin (sakit/cuti)">Izin (sakit/cuti)</option>
                                <option value="dl">Perjalanan Dinas</option>
                                </select>
                            </div>';
                    $combo2 = '';
                }

                $bad_date = $data->tanggal;
                $longdate_indo = longdate_indo($bad_date);

                $json[] = [
                    $no++,
                    $data->fullname,
                    $longdate_indo,
                    $data->absensi_masuk,
                    $data->absensi_keluar,
                    @$combo,
                    @$combo2,
                ];
            }
            $tot = $this->absensi_Mod->get_all_absensi_everyday_count($where);
            $respon = [
                'draw' => $draw,
                'recordsTotal' => $tot,
                'recordsFiltered' => $tot,
                'data' => $json
            ];
            echo json_encode($respon);
            die();
        } else {
            $judul = 'Absensi';
            $halaman = 'Absensi/index';
            // $data['tgl'] = date("Y-m-d");
            $this->template->TemplateGen($judul, $halaman);
        }
    }

    public function ubah_keteranganKeb()
    {
        $absensi_id = $this->input->post('absensi_id', true);
        $ket_keberadaan = $this->input->post('ket', true);

        $data = [
            'ket_keberadaan' => $ket_keberadaan,
            'ket'   => ''
        ];

        $updateAbsen = $this->absensi_Mod->updateKetAbsen($absensi_id, $data);
        if ($updateAbsen == true) {
            $pesan = $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Merubah Keterangan Keberadaan Absensi Pegawai  
                </div>');
        } else {
            $pesan = $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Merubah Keterangan Keberadaan Absensi Pegawai 
                </div>');
        }
        echo json_encode($this->input->post());
        die();
    }

    public function ubah_keteranganKeb2()
    {
        $absensi_id = $this->input->post('absensi_id2', true);
        $ket_keberadaan = $this->input->post('ket2', true);
        $data = [
            'ket' => $ket_keberadaan,
        ];

        $updateAbsen = $this->absensi_Mod->updateKetAbsen($absensi_id, $data);
        if ($updateAbsen == true) {
            $pesan = $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Merubah Keterangan  Absensi Pegawai  
                </div>');
        } else {
            $pesan = $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Merubah Keterangan  Absensi Pegawai 
                </div>');
        }
        echo json_encode($this->input->post());
        die();
    }


    public function cetak_persensiHarian()
    {
        ob_start();
        $tgl = $this->input->post('tanggal', true);
        $data['tgl'] = longdate_indo($tgl);
        $date = $data['tgl'];

        $data['absensi_harian'] = $this->absensi_Mod->get_absensicetakPertgl($tgl);
        $get_hari = date("l", strtotime($tgl));
        if ($get_hari == "Friday") {
            echo     $id_jadwal = 2;
        } else {
            echo    $id_jadwal = 1;
        }

        $pkt = $this->absensi_Mod->get_keb_pkt($tgl, $id_jadwal);
        $pktrengat = $this->absensi_Mod->get_keb_pkt_rengat($tgl, $id_jadwal);
        $wfh = $this->absensi_Mod->get_keb_wfh($tgl, $id_jadwal);
        $izn = $this->absensi_Mod->get_keb_izn($tgl, $id_jadwal);
        $dl = $this->absensi_Mod->get_keb_dl($tgl, $id_jadwal);

        $data['pkt_tot'] = count($pkt);
        $data['pkt_tot_rgt'] = count($pktrengat);
        $data['wfh_tot'] = count($wfh);
        $data['izn_tot'] = count($izn);
        $data['dl_tot']  = count($dl);

        $this->load->view('Template_laporan/laporan_absensi_harian_pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', false, 'ISO-8859-15', array(20, 10, 20, 5));
        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($html);
        $html2pdf->output("absensi_harian_pegawai'_$date.'.pdf");
    }

    public function cetak_rekapPerpriode()
    {
        // $tahun = "2020";
        // // date('Y'); //Mengambil tahun saat ini
        // $bulan = "01";
        // // date('m'); //Mengambil bulan saat ini
        // $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // for ($i = 1; $i < $tanggal + 1; $i++) {
        //     echo $i . " - " . hari_indo("$i-$bulan-$tahun") . "<br>";
        // }

        // die();
        ob_start();
        $tanggal = $this->input->post('tanggal');
        $tanggal1 = $this->input->post('tanggal1');
        $data['priode1'] = $tanggal;
        $data['priode2'] = $tanggal1;
        $datarange = date_range($tanggal, $tanggal1);
        $data['range'] = count($datarange);

        $sabtu = 0;
        $minggu = 0;
        $tglmerah = 0;
        $bknmerah = 0;

        foreach ($datarange as $dt) {
            $tgl = get_indo_libur($dt);

            if ($tgl == "tanggal merah hari Sabtu") {
                $sabtu++;
            } elseif ($tgl == "tanggal Merah Hari Minggu") {
                $minggu++;
            } elseif ($tgl == "bukan tanggal merah") {
                $bknmerah++;
            } else {
                $tglmerah++;
            }

            // if (nice_date($dt, "l") == 'Saturday') {
            //     echo nice_date($dt, "l") . "<br>";
            //     $sabtu++;
            // }
            // if (nice_date($dt, "l") == 'Sunday') {
            //     echo nice_date($dt, "l") . "<br>";
            //     $minggu++;
            // }
        }


        $user = $this->user_Mod->get_semua_user();

        for ($i = 0; $i < count($user); $i++) {
            $absn = $this->absensi_Mod->get_count_wfhperid($user[$i]->id, $tanggal, $tanggal1);
            $pkt = $this->absensi_Mod->get_count_pktperid($user[$i]->id, $tanggal, $tanggal1);
            $pktrengat = $this->absensi_Mod->get_count_pktrengatperid($user[$i]->id, $tanggal, $tanggal1);
            $izn = $this->absensi_Mod->get_count_iznperid($user[$i]->id, $tanggal, $tanggal1);
            $dl = $this->absensi_Mod->get_count_dlperid($user[$i]->id, $tanggal, $tanggal1);
            $data['user'][] = $user[$i]->fullname;
            $data['nip'][]  = $user[$i]->nip;
            $data['tot_wfh'][] = count($absn);
            $data['tot_pkt'][] = count($pkt);
            $data['tot_pkt_rengat'][] = count($pktrengat);
            $data['tot_izn'][] = count($izn);
            $data['tot_sabtu'] = $sabtu;
            $data['tot_minggu'] = $minggu;
            $data['tot_tglmerah'] = $tglmerah;
            $data['tot_dl'][] = count($dl);
        }
        $data['user'] = $data['user'];
        $data['nip'] = $data['nip'];
        $data['tot_wfh'] = $data['tot_wfh'];
        $data['tot_pkt'] = $data['tot_pkt'];
        $data['tot_pkt_rengat'] = $data['tot_pkt_rengat'];
        $data['tot_izn'] = $data['tot_izn'];
        $data['tot_dl'] = $data['tot_dl'];
        // die();

        $this->load->view('Template_laporan/laporan_absensi_bualanan_pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', false, 'ISO-8859-15', array(20, 10, 20, 5));
        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($html);
        $html2pdf->output("Rekap_absensi_bulanan_pegawai_priode'_$tanggal'_'$tanggal1.'.pdf");
    }


    public function cetak_persensiLembur()
    {
        ob_start();
        $tgl = $this->input->post('tanggal', true);
        $data['tgl'] = longdate_indo($tgl);
        $date = $data['tgl'];

        $data['lembur_absensi'] = $this->absensi_Mod->get_absensicetaklembur($tgl);

        $lembur = $this->absensi_Mod->get_lembur($tgl, 3);

        $data['lembur_tot'] = count($lembur);


        $this->load->view('Template_laporan/laporan_absensi_lembur_pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', false, 'ISO-8859-15', array(19, 10, 20, 5));
        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($html);
        $html2pdf->output("absensi_lembur_pegawai'_$date.'.pdf");
    }

    public function cetakAbsensiBulanan()
    {
        ob_start();
        $tanggal = $this->input->post('tanggal');
        $tanggal1 = $this->input->post('tanggal1');
        $id = $this->input->post('pegawai');
        $pegawai = $this->user_Mod->get_userbyID($id);
        $direktur = $this->user_Mod->get_direktur_one();
        $dirut = $this->user_Mod->get_userbyID($direktur->id);
        $data['direktur'] = $dirut;
        $data['pegawai'] = $pegawai;
        $data['priode1'] = $tanggal;
        $data['priode2'] = $tanggal1;
        $data['range'] = date_range($tanggal, $tanggal1);
        // $data['absensi'] = $this->absensi_Mod->get_cetak_bulanan($id, $tanggal, $tanggal1);

        foreach ($data['range'] as $dt) {
            $as = $this->absensi_Mod->get_cetak_bulanan1($id, $dt);
            $jadwal = $this->absensi_Mod->get_jadwal_absensi_forCetak(@$as->id_jdwlabnsi);
            $data['jdwl_jam_masuk'][] = $jadwal->jam_masuk;
            if ($as->ket_keberadaan == 'izin (sakit/cuti)') {
                if ($as->ket != "") {
                    $data['ket_keberadaan'][] = @$as->ket;
                } else {
                    $data['ket_keberadaan'][] = @$as->ket_keberadaan;
                }
            } else {
                $data['ket_keberadaan'][] = @$as->ket_keberadaan;
            }

            // $data['ket_keberadaan'][] = @$as->ket_keberadaan;
            $data['absensi_masuk'][] = @$as->absensi_masuk;
            $data['absensi_keluar'][] = @$as->absensi_keluar;
        }


        $this->load->view('Template_laporan/cetak_absensi_month_pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $html2pdf = new HTML2PDF('P', 'F4', 'fr', false, 'ISO-8859-15', array(19, 10, 20, 5));
        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($html);
        $html2pdf->output("Laporan_Absensi'_$pegawai->fullname'_$tanggal'_'$tanggal1'.pdf");
    }

    public function addInputAbsen()
    {
        $this->form_validation->set_rules(
            'pegawai',
            'Pegawai',
            'required|trim',
            ['required' => 'Pegawai Belum di Pilih']
        );
        $this->form_validation->set_rules(
            'tanggal',
            'Tanggal',
            'required|trim',
            ['required' => 'Tanggal Belum di Pilih']
        );
        $this->form_validation->set_rules(
            'absensi_masuk',
            'Absensi_masuk',
            'required|trim',
            ['required' => 'Jam Masuk Belum di PIlih']
        );
        $this->form_validation->set_rules(
            'absensi_keluar',
            'Absensi_keluar',
            'required|trim',
            ['required' => 'Jam Keluar Belum di Pilih']
        );
        $this->form_validation->set_rules(
            'ket_keberadaan',
            'Ket_keberadaan',
            'required|trim',
            ['required' => 'Keterangan Keberadaan Belum di Pilih']
        );
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $tanggal = $this->input->post('tanggal');
            $jadwal = $this->absensi_Mod->get_jadwal_absensi2($tanggal);

            if ($jadwal->id_jdwlabnsi == 3) {
                $ket_keberadaan = 'lembur';
            } else {
                $ket_keberadaan = $this->input->post('ket_keberadaan');
            }

            if ($ket_keberadaan == 'izin (sakit/cuti)') {
                $ket = $this->input->post('ket');
            } else {
                $ket = '';
            }


            $pegawai = $this->input->post('pegawai');
            $cek_user = $this->user_Mod->get_user($pegawai);
            $absensi_masuk = $this->input->post('absensi_masuk');
            $absensi_keluar = $this->input->post('absensi_keluar');
            $cek_jadwal = $this->absensi_Mod->cekAbsenManual($pegawai, $tanggal);
            if ($cek_jadwal != '') {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Gagal Menambahkan Absensi, Karena  ' . $cek_user . ' Sudah Melakukan Perekaman Absen Pada Tanggal ' . longdate_indo($tanggal) . '
                </div>');
                redirect("Absensi/index");
            } else {
                $data = [
                    'id' => $pegawai,
                    'tanggal' => $tanggal,
                    'absensi_masuk' => $absensi_masuk,
                    'absensi_keluar' => $absensi_keluar,
                    'ket_keberadaan' => $ket_keberadaan,
                    'ket' => $ket,
                    'id_jdwlabnsi' => $jadwal->id_jdwlabnsi
                ];
                if ($this->absensi_Mod->add_absensi($data) == true) {
                    $this->session->set_flashdata('pesanaddop', '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Melakukan Perekaman Absensi  ' . $cek_user . ' Pada Tanggal ' . longdate_indo($tanggal) . '
                        </div>');
                    redirect("Absensi/index");
                    $log = [
                        'tanggal' => time(),
                        'aksi' => "Absensi",
                        'Keterangan' => "Input Absen Pegawai Manual",
                        'ip' => $this->input->ip_address(),
                        'tipe_login' => $this->session->userdata('role_id'),
                        'id_user' => $this->session->userdata('id'),
                        'status' => 1
                    ];
                    $this->login_Mod->addlog($log);
                }
            }
        }
    }

    public function jdwl_absensi($param = "")
    {
        if ($param == "add") {
            $id_jdwlabnsi = $this->input->post('id_jdwlabnsi', true);
            $jam_masuk = $this->input->post('jam_masuk', true);
            $jam_keluar = $this->input->post('jam_keluar', true);

            $data = [
                [
                    'id_jdwlabnsi'  => $id_jdwlabnsi[0],
                    'jam_masuk'     => $jam_masuk[0],
                    'jam_keluar'    => $jam_keluar[0]
                ],
                [
                    'id_jdwlabnsi'  => $id_jdwlabnsi[1],
                    'jam_masuk'     => $jam_masuk[1],
                    'jam_keluar'    => $jam_keluar[1]
                ]
            ];
            $do_update = $this->absensi_Mod->editJadwa($data);
            if ($do_update == true) {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Berhasil Merubah Jadwal Absensi  
                </div>');
                redirect("Absensi/jdwl_absensi");
            } else {
                $this->session->set_flashdata('pesanaddop', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Gagal Merubah Jadwal Absensi  
                </div>');
                redirect("Absensi/jdwl_absensi");
            }
        }
        $judul = 'Absensi';
        $halaman = 'Absensi/jdwlAbsen';
        $data['jadwal_absensi'] = $this->absensi_Mod->get_all_jdwl_absen_forEdit();
        $this->template->TemplateGen($judul, $halaman, $data);
    }
}
