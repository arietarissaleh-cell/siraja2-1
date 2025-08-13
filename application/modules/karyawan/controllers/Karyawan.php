<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('karyawan_model');
		$this->load->model('jabatan/jabatan_model');
		$this->load->model('unit/unit_model');
		$this->load->model('jenis_karyawan/jenis_karyawan_model');
		$this->load->model('golongan_karyawan/golongan_karyawan_model');
		//$this->load->model('bidang/bidang_model');
		//$this->load->model('bagian/bagian_model');
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
		
		
		$this->karyawan_model->set_where($where);
		// binding data
		$this->karyawan_model->set_limit($limit);
		$this->karyawan_model->set_offset(($limit) * ($pg - 1));
		
		
		// filtering data
		$like = array();
		$like['nik'] = $nik;
		$like['nama_depan'] = $nama;
		$this->karyawan_model->set_like($like);
		
		
		//generate paging
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->karyawan_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		
		
		$data = array('karyawan_list' 	=> 	$this->karyawan_model->get_list_unit()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'karyawan/list'
			,'paging'				=> 	$page
			// ,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);
		
		$this->load->view($data['content'],$data);
		
	}
	
	
	function input($fid_unit=0,$id=0)
	{
		$unit_usaha = $this->session->userdata('fid_unit');
		$id = decode($id);
		$karyawan = $this->karyawan_model->get($id);
		//$unit = $this->unit_model->get_list();
		$unit = $this->unit_model->get_list_unit();
		$jabatan = $this->jabatan_model->get_list();
		$jenis_karyawan = $this->jenis_karyawan_model->get_list();
		$golongan_karyawan = $this->golongan_karyawan_model->get_list_dropdown();
		//$bidang = $this->bidang_model->get_list_dropdown();
		$bidang = $this->bidang_model->get_list_dropdown_unit();
		//$bagian = $this->bagian_model->get_list_dropdown();
		$bagian = $this->bagian_model->get_list_dropdown_unit();
		
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'karyawan/input'
				,'title' 			 => $id?'Edit '.$karyawan['nama_depan']:'Input Baru'
				,'karyawan' 		 => $karyawan
				,'unit' 			 => $unit
				,'jabatan'			 => $jabatan
				,'jenis_karyawan'	 => $jenis_karyawan
				,'golongan_karyawan' => $golongan_karyawan
				,'bidang'			 => $bidang
				,'bagian'			 => $bagian	
		);
		
		$this->load->view($data['content'],$data);
	}
	
	function detail($fid_unit=0,$id=0)
	{
		$id = decode($id);
		$karyawan = $this->karyawan_model->get($id);
		$detail_data = $this->karyawan_model->getDetail($id);
		
		
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'karyawan/detail'
				,'title' 			 => $id?'Detail '.$karyawan['nama_depan']:'Input Baru'
				,'karyawan' 		 => $karyawan
				,'detail_data'		 => $detail_data
		);
		
		$this->load->view($data['content'],$data);
	}

	function save()
	{
		// $id = decode($id)?:0;
		$this->db->trans_start();
		
		$fid_unit		= ($this->input->post('t_fid_unit'));
		$id_karyawan	= decode($this->input->post('t_id_karyawan'));
		$nik			= ($this->input->post('t_nik'));
		$nama_depan		= ($this->input->post('t_nama_depan'));
		$nama_belakang	= ($this->input->post('t_nama_belakang'));
		$gender			= ($this->input->post('t_gender'));
		$jabatan		= ($this->input->post('t_jabatan'));
		$golongan		= ($this->input->post('t_golongan'));
		$bidang			= ($this->input->post('t_bidang'));
		$bagian			= ($this->input->post('t_bagian'));
		$email			= ($this->input->post('t_email'));
		
		$pk_serial=intval($fid_unit.''.$nik);
		
		//$karyawan = $this->karyawan_model->get(array('nama_depan' => $nama_depan));
		
		//if($operator['karyawan']){
		//	$this->error('karyawan sudah ada');
		//}
		
		//echo $fid_unit;
		//die;
		
		$data = array();
		$data['fid_unit']	 	= $fid_unit; 
		$data['id_karyawan'] 	= $id_karyawan;
		$data['nik']		 	= $nik; 
		$data['nama_depan']		= $nama_depan;
		$data['nama_belakang']	= $nama_belakang;
		$data['gender']			= $gender;
		$data['id_jabatan']	    = $jabatan;
		$data['id_golongan_karyawan']	= $golongan;
		$data['tanggal_diangkat']	= getSQLDate($this->input->post('t_tanggal_diangkat'));
		$data['id_bidang']	    = $bidang;
		$data['id_bagian']	    = $bagian;
		$data['email']	 	    = $email;
		//$data['pk_serial']		= $pk_serial;
		
		//echo print_r($data);
		//die;
		
		$save = $this->karyawan_model->save($data);
        
		//echo $this->db->last_query();
		//exit;
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			
		}else{
			$this->update['id_karyawan'] = encode($save);
			$this->success('Data Karyawan Berhasil Disimpan..');
			$this->db->trans_commit();
		}
		
		//redirect(site_url('karyawan/karyawan/page'));
		
	}
	
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->karyawan_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
	
	
}
/*
*Author: Tomi
*/

