<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_kode_person extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_kode_person_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_kode_person(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
			$fid_unit = $this->input->post('fid_unit', TRUE);
            $list = $this->lookup_kode_person_model->get_datatables_list_kode_person($fid_unit);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_kode_person_model) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_kode_person(\''.$list_kode_person_model->kode_person.'\', \''.$list_kode_person_model->fid_unit.'\', \''.$list_kode_person_model->id_person.'\', \''.$list_kode_person_model->nama_person.'\')" title="Detail \''.$list_kode_person_model->nama_person.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                 
                 
                  $row[] = $list_kode_person_model->nama_unit;
                  $row[] = $list_kode_person_model->kode_person;
                  $row[] = $list_kode_person_model->nama_person;
                  $row[] = $list_kode_person_model->jabatan;
                 
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_kode_person_model->count_all_list_kode_person($fid_unit),
                  "recordsFiltered" => $this->lookup_kode_person_model->count_filtered_list_kode_person($fid_unit),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	  
	  
	   public function pilih_kode_person_mandor(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
			$fid_unit = $this->input->post('fid_unit', TRUE);
            $list = $this->lookup_kode_person_model->get_datatables_list_kode_person_mandor($fid_unit);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_kode_person_mandor_model) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_kode_person(\''.$list_kode_person_mandor_model->kode_person.'\', \''.$list_kode_person_mandor_model->fid_unit.'\', \''.$list_kode_person_mandor_model->id_person.'\', \''.$list_kode_person_mandor_model->nama_person.'\', \''.$list_kode_person_mandor_model->nama_sinder.'\')" title="Detail \''.$list_kode_person_mandor_model->nama_person.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                 
                 
                  $row[] = $list_kode_person_mandor_model->nama_unit;
                  $row[] = $list_kode_person_mandor_model->kode_person;
                  $row[] = $list_kode_person_mandor_model->nama_person;
                  $row[] = $list_kode_person_mandor_model->jabatan;
                  $row[] = $list_kode_person_mandor_model->nama_sinder;
                 
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_kode_person_model->count_all_list_kode_person_mandor($fid_unit),
                  "recordsFiltered" => $this->lookup_kode_person_model->count_filtered_list_kode_person_mandor($fid_unit),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}