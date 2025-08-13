<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_surat extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_surat_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_surat(){
            $list = $this->lookup_surat_model->get_datatables_list_surat();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_surat) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_surat(\''.$list_surat->id_surat.'\', \''.$list_surat->nomor_surat.'\', \''.$list_surat->perihal.'\')" title="Detail \''.$list_surat->perihal.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_surat->nomor_surat;
                  $row[] = $list_surat->perihal;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_surat_model->count_all_list_surat(),
                  "recordsFiltered" => $this->lookup_surat_model->count_filtered_list_surat(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}