<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class M_user extends CI_Model
  {
    function loginCek($data)
    {
      return $this->db->get_where('t_user', $data);
    }

    function updateLogin($where, $data)
    {
      $this->db->where($where);
      return $this->db->update('t_user', $data);
    }

    function ganti_password($where, $data)
    {
      $this->db->where($where);
      return $this->db->update('t_user', $data);
    }

    function show_user($where, $like = null)
    {
      $this->db->select('*');
      $this->db->select('(SELECT count(id_pesan) FROM t_pesan WHERE t_pesan.user_from = t_user.nip AND t_pesan.user_to = "admin" AND status_pesan = "unread") as jumlah_unread');
      $this->db->from('t_user');

      if($like != null)
      {
        $this->db->like('nama', $like);
      }

      $this->db->where($where);
      return $this->db->get();
    }

    function add_user($data)
    {
      return $this->db->insert('t_user', $data);
    }

    function edit_user($data, $where)
    {
      $this->db->where($where);
      return $this->db->update('t_user', $data);
    }

    function upload($nip)
		{
			$nama_file = 'foto_'.$nip;
			$config['upload_path']   = './images/users/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']      = '3048';
			$config['remove_space']  = TRUE;
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			if($this->upload->do_upload('foto_user') ){
			     $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			     return $return;
			} else {
      		$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
		  		return $return;
			}
		}

    function update_foto($where, $upload)
    {
      $data = array(
				'foto' => $upload['file']['file_name']
			);

			$this->db->where($where);
			return $this->db->update('t_user', $data);
    }

    function show_top5($between = null)
    {
      $this->db->select('*');

      if($between != null){
        $this->db->select('(select count(id_report) from t_report where t_report.nip = t_user.nip AND '.$between.') as total_report');
      } else {
        $this->db->select('(select count(id_report) from t_report where t_report.nip = t_user.nip) as total_report');
      }
		  $this->db->from('t_user');
      $this->db->where('hak_akses = "Call Center"');
      $this->db->order_by('total_report', 'DESC');
      $this->db->limit(5);
      return $this->db->get();
    }


  }

?>
