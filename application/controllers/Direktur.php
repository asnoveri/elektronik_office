<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Direktur extends CI_Controller
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
        $halaman = 'direktur/index';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }

    public function profil_dr()
    {
        $judul = 'Profil Direktur';
        $halaman = 'direktur/profil_dr';
        $data = "";
        $this->template->TemplateGen($judul, $halaman, $data);
    }
}
