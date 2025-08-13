<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kebun extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/kebun_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_kebun(){
            $unit = $this->input->post('unit', TRUE);
            $mt = $this->input->post('mt', TRUE);
            $wilayah = $this->input->post('wilayah', TRUE);
            $rayon = $this->input->post('rayon', TRUE);
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

            $list = $this->kebun_model->get_datatables_list_kebun($unit, $tahun_awal, $tahun_akhir, $wilayah, $rayon);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_kebun) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_kebun(\''.$list_kebun->fid_unit.'\', \''.$list_kebun->no_petak.'\', \''.$list_kebun->kode_kebun.'\', \''.$list_kebun->tahun_tanam_awal.'\', \''.$list_kebun->tahun_tanam_akhir.'\')" title="Detail \''.$list_kebun->nama_kebun.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_kebun->masatanam;
                  $row[] = $list_kebun->no_petak;
                  $row[] = $list_kebun->kode_kebun;
                  $row[] = $list_kebun->nama_kebun;
                  $row[] = $list_kebun->nama_pemilik;
                  $row[] = $list_kebun->nama_debitur;
                  $row[] = $list_kebun->nama_mitra;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->kebun_model->count_all_list_kebun($unit, $tahun_awal, $tahun_akhir, $wilayah, $rayon),
                  "recordsFiltered" => $this->kebun_model->count_filtered_list_kebun($unit, $tahun_awal, $tahun_akhir, $wilayah, $rayon),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}