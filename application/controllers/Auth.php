<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Auth extends CI_Controller
  {

    public function __construct()
    {
      parent::__construct();
      $this->load->model('m_user');
    }

    function index()
    {
      if($this->session->userdata('login') == true)
      {
        redirect('main/#dashboard');
      }

      $data['title'] = "Login | Daily Report";
      $this->load->view('v_login.php', $data);
    }

    function loginCek()
    {
      $nip = $this->input->post('nip');
      $password = md5($this->input->post('password'));

      $where = array(
        'nip' => $nip,
        'password' => $password
      );

      $cek = $this->m_user->loginCek($where);
      if($cek->num_rows() == 1)
      {
        foreach($cek->result() as $key)
        {
          $sess_nip     = $key->nip;
          $hak_akses    = $key->hak_akses;
          $foto         = $key->foto;
          $nama         = $key->nama;
          $jabatan      = $key->jabatan;
        }

        $session = array(
          'nip' => $sess_nip,
          'nama' => $nama,
          'hak_akses' => $hak_akses,
          'jabatan' => $jabatan,
          'foto' => $foto,
          'login' => true
        );

        $data = array('status_user' => 'online');
        $this->m_user->updateLogin($where, $data);

        $this->session->set_userdata($session);
        echo $hak_akses;

      } else {
        echo "gagal";
      }
    }

    function logOut()
    {
      $where = array('nip' => $this->session->userdata('nip'));
      $data = array('status_user' => 'offline');
      $this->m_user->updateLogin($where, $data);

      $this->session->sess_destroy();
      redirect('auth');
    }

    function ganti_password()
    {
      $nip      = $this->session->userdata('nip');
      $new_pass = $this->input->post('new_password');
      $old_pass = $this->input->post('old_password');

      $where = array(
        'nip' => $nip,
        'password' => md5($old_pass)
      );

      $data = array(
        'password' => md5($new_pass)
      );

      $rows = $this->m_user->show_user($where, null)->num_rows();

      if($rows == 1)
      {
        $cek = $this->m_user->ganti_password($where, $data);
        if($cek)
        {
          echo "berhasil";
        } else {
          echo "gagal";
        }
      }  else {
        echo "gagal";
      }


    }

  }


 ?>
