<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class M_sanksi extends CI_Model
  {
    function add_sanksi($data)
    {
      return $this->db->insert('t_sanksi', $data);
    }

    function show_sanksi($where)
    {
      $this->db->select('*');
      $this->db->from('t_sanksi');

      $this->db->where($where);
      return $this->db->get();
    }

    function detail_sanksi($where)
    {
      $this->db->select('*');
      $this->db->from('t_sanksi');
      $this->db->join('t_user', 't_user.nip = t_sanksi.nip', 'left');

      $this->db->where($where);
      return $this->db->get();
    }

  }

?>
