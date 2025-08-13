<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_kabupaten extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_kabupaten_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_kabupaten(){
            $list = $this->lookup_kabupaten_model->get_datatables_list_bank();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_kabupaten) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_kabupaten(\''.$list_kabupaten->id_kabupaten.'\', \''.$list_kabupaten->kode.'\', \''.$list_kabupaten->keterangan.'\')" title="Detail \''.$list_kabupaten->keterangan.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_kabupaten->kode;
                  $row[] = $list_kabupaten->keterangan;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_kabupaten_model->count_all_list_bank(),
                  "recordsFiltered" => $this->lookup_kabupaten_model->count_filtered_list_bank(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}