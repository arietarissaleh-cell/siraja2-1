<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_mitra extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_mitra_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_mitra(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
            $list = $this->lookup_mitra_model->get_datatables_list_mitra($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_mitra) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_mitra(\''.$list_mitra->id_petani.'\', \''.$list_mitra->nama.'\', \''.$list_mitra->fid_unit.'\')" title="Detail \''.$list_mitra->nama.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_mitra->nama;
                  $row[] = $list_mitra->nik;
                  $row[] = $list_mitra->alamat;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_mitra_model->count_all_list_mitra($fid_lokasi_kerja),
                  "recordsFiltered" => $this->lookup_mitra_model->count_filtered_list_mitra($fid_lokasi_kerja),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}