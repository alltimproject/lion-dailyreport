<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Pdf {

    function pdf()
    {
      $CI = &get_instance();
      log_message('Debug', 'mPDF class is loaded');
    }

    function load()
    {
      include_once APPPATH.'/third_party/mpdf60/mpdf.php';
      ini_set('memory_limit','1024M');

      return new mPDF('utf-8', 'A4','','Arial', 5, 5, 30, 20);
      //'c','A4','','',20,15,48,25,10,10
    }
  }

 ?>
