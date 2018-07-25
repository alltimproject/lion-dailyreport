<?php

  defined('BASEPATH') OR exit('No direct script access allowed');


  class Call extends CI_Controller
  {

    /* ------------------------ LOAD MODEL --------------------------- */
    public function __construct()
    {
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      $this->load->model('m_report');
      $this->load->model('m_pesan');
      $this->load->model('m_main');

      if($this->session->userdata('login') != true)
      {
        redirect('auth');
      }
    }


    /* ---------------------- LOAD VIEW AND CONTENT------------------------- */
    function dashboard()
    {
      $this->load->view('call-center/v_dashboard.php');
    }

    function master()
    {
      $this->load->view('call-center/v_master.php');
    }


    /* -------------------------- AJAX REST API----------------------------- */
    function show_report()
    {
      $where = array(
        'nip' => $this->session->userdata('nip')
      );
      $tanggal = date('Y-m-d');
      $data['report'] = $this->m_report->show_report_call($tanggal, $where, null, null)->result();

      $data['jumlah_booking'] = $this->m_report->jumlah_report($tanggal, $where, 'klasifikasi = "Booking"')->num_rows();
      $data['jumlah_rebook']  = $this->m_report->jumlah_report($tanggal, $where, 'klasifikasi = "Rebook"')->num_rows();
      $data['jumlah_refund']  = $this->m_report->jumlah_report($tanggal, $where, 'klasifikasi = "Refund"')->num_rows();
      $data['jumlah_other']   = $this->m_report->jumlah_report($tanggal, $where, 'klasifikasi = "Other"')->num_rows();

      echo json_encode($data);
    }

    function all_report()
    {
      $tgl_from = $this->input->post('tgl_from');
      $tgl_to = $this->input->post('tgl_to');

      if(isset($tgl_from) && isset($tgl_to))
      {
        $where = array(
          'nip' => $this->session->userdata('nip')
        );

        $between = "tanggal_report BETWEEN '$tgl_from' AND '$tgl_to'";
      } else {
        $where = array(
          'nip' => $this->session->userdata('nip')
        );

        $between = null;
      }

      $data['report'] = $this->m_report->show_report_call(null, $where, $between, 200)->result();
      $data['jumlah_booking'] = $this->m_report->jumlah_report(null, $where, 'klasifikasi = "Booking"', $between)->num_rows();
      $data['jumlah_rebook']  = $this->m_report->jumlah_report(null, $where, 'klasifikasi = "Rebook"', $between)->num_rows();
      $data['jumlah_refund']  = $this->m_report->jumlah_report(null, $where, 'klasifikasi = "Refund"', $between)->num_rows();
      $data['jumlah_other']   = $this->m_report->jumlah_report(null, $where, 'klasifikasi = "Other"', $between)->num_rows();

      echo json_encode($data);
    }

    function show_pesan()
    {
      $user1 = $this->session->userdata('nip');
      $user2 = 'admin';

      $where = array(
        'user_from' => 'admin',
        'status_pesan' => 'unread'
      );

      $data['pesan'] = $this->m_pesan->show_pesan($user1, $user2)->result();
      $data['jumlah'] = $this->m_pesan->count_pesan($where)->num_rows();

      echo json_encode($data);
    }

    /* -------------------------- AJAX RESPONSE----------------------------- */

    function tambah_report()
    {
      $id_report    = $this->m_main->buatKode('t_report', 'R', 'id_report', '9');
      $nip          = $this->session->userdata('nip');
      $kd_booking   = $this->input->post('kd_booking');
      $tanggal      = date('Y-m-d');
      $klasifikasi  = $this->input->post('klasifikasi');
      $keterangan   = $this->input->post('keterangan');

      $data = array(
        'id_report' => $id_report,
        'kd_booking' => strtoupper($kd_booking),
        'tanggal_report' => $tanggal,
        'klasifikasi' => $klasifikasi,
        'keterangan' => $keterangan,
        'nip' => $nip,
        'status' => 'Proses'
      );

      $cek = $this->m_report->add_report($data);

      if($cek)
      {
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function edit_report()
    {
      $nip          = $this->session->userdata('nip');
      $id_report    = $this->input->post('id_report');
      $kd_booking   = $this->input->post('kd_booking');
      $klasifikasi  = $this->input->post('klasifikasi');
      $keterangan   = $this->input->post('keterangan');

      $data = array(
        'kd_booking' => strtoupper($kd_booking),
        'klasifikasi' => $klasifikasi,
        'keterangan' => $keterangan,
        'nip' => $nip,
        'status' => 'Proses'
      );

      $where = array(
        'id_report' => $id_report
      );

      $cek = $this->m_report->edit_report($data, $where);

      if($cek)
      {
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function send_pesan()
    {
      $data = array(
        'pesan' => $this->input->post('pesan'),
        'user_from' => $this->session->userdata('nip'),
        'user_to' => 'admin',
        'status_pesan' => 'unread'
      );

      $where = array(
        'user_from' => 'admin',
        'status_pesan' => 'unread'
      );

      $data1 = array(
        'status_pesan' => 'read'
      );

      $this->m_pesan->update_pesan($where, $data1);
      $this->m_pesan->send_pesan($data);
    }

    function update_pesan()
    {
      $where = array(
        'user_from' => 'admin',
        'status_pesan' => 'unread'
      );

      $data = array(
        'status_pesan' => 'read'
      );

      $this->m_pesan->update_pesan($where, $data);
    }

  }

?>
