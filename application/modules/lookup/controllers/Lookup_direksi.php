<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_direksi extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_direksi_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_direksi(){
            $list = $this->lookup_direksi_model->get_datatables_list_direksi();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_direksi) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_direksi(\''.$list_direksi->id_direktorat.'\', \''.$list_direksi->nama_direktorat.'\')" title="Detail \''.$list_direksi->nama_direktorat.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_direksi->nama_direktorat;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_direksi_model->count_all_list_direksi(),
                  "recordsFiltered" => $this->lookup_direksi_model->count_filtered_list_direksi(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}