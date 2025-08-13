<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_atasan_tm extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('approve_atasan_tm_model');
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
		
		
		$this->approve_atasan_tm_model->set_where($where);
		// binding data
		$this->approve_atasan_tm_model->set_limit($limit);
		$this->approve_atasan_tm_model->set_offset(($limit) * ($pg - 1));
		
		
		// filtering data
		$like = array();
		//$like['nik'] = $nik;
		//$like['nama_depan'] = $nama;
		$this->approve_atasan_tm_model->set_like($like);
		
		
		//generate paging
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->approve_atasan_tm_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		
		$fid_lokasi_kerja = $this->session->userdata('fid_lokasi_kerja');
		$nik = $this->session->userdata('nik');
		
		$history = $this->db->query("SELECT * 
								, (case WHEN status = 0 THEN 'Baru'
									WHEN status = 1 THEN 'Approved'
									WHEN status = 2 THEN 'Technical Review'
									WHEN status = 3 THEN 'Task Preparation'
									WHEN status = 4 THEN 'In Progress'
									WHEN status = 5 THEN 'Completed'
									WHEN status = 6 THEN 'Completed'
									WHEN status = 7 THEN 'Penanganan Pihan ke 3'
									end) as st
								FROM dtl_task_manager 
								WHERE status not in ('0', '1') 
								and fid_unit = $fid_lokasi_kerja 
								and atasan = '$nik' order by id_tm DESC")->result();
		
		$data = array('karyawan_list' 	=> 	$this->approve_atasan_tm_model->get_list()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'approve_atasan_tm/list'
			
			,'history'				=> 	$history
			// ,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);
		
		$this->load->view($data['content'],$data);
		
	}
	
	public function ajax_list(){
            $unit = $this->input->post('unit', TRUE);
            $mt = $this->input->post('mt', TRUE);
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
           

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



            $list = $this->approve_atasan_tm_model->get_datatables($fid_lokasi_kerja,1);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $approve_atasan_tm_model) {
                  $edit = '
                  <a href="javascript:void(0);" onclick="inputData(\''.$approve_atasan_tm_model->id_tm.'\', \''.$approve_atasan_tm_model->fid_unit.'\')" title="Detail $approve_atasan_tm_model->kode_tm"><i class="fas fa-list"> Approve</i></a>';
                 

                  $no++;
                  $row = array();
                  $row[] = $no;
                 
                  $row[] = $approve_atasan_tm_model->kode_tm;
                 
                  $row[] = $approve_atasan_tm_model->tanggal;
                  
                  $row[] = $approve_atasan_tm_model->nama_depan;
                  $row[] = $approve_atasan_tm_model->katagori;
                  $row[] = $approve_atasan_tm_model->keterangan;
                  
                 
                
                  
                  $row[] = $edit;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->approve_atasan_tm_model->count_all($fid_lokasi_kerja,1),
                  "recordsFiltered" => $this->approve_atasan_tm_model->count_filtered($fid_lokasi_kerja,1),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	  
	  
	 public function ajax_list_hist(){
            $unit = $this->input->post('unit', TRUE);
            $mt = $this->input->post('mt', TRUE);
            $fid_lokasi_kerja = $_SESSION['fid_lokasi_kerja'];
            


     

            $list = $this->approve_atasan_tm_model->get_datatables($fid_lokasi_kerja,2);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $approve_atasan_tm_model) {
                  $edit = '
                  <a href="javascript:void(0);" onclick="inputData(\''.$approve_atasan_tm_model->id_tm.'\', \''.$approve_atasan_tm_model->fid_unit.'\')" title="Detail $approve_atasan_tm_model->kode_tm"><i class="fas fa-list"> Approve</i></a>';
                 

                  $no++;
                  $row = array();
                  $row[] = $no;
                 
                  $row[] = $approve_atasan_tm_model->kode_tm;
                 
                  $row[] = $approve_atasan_tm_model->tanggal;
                  
                  $row[] = $approve_atasan_tm_model->nama_depan;
                  $row[] = $approve_atasan_tm_model->katagori;
                  $row[] = $approve_atasan_tm_model->keterangan;
                  $row[] = $approve_atasan_tm_model->atasan_approve_date;
                  
                 
                
                  
                  $row[] = $edit;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->approve_atasan_tm_model->count_all($fid_lokasi_kerja,2),
                  "recordsFiltered" => $this->approve_atasan_tm_model->count_filtered($fid_lokasi_kerja,2),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	
	
	function detail($id)
	{
		
		$data_tm = $this->approve_atasan_tm_model->getDetail($id);
		$nik=$this->session->userdata('nik');
		
		
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
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'approve_atasan_tm/detail'
				,'title' 			 => 'Detail '.$data_tm['kode_tm']
				
				,'data_tm'			 => $data_tm
		);
		
		$this->load->view($data['content'],$data);
	}

	
	
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->approve_atasan_tm_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
	
	function input($id, $unit)
	{
		
		$data_tm = $this->approve_atasan_tm_model->getDetail($id);
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
		,'content' 			 => 'approve_atasan_tm/input'
		,'title' 			 => $nama_depan?'Edit '.$nama_depan:'Input Data'
		
		,'nama_depan' 		 => $nama_depan
		,'id_ms_operator' 	 => $id_ms_operator
		,'atasan' 			 => $atasan
		,'fid_unit' 		 => $fid_unit
		,'nik_karyawan' 	 => $nik_karyawan
		,'nik_atasan' 	 	 => $nik_atasan
		,'data_tm' 	 	 => $data_tm
		
		
		
		
		
		);
		
		$this->load->view($data['content'],$data);
	}
	
	
	function save()
	{
		
		$this->db->trans_start();
		//$detail_data = $this->approve_atasan_tm_model->getDetail($id);
		
		$fid_lokasi_kerja					= $this->session->userdata('fid_lokasi_kerja');
		$id_tm								= ($this->input->post('id_tm'));
		$catatan_atasan							= ($this->input->post('catatan_atasan'));
		$tanggal							= date('Y-m-d H:i:s');
		$update = $this->db->query("UPDATE dtl_task_manager SET catatan_atasan = '$catatan_atasan', atasan_approve_date = '$tanggal', status = 2 WHERE id_tm = '$id_tm'");
		$send_wa = $this->approve_atasan_tm_model->post_wa_persetujuan_kabag($id_tm);
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
	
	function revisi()
	{
		
		$this->db->trans_start();
		//$detail_data = $this->approve_atasan_tm_model->getDetail($id);
		
		$fid_lokasi_kerja					= $this->session->userdata('fid_lokasi_kerja');
		$id_tm								= ($this->input->post('id_tm'));
		$catatan_atasan							= ($this->input->post('catatan_atasan'));
		$tanggal							= date('Y-m-d H:i:s');
		$update = $this->db->query("UPDATE dtl_task_manager SET revisi_atasan = '$catatan_atasan', tgl_revisi = '$tanggal', status = 0 WHERE id_tm = '$id_tm'");
		
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

