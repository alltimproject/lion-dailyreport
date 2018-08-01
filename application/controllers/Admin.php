<?php

  defined('BASEPATH') OR exit('No direct script access allowed');


  class Admin extends CI_Controller
  {

    /* --------------------------- LOAD MODEL ----------------------------- */
    public function __construct()
    {
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      $this->load->model('m_report');
      $this->load->model('m_user');
      $this->load->model('m_case');
      $this->load->model('m_pesan');
      $this->load->model('m_main');


      if($this->session->userdata('login') != true)
      {
        redirect('auth');
      }
    }

    /* ----------------------- LOAD VIEW AND CONTENT ------------------------ */
    function dashboard()
    {
      $this->load->view('admin/v_dashboard.php');
    }

    function report()
    {
      $this->load->view('admin/v_report.php');
    }

    function cases()
    {
      $this->load->view('admin/v_case.php');
    }

    function user()
    {
      $this->load->view('admin/v_user.php');
    }


    /* -------------------------- AJAX REST API --------------------------- */
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

    function show_report()
    {
      $tgl_from = $this->input->post('tgl_from');
      $tgl_to = $this->input->post('tgl_to');

      if(isset($tgl_from) && isset($tgl_to))
      {
        $between = "tanggal_report BETWEEN '$tgl_from' AND '$tgl_to'";
      } else {
        $between = null;
      }

      $data['report'] = $this->m_report->show_report(null, null, $between, null)->result();
      echo json_encode($data);
    }

    function export_report()
    {
      $tgl_from = $this->input->post('tgl_from');
      $tgl_to = $this->input->post('tgl_to');

      $data['tgl_from'] = $tgl_from;
      $data['tgl_to'] = $tgl_to;

      if(null !== $this->input->post('excel'))
      {
        if(isset($tgl_from) && isset($tgl_to))
        {
          $between = "tanggal_report BETWEEN '$tgl_from' AND '$tgl_to'";
          $data['data'] = $this->m_report->show_report(null, null, $between, null)->result();
        } elseif($tgl_from == '' && $tgl_to == ''){
          $data['data'] = $this->m_report->show_report(null, null, null, null)->result();
        }

        $this->load->view('admin/v_report_excel', $data);
      } elseif(null !== $this->input->post('pdf')){

        if(isset($tgl_from) && isset($tgl_to))
        {
          $between = "tanggal_report BETWEEN '$tgl_from' AND '$tgl_to'";
          $data = $this->m_report->show_report(null, null, $between, null);
        } elseif($tgl_from == '' && $tgl_to == ''){
          $data = $this->m_report->show_report(null, null, null, null);
        }

        $this->load->library('pdf');
    		$pdf = new FPDF('L','mm','A4');
    		$pdf->AddPage();

        $pdf->Image('images/bg03.png',130,10,30,10);
        $pdf->ln(12);
        $pdf->SetFont('Arial','B',10);
    		$pdf->Cell(120);
    		$pdf->Cell(30,5,'PT. Lion Mentari Airlines',0,1,'C');
    		$pdf->Cell(120);
    		$pdf->Cell(30,5,'Jl. Gajah Mada no 7 Jakarta Pusat',0,1,'C');
    		$pdf->Cell(120);
    		$pdf->Cell(30,5,'Telp: (021) 63798000',0,1,'C');
    		$pdf->ln(5);
    		$pdf->Cell(280,0,'',1,0,'C');
    		$pdf->ln(5);

        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(0,5,'Data Report periode '.$tgl_from.' s/d '.$tgl_to,0,0);
        $pdf->ln(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(10,7,'No',1,0,'C');
        $pdf->Cell(30,7,'ID Report',1,0,'C');
        $pdf->Cell(20,7,'Booking',1,0,'C');
        $pdf->Cell(30,7,'Tanggal',1,0,'C');
        $pdf->Cell(20,7,'Klasifikasi',1,0,'C');
        $pdf->Cell(90,7,'Keterangan',1,0,'C');
        $pdf->Cell(60,7,'PIC',1,0,'C');
        $pdf->Cell(20,7,'Status',1,0,'C');

        $pdf->SetFont('Arial','',10);
        $no = 1;
        foreach ($data->result() as $key) {
          $pdf->ln();
          $pdf->Cell(10,7,$no++,1,0,'C');
          $pdf->Cell(30,7,$key->id_report,1,0,'C');
          $pdf->Cell(20,7,$key->kd_booking,1,0,'C');
          $pdf->Cell(30,7,$key->tanggal_report,1,0,'C');
          $pdf->Cell(20,7,$key->klasifikasi,1,0,'C');
          $pdf->Cell(90,7,$key->keterangan,1,0,'C');
          $pdf->Cell(60,7,$key->nama,1,0,'C');
          $pdf->Cell(20,7,$key->status,1,0,'C');
        }

        $pdf->Output();
      }
    }

    function show_case()
    {
      $data['case'] = $this->m_case->show_case(null)->result();
      echo json_encode($data);
    }

    function show_user()
    {
      $cari = $this->input->post('cari');

      $where = 'hak_akses != "Admin"';

      if(isset($cari))
      {
        $data['user'] = $this->m_user->show_user($where, $cari)->result();
      } else {
        $data['user'] = $this->m_user->show_user($where, null)->result();
      }

      echo json_encode($data);
    }

    function show_pesan()
    {
      $user1 = $this->session->userdata('nip');
      $user2 = $this->input->post('nip');
      // $user2 = '153150';

      $data['pesan'] = $this->m_pesan->show_pesan($user1, $user2)->result();

      echo json_encode($data);
    }


    /* ------------------------- AJAX RESPONSE ----------------------------- */
    function validasi_report($id_report)
    {
      $where = array(
        'id_report' => $id_report
      );

      $data = array(
        'status' => 'Valid'
      );

      $cek = $this->m_report->edit_report($data, $where);

      if($cek){
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function tambah_case()
    {
      $id_case   = $this->m_main->buatKode('t_case', 'C', 'id_case', '9');
      $id_report = $this->input->post('id_report');
      $kronologi = $this->input->post('kronologi');

      $data = array(
        'id_case' => $id_case,
        'id_report_case' => $id_report,
        'kronologis' => $kronologi,
        'status_case' => 'Proses'
      );

      $cek = $this->m_case->tambah_case($data);
      if($cek){
        echo "berhasil";
      } else {
        echo "gagal";
      }

    }

    function edit_case()
    {
      $id_case = $this->input->post('id_case');
      $kronologis = $this->input->post('kronologis');

      $data = array(
        'kronologis' => $kronologis
      );

      $where = array(
        'id_case' => $id_case
      );

      $cek = $this->m_case->edit_case($data, $where);
      if($cek)
      {
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function add_user()
    {
      $jabatan = $this->input->post('jabatan');

      if($jabatan == 'Koordinator'){
        $hak_akses = 'Koordinator';
        $password = 'koordinator';
      } elseif($jabatan == 'Asisten Manajer') {
        $hak_akses = 'Asisten Manajer';
        $password = 'asmen';
      } else {
        $hak_akses = 'Call Center';
        $password = 'callcenter';
      }

      $data = array(
        'nip' => $this->input->post('new-nip'),
        'nama' => $this->input->post('nama'),
        'jabatan' => $this->input->post('jabatan'),
        'password' => md5($password),
        'hak_akses' => $hak_akses,
      );

      $cek = $this->m_user->add_user($data);

      if($cek)
      {
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function edit_user()
    {
      $jabatan = $this->input->post('jabatan');

      if($jabatan == 'Koordinator'){
        $hak_akses = 'Koordinator';
      } elseif($jabatan == 'Asisten Manajer') {
        $hak_akses = 'Asisten Manajer';
      } else {
        $hak_akses = 'Call Center';
      }

      $data = array(
        'nip' => $this->input->post('new-nip'),
        'nama' => $this->input->post('nama'),
        'jabatan' => $this->input->post('jabatan'),
        'password' => md5('callcenter'),
        'hak_akses' => $hak_akses
      );

      $where = array(
        'nip' => $this->input->post('nip')
      );

      $cek = $this->m_user->edit_user($data, $where);

      if($cek)
      {
        echo "berhasil";
      } else {
        echo "gagal";
      }
    }

    function upload_user()
    {
      $nip = $this->input->post('nip');

      $where = array(
				'nip' => $nip
			);

      $upload = $this->m_user->upload($nip);
      if($upload['result'] == "success"){
        $cek = $this->m_user->update_foto($where, $upload);
        if($cek){
          echo "berhasil";
        } else {
          echo "gagal";
        }
      }
    }

    function send_pesan()
    {
      $data = array(
        'pesan' => $this->input->post('pesan'),
        'user_from' => $this->session->userdata('nip'),
        'user_to' => $this->input->post('nip'),
        'status_pesan' => 'unread'
      );

      $where = array(
        'user_from' => $this->input->post('nip'),
        'user_to' => 'admin',
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
        'user_from' => $this->input->post('nip'),
        'user_to' => 'admin',
        'status_pesan' => 'unread'
      );

      $data = array(
        'status_pesan' => 'read'
      );

      $this->m_pesan->update_pesan($where, $data);
    }

  }

?>
