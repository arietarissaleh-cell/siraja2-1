<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_bidang extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_bidang_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_bidang(){
            $list = $this->lookup_bidang_model->get_datatables_list_bidang();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_bidang) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_bidang(\''.$list_bidang->id_bidang.'\', \''.$list_bidang->nama_bidang.'\')" title="Detail \''.$list_bidang->nama_bidang.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_bidang->nama_bidang;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_bidang_model->count_all_list_bidang(),
                  "recordsFiltered" => $this->lookup_bidang_model->count_filtered_list_bidang(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}