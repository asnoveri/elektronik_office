<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_Mod');
        $this->load->helper('date');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index($data1 = "")
    {

        $this->load->library('calendar');
        if (!empty($this->session->userdata('role_id'))) {
            if ($this->session->userdata('role_id') == 1) {
                redirect("admin");
            } elseif ($this->session->userdata('role_id') == 2) {
                redirect("Operator");
            } elseif ($this->session->userdata('role_id') == 3) {
                redirect("User");
            } elseif ($this->session->userdata('role_id') == 4) {
                redirect("Direktur");
            } elseif ($this->session->userdata('role_id') == 5) {
                redirect("Wadir");
            } elseif ($this->session->userdata('role_id') == 6) {
                redirect("Adum");
            } elseif ($this->session->userdata('role_id') == 7) {
                redirect("Admin_kepeg");
            }
        }

        $data['judul'] = 'Elektronik Office -Login';
        $this->load->view('auth_templates/header', $data);
        $this->load->view('auth/index', $data1);
        $this->load->view('auth_templates/footer');
    }

    public function login()
    {
        // $this->form_validation->set_rules('email','Email','required|valid_email|trim');
        $this->form_validation->set_rules(
            'user_name',
            'User_name',
            'required|trim|min_length[3]|alpha_dash',
            ['alpha_dash' => 'User Name Tidak Mengizinkan Spasi Pada Karakter Yang di Masukkan']
        );
        $this->form_validation->set_rules('pass', 'Pass', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            // $data=$this->input->post('email',true);
            $data = $this->input->post('user_name', false);
            $pass = $this->input->post('pass', true);
            $datalogin = $this->login_Mod->get_User($data);
            if ($datalogin) {
                if ($datalogin['is_active'] == 1) {
                    $penguna = $this->login_Mod->get_penguna($datalogin['id']);
                    if (count($penguna) > 1) {
                        if (password_verify($pass, $datalogin['pass'])) {
                            $data = [
                                'email'     => $datalogin['email'],
                                'id'        => $datalogin['id']
                            ];
                            $this->session->set_userdata($data);
                            $this->pilih_Role();
                        } else {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Password Yang Anda Masukan Salah!!
                            </div>');
                            redirect('Auth');
                        }
                    } elseif (count($penguna) == 1) {
                        $role = $this->login_Mod->get_role($datalogin['id']);
                        // if($role->status==1){
                        $data = [
                            'email'     => $datalogin['email'],
                            'role_id'   => $role->role_id,
                            'id'        => $datalogin['id']
                            // 'id_jabatan'=> $datalogin['id_jabatan']
                        ];
                        $this->session->set_userdata($data);
                        if (password_verify($pass, $datalogin['pass'])) {
                            if ($role->role_id == 1) {
                                $redirect = 'Admin';
                            } elseif ($role->role_id == 2) {
                                $redirect = 'Operator';
                            } elseif ($role->role_id == 3) {
                                $redirect = 'User';
                            } elseif ($role->role_id == 4) {
                                $redirect = 'Direktur';
                            } elseif ($role->role_id == 5) {
                                $redirect = 'Wadir';
                            } elseif ($role->role_id == 6) {
                                $redirect = 'Adum';
                            } elseif ($role->role_id == 7) {
                                $redirect = 'Admin_kepeg';
                            }
                            $data = [
                                // 'tanggal'=>date("Y-m-d G:i:s"),
                                'tanggal' => time(),
                                'aksi' => "Login",
                                'Keterangan' => 'Login Sistem',
                                'ip' => $this->input->ip_address(),
                                'tipe_login' => $this->session->userdata('role_id'),
                                'id_user' => $this->session->userdata('id'),
                                'status' => 1
                            ];
                            $this->login_Mod->addlog($data);
                            redirect($redirect);
                        } else {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Password Yang Anda Masukan Salah!!
                                </div>');
                            redirect('Auth');
                        }
                    } else {
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Account Anda Belum Memiliki Hak Akses !!
                            </div>');
                        redirect('Auth');
                    }
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Account Anda Belum Aktif Silahkan Hubungi Admin Sistem Untuk Menaktifkan Account Anda!!
                    </div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Account Anda Belum Terdaftar Silahkan Hubungi Admin Sistem Untuk Mendaftarkan Account Anda!!
                </div>');
                redirect('Auth');
            }
        }
    }

    public function autlog($data)
    {
        //pesan adalah nama item 
        if ($data == 1) {
            $pesan = 'Silahkan Hubungi Admin Sistem Untuk Menset Ulang Password Anda!!';
        } elseif ($data == 2) {
            $pesan = 'Silahkan Hubungi Admin Sistem Untuk Mendaftarkan Account Anda!!';
        }
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            ' . $pesan . '
            </div>');
        redirect('Auth');
    }


    public function logout()
    {
        $data = [
            'tanggal' => time(),
            'aksi' => "Logout",
            'Keterangan' => "Logou Sistem",
            'ip' => $this->input->ip_address(),
            'tipe_login' => $this->session->userdata('role_id'),
            'id_user' => $this->session->userdata('id'),
            'status' => 1
        ];

        $this->login_Mod->addlog($data);
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id_jabatan');
        $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
            Anda Baru Saja Logout dari Aplikasi Dispsoisi!!!
        </div>');
        redirect('Auth');
    }

    public function pilih_Role($param = "")
    {
        if ($param) {
            if ($param == 1) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "Admin";
            } elseif ($param == 2) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "Operator";
            } elseif ($param == 3) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "User";
            } elseif ($param == 4) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "Direktur";
            } elseif ($param == 5) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "Wadir";
            } elseif ($param == 6) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "Adum";
            } elseif ($param == 7) {
                $email = $this->session->userdata('email');
                $role_id = $param;
                $id = $this->session->userdata('id');
                $redirect = "Admin_kepeg";
            }
            $datasession = [
                'email'     => $email,
                'role_id'   => $role_id,
                'id'        => $id
            ];
            $this->session->set_userdata($datasession);
            $data = [
                'tanggal' => time(),
                'aksi' => "Login",
                'Keterangan' => "Login Sistem",
                'ip' => $this->input->ip_address(),
                'tipe_login' => $this->session->userdata('role_id'),
                'id_user' => $this->session->userdata('id'),
                'status' => 1
            ];
            $this->login_Mod->addlog($data);
            redirect($redirect);
        } else {
            $id = $this->session->userdata('id');
            $dtpenguna = $this->login_Mod->get_penguna($id);
            $data['pilih_akun'] = 1;
            $data['peguna'] = $dtpenguna;
            $this->index($data);
        }
    }
}
