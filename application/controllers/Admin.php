<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_Mod');
        $this->load->model('menu_Mod');
        date_default_timezone_set('Asia/Jakarta');
        is_login();
    }

    public function index()
    {
        $judul = 'Dashboard';
        $halaman = 'admin/index';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function profil_admin()
    {
        $judul = 'Profil ';
        $halaman = 'admin/profil';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }
}
