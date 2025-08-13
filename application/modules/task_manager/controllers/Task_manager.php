<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task_manager extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('task_manager_model');
		$this->load->model('approve_atasan_tm/approve_atasan_tm_model');
		$this->load->model('approve_it_tm/approve_it_tm_model');
		$this->load->model('perlu_tl/perlu_tl_model');
		$this->load->model('proses_tl/proses_tl_model');
		
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
		
		
		$this->task_manager_model->set_where($where);
		// binding data
		$this->task_manager_model->set_limit($limit);
		$this->task_manager_model->set_offset(($limit) * ($pg - 1));
		
		
		// filtering data
		$like = array();
		$like['nik'] = $nik;
		$like['nama_depan'] = $nama;
		$this->task_manager_model->set_like($like);
		
		
		//generate paging
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->task_manager_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		
		$app_atasan = $this->approve_atasan_tm_model->count();
		$app_it = $this->approve_it_tm_model->count();
		$perlu_tl = $this->perlu_tl_model->count();
		$proses_tl = $this->proses_tl_model->count();
		
		$data = array('karyawan_list' 	=> 	$this->task_manager_model->get_list()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'task_manager/list'
			
			,'paging'				=> 	$page
			,'app_atasan'			=> 	$app_atasan
			,'app_it'				=> 	$app_it
			,'perlu_tl'				=> 	$perlu_tl
			,'proses_tl'			=> 	$proses_tl
			// ,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);
		
		$this->load->view($data['content'],$data);
		
	}
	
	
	function detail($fid_unit=0,$id=0)
	{
		$id = decode($id);
		$karyawan = $this->task_manager_model->get($id);
		$detail_data = $this->task_manager_model->getDetail($id);
		
		
		
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
		$query	= $this->task_manager_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
	
	
}
/*
*Author: Tomi
*/

