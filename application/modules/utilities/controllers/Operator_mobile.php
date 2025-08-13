<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator_mobile extends MY_Controller {

	//var $table = 'mst_item';
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('operator_mobile_model');
		$this->load->model('unit/unit_model');
		$this->load->model('karyawan/karyawan_model');
		//$this->load->model('operator_menus_model');
		//$this->load->model('operator_priv_model');
		//$this->load->model('modul_user_model');
		//$this->load->model('modul_priv_model');
		
	}
	
	
	public function index()
	{
		//$this->page();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'utilities/operator_mobile/main'
				,'title' 		=> 	'Daftar Operator Mobile'
		);
		$this->load->view($data['content'],$data);
	}
	
	/* function filter()
	{
		//$this->page();
		$data = array('content' => 	'utilities/operator/filter'
		);
		$this->load->view($data['content'],$data);
	} */
	
	
	function filter()
	{
		$unit = $this->unit_model->get_list();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'operator_mobile/filter'
				,'title' 		=> 	'Filter Cuti'
				,'unit' 		=> 	$unit
		);
		$this->load->view($data['content'],$data);
	}
	
	function page($pg=1)
	{
		$content_type = $this->input->post('content_type');
		$username = $this->input->post('t_username');
		$limit = $this->input->post('row_per_page')?:10;
		// binding data
		$this->operator_mobile_model->set_limit($limit);
		$this->operator_mobile_model->set_offset(($limit) * ($pg - 1));
		// filtering data
		$like = array();
		$like['username'] = $username;
		$this->operator_mobile_model->set_like($like);
		//
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->operator_mobile_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		//
		$data = array('operator_mobile_list' 	=> 	$this->operator_mobile_model->get_list_unit()
			,'name' 			=> 	$this->session->userdata('name')
			,'content' 			=> 	'utilities/operator_mobile/list'
			,'paging'			=> 	$page
			,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);

		$this->load->view($data['content'],$data);
	}
	
	
	function input($id=0)
	{
		$id = decode($id);
		$operator = $this->operator_mobile_model->get($id);
		$unit = $this->unit_model->get_list();
		$karyawan = $this->karyawan_model->get_list();
		//$this->page();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'utilities/operator_mobile/input'
				,'title' 		=> 	$id?'Edit '.$operator['username']:'Input Baru'
				,'operator' 	=> 	$operator
				,'unit' 		=> 	$unit
				,'karyawan'		=>  $karyawan
		);
		$this->load->view($data['content'],$data);
	}
	
	function save()
	{
		// $id = decode($id)?:0;
		$this->db->trans_start();
		$id_operator	= decode($this->input->post('t_id_ms_operator'));
		$username	= ($this->input->post('t_username'));
		$fid_unit	= ($this->input->post('t_fid_unit'));
		$operator = $this->operator_mobile_model->get(array('username' => $username));
		$pwd1	= $this->input->post('t_password');
		$pwd2	= $this->input->post('t_password2');
		$id_karyawan = $this->input->post('t_id_karyawan');
		
		if($pwd1 <> $pwd2){
			$this->error('Password tidak sama');
		}
		if($operator['username']){
			$this->error('Username sudah ada');
		}
		$data = array();
		$nChar = strlen($pwd1)+1;
		$cPassGen = $pwd1;
		$x = 1; 
		while($x <= $nChar) 
		{
			$cPassGen = md5($cPassGen);
			$x++;
		} 
		
		$data['id_ms_operator']	= $id_operator;
		$data['username']		= $username;
		$data['fid_unit']		= $fid_unit;
		$data['id_karyawan']	= $id_karyawan;
		
		if($pwd1){
			$data['pwd']			= $cPassGen;
		}
		$data['expiry_date']	= getSQLDate($this->input->post('t_expired_date'));
		$data['last_update']	= date('Ymd');
		// echo print_r($data);
		$save = $this->operator_mobile_model->save($data);
        // echo $this->db->last_query();
		// exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			
		}else{
			$this->update['id_ms_operator'] 		= encode($save);
			$this->success('Data berhasil disimpan..');
			$this->db->trans_commit();
		}
	}
	
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->operator_mobile_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
}
/*
*Author: Hariyo Koco
*Author URL: 
28052016
*/


