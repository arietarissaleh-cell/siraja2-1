<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_kode_hp extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_kode_hp_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_kode_hp(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
			$fid_unit = $this->input->post('fid_unit', TRUE);
            $list = $this->lookup_kode_hp_model->get_datatables_list_kode_hp($fid_unit);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_kode_hp_model) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_kode_hp(\''.$list_kode_hp_model->kode_hp.'\', \''.$list_kode_hp_model->fid_unit.'\', \''.$list_kode_hp_model->tahun.'\', \''.$list_kode_hp_model->nama.'\')" title="Detail \''.$list_kode_hp_model->nama.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                 
                  $row[] = $list_kode_hp_model->nama_unit;
                  $row[] = $list_kode_hp_model->kode_hp;
                  $row[] = $list_kode_hp_model->nama;
                  $row[] = $list_kode_hp_model->alamat;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_kode_hp_model->count_all_list_kode_hp($fid_unit),
                  "recordsFiltered" => $this->lookup_kode_hp_model->count_filtered_list_kode_hp($fid_unit),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}