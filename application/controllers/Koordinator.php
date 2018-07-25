<?php

  defined('BASEPATH') OR exit('No direct script access allowed');


  class Koordinator extends CI_Controller
  {

    /* ---------------------------- LOAD MODEL ----------------------------- */
    public function __construct()
    {
      parent::__construct();

      date_default_timezone_set('Asia/Jakarta');
      $this->load->model('m_report');
      $this->load->model('m_user');
      $this->load->model('m_case');
      $this->load->model('m_sanksi');

      if($this->session->userdata('login') != true)
      {
        redirect('auth');
      }
    }


    /* --------------------- LOAD VIEW AND CONTENT ------------------------ */
    function dashboard()
    {
      $this->load->view('koordinator/v_dashboard.php');
    }

    function user()
    {
      $this->load->view('koordinator/v_user.php');
    }

    function cases()
    {
      $this->load->view('koordinator/v_case.php');
    }


    /* ------------------------ AJAX REST API --------------------------- */
    function show_dashboard()
    {
      $tgl_from = $this->input->post('tgl_from');
      $tgl_to = $this->input->post('tgl_to');

      if(isset($tgl_from) && isset($tgl_to))
      {
        $between = "tanggal_report BETWEEN '$tgl_from' AND '$tgl_to'";
      } else {
        $between = null;
      }

      $data['top'] = $this->m_user->show_top5($between)->result();
      $data['jumlah_booking'] = $this->m_report->jumlah_report(null, null, 'klasifikasi = "Booking"', $between)->num_rows();
      $data['jumlah_rebook']  = $this->m_report->jumlah_report(null, null, 'klasifikasi = "Rebook"', $between)->num_rows();
      $data['jumlah_refund']  = $this->m_report->jumlah_report(null, null, 'klasifikasi = "Refund"', $between)->num_rows();
      $data['jumlah_other']   = $this->m_report->jumlah_report(null, null, 'klasifikasi = "Other"', $between)->num_rows();

      echo json_encode($data);
    }

    function show_user()
    {
      $cari = $this->input->post('cari');

      $where = array(
        'hak_akses' => 'Call Center'
      );

      if(isset($cari))
      {
        $data['user'] = $this->m_user->show_user($where, $cari)->result();
      } else {
        $data['user'] = $this->m_user->show_user($where, null)->result();
      }

      echo json_encode($data);
    }

    function show_case()
    {
      $data['case'] = $this->m_case->show_case(null)->result();
      echo json_encode($data);
    }

    function history_sanksi($nip)
    {
      $where = array(
        'nip' => $nip
      );

      $data['sanksi'] = $this->m_sanksi->show_sanksi($where)->result();
      echo json_encode($data);
    }


    /* ------------------------- AJAX RESPONSE -------------------------- */
    function validasi_case()
    {
      $data = array(
        'status_case' => 'Acc',
        'acc_by' => $this->session->userdata('jabatan')
      );

      $data2 = array(
        'status' => 'Valid'
      );

      $where = array(
        'id_case' => $this->input->post('id_case')
      );

      $where2 = array(
        'id_report' => $this->input->post('id_report')
      );

      $cek = $this->m_case->edit_case($data, $where);

      if($cek)
      {
        $cek2 = $this->m_report->edit_report($data2, $where2);
        if($cek2){
          echo "berhasil";
        } else {
          echo "gagal";
        }

      } else {
        echo "gagal";
      }
    }

  }

 ?>
