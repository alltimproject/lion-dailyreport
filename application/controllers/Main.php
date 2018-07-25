<?php

  defined('BASEPATH') OR exit('No direct script access allowed');


  class Main extends CI_Controller
  {

    public function __construct()
    {
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');

      if($this->session->userdata('login') != true)
      {
        redirect('auth');
      }
    }

    /* ----------------------- LOAD INDEX OF PAGE ------------------------ */
    function index()
    {
      $hak_akses = $this->session->userdata('hak_akses');

      if ($hak_akses == "Call Center")
      {
        $data['title'] = "Call Center | Daily Report";
        $this->load->view('call-center/v_main.php', $data);
      } elseif ($hak_akses == 'Admin')
      {
        $data['title'] = "Admin | Daily Report";
        $this->load->view('admin/v_main.php', $data);
      } elseif ($hak_akses == 'Koordinator')
      {
        $data['title'] = "Koordinator | Daily Report";
        $this->load->view('koordinator/v_main.php', $data);
      } elseif ($hak_akses == 'Asisten Manajer')
      {
        $data['title'] = "Asisten Manajer | Daily Report";
        $this->load->view('asmen/v_main.php', $data);
      }

    }

  }

?>
