<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perlu_tl extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('perlu_tl_model');
		$this->load->model('approve_atasan_tm/approve_atasan_tm_model');
		$this->load->library('wa');
	}
	
	
	public function index()
	{
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'main'
				,'title' 		=> 	'Daftar Karyawan'
		);
		$this->load->view($data['content'],$data);
	}
	
	function filter()
	{
		$unit = $this->unit_model->get_list();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'filter'
				,'title' 		=> 	'Filter Karyawan'
				,'unit' 		=> 	$unit
		);
		$this->load->view($data['content'],$data);
	}
	
	
	
	function page($pg=1)
	{
		$limit = $this->input->post('row_per_page')?:20;
		$where=array();
		$where_unit = '';
		
		$modul['unit'] = ($this->input->post('t_unit'));
		
		if($modul['unit'][0]){
			$i=0;
			
			$where_unit .= '(';
			foreach ($modul['unit'] as $selectedOption)
			{	
				$i++;
				$modul_array[$selectedOption] = $selectedOption;
				
				if($i > 1){
					$where_unit .=" OR ";
				}
				
				$where_unit .="tbl.\"fid_unit\" = '$modul_array[$selectedOption]'";
			}
			
			$where_unit .=')';
			if($modul_array[$selectedOption]=='all'){
				
			}else{
				$where["$where_unit"] = NULL;
			}
		}
		
		$nik = $this->input->post('t_nik');
		$nama = $this->input->post('t_nama');
		
		
		$this->perlu_tl_model->set_where($where);
		// binding data
		$this->perlu_tl_model->set_limit($limit);
		$this->perlu_tl_model->set_offset(($limit) * ($pg - 1));
		
		
		// filtering data
		$like = array();
		//$like['nik'] = $nik;
		//$like['nama_depan'] = $nama;
		$this->perlu_tl_model->set_like($like);
		
		
		//generate paging
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->perlu_tl_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		
		$fid_lokasi_kerja = $this->session->userdata('fid_lokasi_kerja');
		$nik = $this->session->userdata('nik');
		$history = $this->db->query("SELECT tbl.* , kry.nama_depan as nama_pembuat, kry_pic.nama_depan as nama_pic
								, (case WHEN tbl.status = 0 THEN 'Baru'
									WHEN tbl.status = 1 THEN 'Approved'
									WHEN tbl.status = 2 THEN 'Technical Review'
									WHEN tbl.status = 3 THEN 'Task Preparation'
									WHEN tbl.status = 4 THEN 'In Progress'
									WHEN tbl.status = 5 THEN 'Completed'
									WHEN tbl.status = 6 THEN 'Completed'
									WHEN tbl.status = 7 THEN 'Penanganan Pihan ke 3'
									end) as st
								FROM dtl_task_manager tbl
								
								left join mst_karyawan_sdm kry 
								on kry.nik = tbl.pembuat
								left join mst_karyawan_sdm kry_pic 
								on kry_pic.nik = tbl.pic
								WHERE tbl.status not in ('0', '1', '2') 
								and tbl.fid_unit = $fid_lokasi_kerja 
								and tbl.pic = '$nik' order by tbl.id_tm DESC")->result();
		
		
		$data = array('karyawan_list' 	=> 	$this->perlu_tl_model->get_list()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'perlu_tl/list'
			
			,'paging'				=> 	$page
			,'history'				=> 	$history
			// ,'content_type'		=> 	$content_type
			,'key'				=>  $like
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


           /*  if($mt == ""){
                  if ($bulan > 5){
                       // $tahun_awal = date('Y');
                        //$tahun_akhir = date('Y')+1;
						$tahun_awal = 2022;
                        $tahun_akhir = 2023;
                  }else {
                        $tahun_awal = date('Y')-1;
                        $tahun_akhir = date('Y');
                  }
            }else{
                  list($tahun_awal, $tahun_akhir) = explode('/', $mt);
            } */



            $list = $this->perlu_tl_model->get_datatables($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $perlu_tl_model) {
                  $edit = '
                  <a href="javascript:void(0);" onclick="inputData(\''.$perlu_tl_model->id_tm.'\', \''.$perlu_tl_model->fid_unit.'\')" title="Detail $perlu_tl_model->kode_tm"><i class="fas fa-list"> Detail</i></a>';
                 
				
				  
				  
                  $no++;
                  $row = array();
                  $row[] = $no;
                 
                  $row[] = $perlu_tl_model->kode_tm;
                 
                  $row[] = $perlu_tl_model->create_date;
                  
                  $row[] = $perlu_tl_model->pembuat;
                  $row[] = $perlu_tl_model->keterangan;
                  
                
                  
                  $row[] = $edit;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->perlu_tl_model->count_all($fid_lokasi_kerja),
                  "recordsFiltered" => $this->perlu_tl_model->count_filtered($fid_lokasi_kerja),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	
	
	function detail($id)
	{
		$data_tm = $this->approve_atasan_tm_model->getDetail($id);
		
		
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'perlu_tl/detail'
				,'title' 			 => 'Detail '.$data_tm['kode_tm']
				
				,'data_tm'			 => $data_tm
		);
		
		$this->load->view($data['content'],$data);
	}

	
	
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->perlu_tl_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
	
	function input($id=0)
	{
		
		$data_tm = $this->perlu_tl_model->getDetail($id);
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$nik=$this->session->userdata('nik');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query("SELECT tbl.nik, kry.kode_jabatan, kry.fid_lokasi_kerja, kry.nama_depan  FROM public.ms_operator_sdm tbl
											   LEFT JOIN public.mst_karyawan_sdm kry
											   ON tbl.nik = kry.nik
											  
											   WHERE tbl.nik='$nik'
											   LIMIT 1");
		$row_unit 		= $query_unit->row_array(); 
		$nama_depan 	= $row_unit['nama_depan']; 
		$nik_karyawan	= $row_unit['nik']; 
		$kode_jabatan 	= $row_unit['kode_jabatan']; 
		$fid_unit 		= $row_unit['fid_lokasi_kerja']; 
		
		$query_atasan 	= $this->db->query("SELECT tbl.nik_kode_surat, tbl.nama_pejabat_kode_surat, tbl.nama_jabatan  FROM public.mst_kodesurat_jabatan_dms tbl
											   
											   WHERE tbl.kode_penerima_disposisi LIKE '%$kode_jabatan%'
											   LIMIT 1");
		$row_atasan 	= $query_atasan->row_array(); 
		$atasan 		= $row_atasan['nama_pejabat_kode_surat']; 
		$nik_atasan 	= $row_atasan['nik_kode_surat']; 
		 
		
		
		//$fid_unit=$this->session->userdata('fid_unit');
		
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('nik')
		,'content' 			 => 'perlu_tl/input'
		,'title' 			 => $nama_depan?'Edit '.$nama_depan:'Input Data'
		
		,'nama_depan' 		 => $nama_depan
		,'id_ms_operator' 	 => $id_ms_operator
		,'atasan' 			 => $atasan
		,'fid_unit' 		 => $fid_unit
		,'nik_karyawan' 	 => $nik_karyawan
		,'nik_atasan' 	 	 => $nik_atasan
		,'data_tm' 	 	 	 => $data_tm
		
		
		
		
		);
		
		$this->load->view($data['content'],$data);
	}
	
	
	function done()
	{
		
		$this->db->trans_start();
		//$detail_data = $this->perlu_tl_model->getDetail($id);
		
		$fid_lokasi_kerja					= $this->session->userdata('fid_lokasi_kerja');
		$id_tm								= ($this->input->post('id_tm'));
		$catatan_tl							= ($this->input->post('catatan_tl'));
		$tanggal							= date('Y-m-d H:i:s');
		
		
		
		$update = $this->db->query("UPDATE dtl_task_manager SET catatan_tl = '$catatan_tl', tgl_selesai = '$tanggal', status = 5 WHERE id_tm = '$id_tm'");
		$send_wa = $this->perlu_tl_model->post_wa_done($id_tm);
		
		$result = array();
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			$result['sukses'] = 0;
			echo json_encode($result);
			
		}else{
			$result['sukses'] = 1;
			//$this->update['id_tm'] = ($save);
			$result['success_upload'] = 1;
				$result['upload'] = 'File Successfully Uploaded';
				
				$result['pesan'] = 'Berhasil Terkirim';
			$this->db->trans_commit();
			
			echo json_encode($result); 
			//redirect($this->uri->uri_string());
		}
			
		
		
	}
	
	function proses()
	{
		
		$this->db->trans_start();
		//$detail_data = $this->perlu_tl_model->getDetail($id);
		
		$fid_lokasi_kerja					= $this->session->userdata('fid_lokasi_kerja');
		$id_tm								= ($this->input->post('id_tm'));
		$catatan_tl							= ($this->input->post('catatan_tl'));
		$toko								= ($this->input->post('toko'));
		$tgl_pickup							= ($this->input->post('tgl_pickup'));
		$estimasi_selesai					= ($this->input->post('estimasi_selesai'));
		//$tanggal							= date('Y-m-d H:i:s');
		
		
		
		$update = $this->db->query("UPDATE dtl_task_manager SET catatan_tl = '$catatan_tl', toko = '$toko', tgl_pickup = '$tgl_pickup', estimasi_selesai = '$estimasi_selesai', status = 4 WHERE id_tm = '$id_tm'");
		$send_wa = $this->perlu_tl_model->post_wa_proses($id_tm);
		
		$result = array();
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			$result['sukses'] = 0;
			echo json_encode($result);
			
		}else{
			$result['sukses'] = 1;
			//$this->update['id_tm'] = ($save);
			$result['success_upload'] = 1;
				$result['upload'] = 'File Successfully Uploaded';
				
				$result['pesan'] = 'Berhasil Terkirim';
			$this->db->trans_commit();
			
			echo json_encode($result); 
			//redirect($this->uri->uri_string());
		}
			
		
		
	}
	
	
}
/*
*Author: Upray
*/

