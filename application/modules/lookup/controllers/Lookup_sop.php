<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_sop extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_sop_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_sop(){
            $list = $this->lookup_sop_model->get_datatables_list_sop();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_sop) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_sop(\''.$list_sop->id_sop.'\', \''.$list_sop->no_sop.'\', \''.$list_sop->bagian.'\', \''.$list_sop->perihal_kegiatan.'\')" title="Detail \''.$list_sop->perihal_kegiatan.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_sop->no_sop;
                  $row[] = $list_sop->perihal_kegiatan;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_sop_model->count_all_list_sop(),
                  "recordsFiltered" => $this->lookup_sop_model->count_filtered_list_sop(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}