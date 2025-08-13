<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_coa extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_coa_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_coa(){
            $tahun = $this->input->post("tahun", TRUE);
            $fid_unit = $this->input->post("fid_unit", TRUE);

            $list = $this->lookup_coa_model->get_datatables($fid_unit, $tahun);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_coa) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_coa(\''.$list_coa->kode_coa.'\')" title="Pilih \''.$list_coa->deskripsi.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_coa->c_unit;
                  $row[] = $list_coa->kode_coa;
                  $row[] = $list_coa->deskripsi;
                  $row[] = $list_coa->c_golongan;
                  $row[] = $list_coa->c_konsol;
                  $row[] = $list_coa->saldo;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_coa_model->count_all($fid_unit, $tahun),
                  "recordsFiltered" => $this->lookup_coa_model->count_filtered($fid_unit, $tahun),
                  "data" => $data,
            );
            echo json_encode($output);
      }
}