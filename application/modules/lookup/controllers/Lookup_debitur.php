<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_debitur extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_debitur_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_debitur(){
            $unit = $_SESSION['fid_lokasi_kerja'];
			
			//$unit = $this->input->post('unit', TRUE);
            $mt = $this->input->post('mt', TRUE);
            //$wilayah = $this->input->post('wilayah', TRUE);
            //$rayon = $this->input->post('rayon', TRUE);
            $bulan = intval(date('m'));
            $tahun_ini = date("Y");
            if($mt == ""){
                  if ($bulan > 5){
                        $tahun_awal = date('Y');
                        $tahun_akhir = date('Y')+1;
                  }else {
                        $tahun_awal = date('Y')-1;
                        $tahun_akhir = date('Y');
                  }
            }else{
                  list($tahun_awal, $tahun_akhir) = explode('/', $mt);
            }

            $list = $this->lookup_debitur_model->get_datatables_list_debitur($unit, $tahun_awal, $tahun_akhir);
           // $list = $this->lookup_debitur_model->get_datatables_list_debitur($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_debitur) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_debitur(\''.$list_debitur->id_petani.'\', \''.$list_debitur->nama.'\', \''.$list_debitur->nilai_pk.'\', \''.$list_debitur->escrow_kebun.'\')" title="Detail \''.$list_debitur->nama.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_debitur->nama;
                  $row[] = $list_debitur->nik;
                  $row[] = $list_debitur->alamat;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_debitur_model->count_all_list_debitur($unit, $tahun_awal, $tahun_akhir),
                  "recordsFiltered" => $this->lookup_debitur_model->count_filtered_list_debitur($unit, $tahun_awal, $tahun_akhir),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}