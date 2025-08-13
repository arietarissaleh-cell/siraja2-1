<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_timeline extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_timeline_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_timeline(){
            $unit = $_SESSION['fid_lokasi_kerja'];
			
			//$unit = $this->input->post('unit', TRUE);
            $no_petak = $this->input->post('no_petak', TRUE);
            $luas_netto = $this->input->post('luas_netto', TRUE);
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

            $list = $this->lookup_timeline_model->get_datatables_list_kebun($no_petak,$unit, 2024,2025);
           // $list = $this->lookup_debitur_model->get_datatables_list_debitur($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_kebun) {
				
				if ($list_kebun->satuan == 'HA'){
				  $total = $luas_netto * $list_kebun->biaya_rencana;
				}else {
				 $total = $list_kebun->biaya_rencana;
				}
                  $no++;
                  $row = array();
                  $row[] = $list_kebun->kode_pekerjaan;
                  $row[] = $list_kebun->nama_pekerjaan;
                  
                  $row[] = $list_kebun->tanggal_rencana;
				  $row[] = $list_kebun->satuan;
                  $row[] = number_format($list_kebun->biaya_rencana,2);
                  $row[] = number_format($total,2);
                  
                 
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_timeline_model->count_all_list_kebun($no_petak,$unit, 2024,2025),
                  "recordsFiltered" => $this->lookup_timeline_model->count_filtered_list_kebun($no_petak,$unit, 2024,2025),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}