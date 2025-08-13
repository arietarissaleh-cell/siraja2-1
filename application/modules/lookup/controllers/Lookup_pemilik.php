<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_pemilik extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_pemilik_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_pemilik(){
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
            $list = $this->lookup_pemilik_model->get_datatables_list_pemilik($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_pemilik) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_pemilik(\''.$list_pemilik->id_petani.'\', \''.$list_pemilik->nama.'\')" title="Detail \''.$list_pemilik->nama.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_pemilik->nama;
                  $row[] = $list_pemilik->nik;
                  $row[] = $list_pemilik->alamat;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_pemilik_model->count_all_list_pemilik($fid_lokasi_kerja),
                  "recordsFiltered" => $this->lookup_pemilik_model->count_filtered_list_pemilik($fid_lokasi_kerja),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}