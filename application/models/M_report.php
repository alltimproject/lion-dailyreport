<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class M_report extends CI_Model
  {  
    function show_report($tanggal = null, $where = null, $between = null, $limit = null)
    {
      $this->db->select('*');
      $this->db->from('t_report');
      $this->db->join('t_user', 't_user.nip = t_report.nip', 'left');
      $this->db->join('t_case', 't_case.id_report_case = t_report.id_report', 'left');
      $this->db->order_by('id_report_case', 'DESC');
      $this->db->order_by('id_report', 'DESC');

      if($tanggal != null){
          $this->db->like('tanggal_report', $tanggal);
      }

      if($where != null){
        $this->db->where($where);
      }

      if($between != null){
        $this->db->where($between);
      }

      if($limit != null){
        $this->db->limit($limit);
      }

      return $this->db->get();
    }

    function show_report_call($tanggal = null, $where = null, $between = null, $limit = null)
    {
      $this->db->select('*');
      $this->db->from('t_report');

      if($tanggal != null){
          $this->db->like('tanggal_report', $tanggal);
      }

      if($where != null){
        $this->db->where($where);
      }

      if($between != null){
        $this->db->where($between);
      }

      if($limit != null){
        $this->db->limit($limit);
      }

      $this->db->order_by("datetime_report", "DESC");
      return $this->db->get();
    }

    function jumlah_report($tanggal = null, $where = null, $klasifikasi, $between = null)
    {
      $this->db->select('*');
      $this->db->from('t_report');

      if($tanggal != null){
          $this->db->like('tanggal_report', $tanggal);
      }

      if($where != null){
        $this->db->where($where);
      }

      if($between != null){
        $this->db->where($between);
      }

      $this->db->where($klasifikasi);
      return $this->db->get();
    }

    function add_report($data)
    {
      return $this->db->insert('t_report', $data);
    }

    function edit_report($data, $where)
    {
      $this->db->where($where);
      return $this->db->update('t_report', $data);
    }

  }

?>
