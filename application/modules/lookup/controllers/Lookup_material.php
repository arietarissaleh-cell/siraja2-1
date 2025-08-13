<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_material extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_material_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_material(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
			$fid_unit = $this->input->post('fid_unit', TRUE);
            $list = $this->lookup_material_model->get_datatables_list_material($fid_unit);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_material_model) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_material(\''.$list_material_model->kode_coa.'\', \''.$list_material_model->fid_unit.'\', \''.$list_material_model->id_coa.'\', \''.$list_material_model->deskripsi.'\')" title="Detail \''.$list_material_model->deskripsi.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                 
                 
                  $row[] = $list_material_model->nama_unit;
                  $row[] = $list_material_model->kode_coa;
                  $row[] = $list_material_model->deskripsi;
                  $row[] = $list_material_model->kode_golongan .' : '. $list_material_model->nama_golongan;
                  $row[] = $list_material_model->kode_konsol .' : '. $list_material_model->nama_konsol;
                 
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_material_model->count_all_list_material($fid_unit),
                  "recordsFiltered" => $this->lookup_material_model->count_filtered_list_material($fid_unit),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	  
	  
	  
	  

      
}