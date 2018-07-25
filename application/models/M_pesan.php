<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class M_pesan extends CI_Model
  {
    function send_pesan($data)
    {
      return $this->db->insert('t_pesan', $data);
    }

    function show_pesan($user1, $user2)
    {
      $this->db->select('*');
      $this->db->from('t_pesan');

      $this->db->where("user_from = '$user1' AND user_to = '$user2' OR user_from = '$user2' AND user_to = '$user1'");

      $this->db->order_by('tanggal_pesan', 'ASC');
      $this->db->order_by('id_pesan', 'ASC');
      $this->db->limit(50);
      return $this->db->get();
    }

    function count_pesan($where)
    {
      $this->db->select('*');
      $this->db->from('t_pesan');
      $this->db->where($where);

      return $this->db->get();
    }

    function update_pesan($where, $data)
    {
      $this->db->where($where);
      return $this->db->update('t_pesan', $data);
    }

  }

?>
