<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_fisik extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_fisik_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_fisik(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
            $list = $this->lookup_fisik_model->get_datatables_list_fisik($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_fisik) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_fisik(\''.$list_fisik->id_fisik.'\', \''.$list_fisik->nomor_fisik.'\')" title="Detail \''.$list_fisik->nomor_fisik.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_fisik->nomor_fisik;
                  $row[] = $list_fisik->nama_desa;
                  $row[] = $list_fisik->nama_kecamatan;
                  $row[] = $list_fisik->nama_kabupaten;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_fisik_model->count_all_list_fisik($fid_lokasi_kerja),
                  "recordsFiltered" => $this->lookup_fisik_model->count_filtered_list_fisik($fid_lokasi_kerja),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}