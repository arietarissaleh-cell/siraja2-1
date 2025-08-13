<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Validasi extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('validasi_model');
		$this->load->model('penanganan/penyakit_tebu_model');
		$this->load->model('penanganan/komentar_kebun_model');
		$this->load->model('data_drone/data_drone_model'); 
		$this->load->model('drone_slide_model');
		//$this->load->model('drone_slide/detail_tebu_tanam_model');
		$this->load->library('wa');
	}
	
	
	public function index()
	{
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'main'
				,'title' 		=> 	'Jadwal Terbang'
		);
		$this->load->view($data['content'],$data);
	}
	
	function filter()
	{
		$unit = $this->unit_model->get_list();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'filter'
				,'title' 		=> 	'Filter disposisi'
				,'unit' 		=> 	$unit
		);
		$this->load->view($data['content'],$data);
	}
	
	
	
	function page($pg=1){
            $id_lok = $_SESSION['fid_lokasi_kerja'];
            if ($id_lok == "11") {
                  $fid_lokasi_kerja = "in (15, 17, 18)";
            }else{
                  $fid_lokasi_kerja = "in (".$id_lok.")";
            }

            $currentYear = date('Y');
            $options = array();

            for ($i = 0; $i < 3; $i++) {
                  $startYear = $currentYear - $i;
                  $endYear = $startYear + 1;
                  $season = $startYear . '/' . $endYear;
                  $options[] = $season;
            }

            $unit = $this->db->query("SELECT * FROM mst_unit WHERE id_unit $fid_lokasi_kerja")->result();

            $data = array(
                  'masa_tanam' => $options,
                  'data_unit' => $unit,
                  'content'  => 'validasi/list',
                  'title'    => 'List Kebun',
                  'lokasi_kerja' => $id_lok

            );
            $this->load->view($data['content'],$data);
      }
	  
	  public function ajax_list(){
            $unit = $this->input->post('unit', TRUE);
            $mt = $this->input->post('mt', TRUE);
            $id_lok = $_SESSION['fid_lokasi_kerja'];
            if($unit == ""){
                  if ($id_lok == "11") {
                        $fid_lokasi_kerja = "in (15, 17, 18)";
                  }else{
                        $fid_lokasi_kerja = "in (".$id_lok.")";
                  }
            }else{
                  $id = implode(', ', $unit);
                  $fid_lokasi_kerja = "in (".$id.")";
            }

            $bulan = date('m');
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



            $list = $this->drone_slide_model->get_datatables($fid_lokasi_kerja, $tahun_awal, $tahun_akhir);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $drone_slide_model) {
                  $edit = '
                  <a href="javascript:void(0);" onclick="detail(\''.$drone_slide_model->tanggal_foto.'\')" title="Detail $drone_slide_model->tanggal_foto"><i class="fas fa-edit"> Detail</i></a>
                  ';
				  
				  if ($drone_slide_model->st_validasi == 0){
					  $status = 'Belum Validasi'; 
				  }else{
					  $status = 'Sudah Validasi';
				  }
                  
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $drone_slide_model->tanggal_foto;
                  $row[] = $drone_slide_model->jumlah_foto;
                  $row[] = $status;
                 
                  $row[] = $edit;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->drone_slide_model->count_all($fid_lokasi_kerja, $tahun_awal, $tahun_akhir),
                  "recordsFiltered" => $this->drone_slide_model->count_filtered($fid_lokasi_kerja, $tahun_awal, $tahun_akhir),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	
	function detail($tanggal)
	{
		
		
		$foto				        = $this->data_drone_model->detail_foto($tanggal);
		$drone = $this->db->query("SELECT id_drone, fid_unit, kode_rayon_ecadong, kode_wilayah_ecadong,
	nama_unit,no_petak, nama_kebun, foto, status_kualitas, st_validasi,
	CASE 
        WHEN st_validasi = 0 THEN 'Belum Validasi'
        WHEN st_validasi = 1 THEN 'Validasi IT'
        WHEN st_validasi = 2 THEN 'Validasi Tanaman'
       
		ELSE NULL
    END AS status,
	CASE 
        WHEN status_kualitas = 1 THEN 'Baik'
        WHEN status_kualitas = 2 THEN 'Sedang'
        WHEN status_kualitas = 3 THEN 'Kurang'
        WHEN status_kualitas = 4 THEN 'Potensi'
       
		ELSE NULL
    END AS status_kerapatan
	
		
	FROM
	dtl_foto_drone 
					WHERE
					
					 tanggal_foto = '$tanggal'
					AND st_validasi = 0
	ORDER BY id_drone DESC
            ")->result_array();
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('username')
				,'content' 			 => 'validasi/detail'
				,'title' 			 => 'LIST FOTO DRONE untuk di VALIDASI'
				,'drone' 			 => $drone
				,'tanggal' 			 => $tanggal
				
				
				
				
		);
		
		$this->load->view($data['content'],$data);		
	}
	
	function get_by_id(){
		$id = $_POST['id'];
		
		$q = $this->db->query("SELECT * FROM dtl_foto_drone WHERE id_drone = '$id'")->result();
		echo json_encode($q);
	}
	
	
	function update_status(){

		$this->db->trans_start();


        $id_drone						= ($this->input->post('t_id_drone'));
        $status_kualitas				= ($this->input->post('status_kerapatan'));
        
        $keterangan						= ($this->input->post('t_keterangan'));

        $create_by						= $this->session->userdata('username'); 
		
		$update							= $this->validasi_model->update_status($id_drone,$status_kualitas,$keterangan);
		//echo $this->db->last_query();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			
		}else{
			//$this->update['id_ms_sps'] = encode($save);
			
			//$this->toastr["success"]("Inconceivable!");
			$this->success('Approve SPS Berhasil..');
			$this->db->trans_commit();
		}
	}
	
	function approve(){
		$this->db->trans_start();

		
		$tanggal					= ($this->input->post('t_tanggal'));
		//$tanggal = str_replace("_","-",$tgl);
		//var_dump ($tanggal);
		//echo $tanggal;
		$update							= $this->validasi_model->update_all($tanggal);
		$send_wa_kabid					= $this->validasi_model->post_wa_kabid($tanggal);
		$send_wa_ca						= $this->validasi_model->post_wa_ca($tanggal);
		$send_wa_skk					= $this->validasi_model->post_wa_skk($tanggal);
		$send_wa_skw					= $this->validasi_model->post_wa_skw($tanggal);
		//echo $this->db->last_query();
		
		$result = array();
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$result['sukses']= 0;
			$result['pesan'] = 'Gagal Approve';
		}else{
						  //$this->success('Penjualan Surat..');
			$this->db->trans_commit();
			$result['sukses']= 1;
			$result['pesan'] = 'Approve Berhasil';
		}
		echo json_encode($result);
	}

	
	
	
	
}
/*
*Author: 
*/


