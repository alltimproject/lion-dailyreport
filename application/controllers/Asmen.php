<?php

  defined('BASEPATH') OR exit('No direct script access allowed');


  class Asmen extends CI_Controller
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
      $this->load->model('m_main');

      if($this->session->userdata('login') != true)
      {
        redirect('auth');
      }
    }


    /* ---------------------- LOAD VIEW AND CONTENT --------------------- */
    function dashboard()
    {
      $this->load->view('asmen/v_dashboard.php');
    }

    function user()
    {
      $this->load->view('asmen/v_user.php');
    }



    /* ------------------------- AJAX REST API -------------------------- */
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

    function cases()
    {
      $this->load->view('asmen/v_case.php');
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

    function tambah_sanksi()
    {
      $nip        = $this->input->post('nip');
      $jenis      = $this->input->post('jenis_sanksi');
      $keterangan = $this->input->post('keterangan_sanksi');
      $id_sanksi  = $this->m_main->buatKode('t_sanksi', 'S', 'id_sanksi', '9');

      $data = array(
        'id_sanksi' => $id_sanksi,
        'nip' => $nip,
        'jenis_sanksi' => $jenis,
        'keterangan_sanksi' => $keterangan
      );

      $cek = $this->m_sanksi->add_sanksi($data);
      if($cek){
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function print_sanksi($id)
    {
      $where = array(
        'id_sanksi' => $id
      );

      $data = $this->m_sanksi->detail_sanksi($where)->result();

      $this->load->library('pdf');
      $pdf = new FPDF('P','mm','A4');
      $pdf->AddPage();

      $pdf->Image('images/bg03.png',90,10,30,10);
      $pdf->ln(12);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(80);
      $pdf->Cell(30,5,'PT. Lion Mentari Airlines',0,1,'C');
      $pdf->Cell(80);
      $pdf->Cell(30,5,'Jl. Gajah Mada no 7 Jakarta Pusat',0,1,'C');
      $pdf->Cell(80);
      $pdf->Cell(30,5,'Telp: (021) 63798000',0,1,'C');
      $pdf->ln(5);
      $pdf->Cell(190,0,'',1,0,'C');
      $pdf->ln(5);

      foreach ($data as $detail) {
        $nip = $detail->nip;
        $nama = $detail->nama;
        $jabatan = $detail->jabatan;
        $id_sanksi = $detail->id_sanksi;
        $tanggal = $detail->tanggal_sanksi;
        $jenis = $detail->jenis_sanksi;
        $keterangan = $detail->keterangan_sanksi;

        if($jenis == 'SP1')
        {
          $sp = 'Surat Peringatan Pertama';
          $sp_next = 'akan diterbitkan Surat Peringatan Kedua';
        } elseif($jenis == 'SP2') {
          $sp = 'Surat Peringatan Kedua';
          $sp_next = 'akan diterbitkan Surat Peringatan Ketiga';
        } else {
          $sp = 'Surat Peringatan Ketiga';
          $sp_next = 'karyawan akan diberhentikan';
        }
      }

      $pdf->SetFont('Arial','B',13);
      $pdf->Cell(80);
      $pdf->Cell(30,5,'Surat Peringatan',0,1,'C');
      $pdf->SetFont('Arial','I',10);
      $pdf->Cell(80);
      $pdf->Cell(30,5,'Nomor: '.$id,0,1,'C');
      $pdf->ln(10);

      $pdf->SetFont('Arial','',10);
      $pdf->Cell(0,5,'Surat Peringatan ini ditunjukkan kepada :',0,1);
      $pdf->ln();

      $pdf->Cell(50,5,'NIP',0,0);
      $pdf->Cell(50,5,': '.$nip,0,0);
      $pdf->ln();

      $pdf->Cell(50,5,'Nama',0,0);
      $pdf->Cell(50,5,': '.$nama,0,0);
      $pdf->ln();

      $pdf->Cell(50,5,'Jabatan',0,0);
      $pdf->Cell(50,5,': '.$jabatan,0,0);
      $pdf->ln(10);

      $pdf->Cell(200,5,'Surat peringatan ini diberikan kepada saudara '.$nama.' dikarenakan karyawan yang bersangkutan',0,1);
      $pdf->Cell(200,5,'melakukan kesalahan yakni '. $keterangan .'.',0,1);
      $pdf->ln();

      $pdf->Cell(200,5,'Sehubungan dengan pelanggaran tersebut, perusahaan memberikan '.$sp.' dengan ketentuan',0,1);
      $pdf->Cell(200,5,'sebagai berikut :',0,1);
      $pdf->ln();

      $pdf->Cell(10, 5, '1. ', 0,0);
      $pdf->Cell(190,5,'Surat peringatan ini berlaku 3 bulan sejak diterbitkan dan apabila dalam 3 bulan kedepan tidak melakukan',0,1);
      $pdf->Cell(10, 5, '', 0,0);
      $pdf->Cell(190,5,'maka '.$sp .' ini sudah tidak berlaku.',0,0);
      $pdf->ln();

      $pdf->Cell(10, 5, '2. ', 0,0);
      $pdf->Cell(190,5,'Apabila dalam kurun waktu 3 bulan kedepan saudara melakukan pelanggaran maka ',0,1);
      $pdf->Cell(10, 5, ' ', 0,0);
      $pdf->Cell(190,5,$sp_next,0,1);
      $pdf->ln();

      $pdf->Cell(200,5,'Demikian Surat Peringatan ini dikeluarkan untuk menjadi bahan perenungan dan bahan perhatian.',0,1);
      $pdf->ln(10);

      $pdf->Cell(130);
      $pdf->Cell(0,5,'Jakarta, '.date('d M Y', strtotime($tanggal)),0,1);
      $pdf->ln();

      $pdf->Cell(130);
      $pdf->Cell(0,0,'Asisten Manajer',0,1);
      $pdf->ln(30);

      $pdf->Cell(130);
      $pdf->Cell(0,0,'( '.$this->session->userdata('nama').' )',0,1);

      $pdf->Output();
    }




  }

?>
