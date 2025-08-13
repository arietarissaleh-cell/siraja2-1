<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_bank extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_bank_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_bank(){
            $list = $this->lookup_bank_model->get_datatables_list_bank();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_bank) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_bank(\''.$list_bank->id_bank.'\', \''.$list_bank->nama_bank.'\')" title="Detail \''.$list_bank->nama_bank.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_bank->nama_bank;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_bank_model->count_all_list_bank(),
                  "recordsFiltered" => $this->lookup_bank_model->count_filtered_list_bank(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}