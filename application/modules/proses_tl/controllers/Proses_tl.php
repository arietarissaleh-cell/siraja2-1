<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proses_tl extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('proses_tl_model');
		$this->load->model('perlu_tl/perlu_tl_model');
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
		
		
		$this->proses_tl_model->set_where($where);
		// binding data
		$this->proses_tl_model->set_limit($limit);
		$this->proses_tl_model->set_offset(($limit) * ($pg - 1));
		
		
		// filtering data
		$like = array();
		//$like['nik'] = $nik;
		//$like['nama_depan'] = $nama;
		$this->proses_tl_model->set_like($like);
		
		
		//generate paging
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->proses_tl_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		
		
		$data = array('karyawan_list' 	=> 	$this->proses_tl_model->get_list()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'proses_tl/list'
			
			,'paging'				=> 	$page
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



            $list = $this->proses_tl_model->get_datatables($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $proses_tl_model) {
                  $edit = '
                  <a href="javascript:void(0);" onclick="inputData(\''.$proses_tl_model->id_tm.'\', \''.$proses_tl_model->fid_unit.'\')" title="Detail $proses_tl_model->kode_tm"><i class="fas fa-list"> Detail</i></a>';
                 
				  
				  
				   if ($proses_tl_model->status == 1){
						$status = '<span class="badge badge-soft-dark">Di Buat</span>';
				  }else if ($proses_tl_model->status == 2){
					  $status = '<span class="badge bg-primary">Approve Atasan</span>';
				  }else if ($proses_tl_model->status == 3){
					  $status = '<span class="badge bg-info">Approve Kabag IT</span>';
				  }else if ($proses_tl_model->status == 4){
					  $status = '<span class="badge bg-warning">Sedang di TL</span>';
				  }else if ($proses_tl_model->status == 5){
					  $status = '<span class="badge bg-success">Selesai</span>';
				  }else if ($proses_tl_model->status == 0){
					  $status = '<span class="badge bg-danger">Revisi</span>';
				  }else if ($proses_tl_model->status == 7){
					  $status = '<span class="badge bg-danger">Proses Pihak ke 3</span>';
				  }
				  
				  
                  $no++;
                  $row = array();
                  $row[] = $no;
                 
                  $row[] = $proses_tl_model->kode_tm;
                 
                  $row[] = $proses_tl_model->create_date;
                  
                  $row[] = $proses_tl_model->pembuat;
                  $row[] = $proses_tl_model->keterangan;
                  
                 
                  
                  $row[] = $edit;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->proses_tl_model->count_all($fid_lokasi_kerja),
                  "recordsFiltered" => $this->proses_tl_model->count_filtered($fid_lokasi_kerja),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	
	
	function detail($fid_unit=0,$id=0)
	{
		$id = decode($id);
		$karyawan = $this->proses_tl_model->get($id);
		$detail_data = $this->proses_tl_model->getDetail($id);
		
		
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'karyawan/detail'
				,'title' 			 => $id?'Detail '.$karyawan['nama_depan']:'Input Baru'
				,'karyawan' 		 => $karyawan
				,'detail_data'		 => $detail_data
		);
		
		$this->load->view($data['content'],$data);
	}

	
	
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->proses_tl_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
	
	function input($id=0)
	{
		
		$data_tm = $this->proses_tl_model->getDetail($id);
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
		,'content' 			 => 'proses_tl/input'
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
	
	
	function save()
	{
		
		$this->db->trans_start();
		//$detail_data = $this->proses_tl_model->getDetail($id);
		
		$fid_lokasi_kerja					= $this->session->userdata('fid_lokasi_kerja');
		$id_tm								= ($this->input->post('id_tm'));
		$catatan_toko						= ($this->input->post('catatan_toko'));
		$tanggal							= ($this->input->post('tanggal_selesai'));
		
		$config['upload_path'] = '/var/www/html/siraja/doc_tm/';
		$config['allowed_types']='pdf';
        $config['encrypt_name'] = FALSE;
		$config['max_size']             = 1000000;
		//panggil library
        $this->load->library('upload',$config);
		
		//echo $this->db->last_query();
		//exit;
		$this->upload->initialize($config);
		
		$nama_file_ktp = $_FILES['lampiran']['name'];
		$this->upload->do_upload('lampiran');
		$data_rz = $this->upload->data();
		$config['source_image']=$config['upload_path'].$data_rz['file_name'];
		$nama_file = $data_rz['file_name'];
		
		
		
		$update = $this->db->query("UPDATE dtl_task_manager SET catatan_toko = '$catatan_toko', tgl_selesai = '$tanggal', status = 5, lampiran_tl ='$nama_file' WHERE id_tm = '$id_tm'");
		
		$send_wa = $this->perlu_tl_model->post_wa_done($id_tm);
		
		
		
		
		///$query2	= $this->kredit_model->status($fid_ms_operator,$st_tahap);
		
        		// echo $this->db->last_query();
		//exit;
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

