<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('unit/unit_model');
		$this->load->model('karyawan/karyawan_model');
	}
	
	
	public function index()
	{
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'main'
				,'title' 		=> 	'Daftar user'
		);
		$this->load->view($data['content'],$data);
	}
	
	function filter()
	{
		$unit = $this->unit_model->get_list();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'filter'
				,'title' 		=> 	'Filter user'
				,'unit' 		=> 	$unit
		);
		$this->load->view($data['content'],$data);
	}
	
	
	
	function page($pg=1)
	{
		$limit = $this->input->post('row_per_page')?:10;
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
		
		$username = $this->input->post('t_username');
		
		$this->user_model->set_where($where);
		// binding data
		$this->user_model->set_limit($limit);
		$this->user_model->set_offset(($limit) * ($pg - 1));
		
		// filtering data
		$like = array();
		$like['username'] = $username;
		$this->user_model->set_like($like);
		
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->user_model->count() ;
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		//
		
		$data = array('user_list' => 	$this->user_model->get_list()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'user/list'
			,'paging'				=> 	$page
			// ,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);
		
		$this->load->view($data['content'],$data);
		
	}
	
	
	function input($fid_unit=0,$id=0)
	{
		$id = decode($id);
		$user = $this->user_model->get($id);
		$unit = $this->unit_model->get_list();
		$karyawan = $this->karyawan_model->get_list();

		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'user/input'
				,'title' 			 => $id?'Edit '.$user['username']:'Input Baru'
				,'user' 		 	 => $user
				,'unit' 			 => $unit
				,'karyawan'			 => $karyawan
		);
		
		$this->load->view($data['content'],$data);
	}

	function save()
	{
		// $id = decode($id)?:0;
		$this->db->trans_start();

		$fid_unit		= ($this->input->post('t_fid_unit'));
		$id_ms_operator	= ($this->input->post('t_id_ms_operator'));
		$id_karyawan	= ($this->input->post('t_id_karyawan'));
		$username		= ($this->input->post('t_username'));
		$password 		= ($this->input->post('t_password'));
		$jml_anak 		= ($this->input->post('t_no_anak'));
		$jml_induk 		= ($this->input->post('t_no_induk'));
	
		$nChar = strlen($password)+1;
		$cPassGen = $password;
		$x = 1; 
		while($x <= $nChar) 
		{
			$cPassGen = md5($cPassGen);
			$x++;
		} 

		$data = array();
		$data['fid_unit']	 		 = $fid_unit; 
		$data['id_ms_operator'] 	 = $id_ms_operator;
		$data['id_karyawan'] 		 = $id_karyawan;
		$data['username']			 = $username;
		$data['pwd']				 = $cPassGen;
		
		$save = $this->user_model->save($data);

		//delete hak akses
		if($id_ms_operator!=0){
			$query	= $this->user_model->delete_hak_akses($id_ms_operator);
		}
		
		//get id_ms_operator yg terakhir di insert
															
		$id_ms_operator = $this->user_model->getmax();
		
		//echo $id_ms_operator;
		//exit;
		
		
		//looping input hak akses 
		for($i = 0; $i < $jml_induk; $i++){
			$menu_induk = $this->input->post('menu_induk'.$i);			
			if (!empty($menu_induk)){
				$this->user_model->insert_hak_akses($id_ms_operator,$menu_induk,$fid_unit);
			}
		}
		
		for($j = 0; $j < $jml_anak; $j++){
			$menu_anak = $this->input->post('menu_anak'.$j);			
			if (!empty($menu_anak)){
				$this->user_model->insert_hak_akses($id_ms_operator,$menu_anak,$fid_unit);
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			
		}else{
			$this->update['id_ms_operator'] = encode($save);
			$this->success('Data user Berhasil Disimpan..');
			$this->db->trans_commit();
		}
		
		
	}
	
	function delete($id)
	{
		//$id = decode($id);
		$query1	= $this->user_model->delete($id);
		$query	= $this->user_model->delete_hak_akses($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	} 
	
	
}
/*
*Author: koco
*/

