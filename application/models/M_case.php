<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class M_case extends CI_Model
  {

    function show_case($where = null)
    {
      $this->db->select('*');
      $this->db->from('t_case');
      $this->db->join('t_report', 't_report.id_report = t_case.id_report_case', 'left');
      $this->db->join('t_user', 't_report.nip = t_user.nip', 'left');

      if($where != null) {
        $this->db->where($where);
      }

      $this->db->order_by('id_case', 'DESC');
      return $this->db->get();
    }

    function edit_case($data, $where)
    {
      $this->db->where($where);
      return $this->db->update('t_case', $data);
    }

    function tambah_case($data)
    {
      return $this->db->insert('t_case', $data);
    }

  }

?>
