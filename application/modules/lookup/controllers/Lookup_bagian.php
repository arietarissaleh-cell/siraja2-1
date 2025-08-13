<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_bagian extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_bagian_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_bagian(){
            $list = $this->lookup_bagian_model->get_datatables_list_bagian();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_bagian) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_bagian(\''.$list_bagian->id_kodesurat_jabatan.'\', \''.$list_bagian->nama_bagian.'\')" title="Detail \''.$list_bagian->nama_bagian.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_bagian->nama_bagian;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_bagian_model->count_all_list_bagian(),
                  "recordsFiltered" => $this->lookup_bagian_model->count_filtered_list_bagian(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}