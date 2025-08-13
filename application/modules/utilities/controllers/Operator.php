<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Operator extends MY_Controller
{

	//var $table = 'mst_item';

	function __construct()
	{
		parent::__construct();

		$this->load->model('operator_model');
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
		$data = array(
			'name' 	=> 	$this->session->userdata('name'),
			'content' 		=> 	'utilities/operator/main',
			'title' 		=> 	'Daftar Operator'
		);
		$this->load->view($data['content'], $data);
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
		$data = array(
			'name' 	=> 	$this->session->userdata('name'),
			'content' 		=> 	'operator/filter',
			'title' 		=> 	'Filter Cuti',
			'unit' 		=> 	$unit
		);
		$this->load->view($data['content'], $data);
	}
	function ajax_list()
	{
		$list = $this->operator_model->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $operator_model) {
			$action = '
			<input type="hidden" id="username_' . $operator_model->id_ms_operator . '" value="' . $operator_model->id_ms_operator . '">
			<a href="javascript:void(0);" onClick="loadInput(\'utilities/priv_menu/input/' . encode($operator_model->id_ms_operator) . '\')" class="fa fa-sitemap" title="Privilage : ' . $operator_model->username . '"></i></a>

			';
			$no++;
			$row = array();

			$row[]	= $no;
			$row[]  = $operator_model->username;
			$row[]  = $operator_model->nik;

			$row[]  = $operator_model->nama_unit;

			$row[]  = $action;
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->operator_model->count_all(),
			"recordsFiltered" => $this->operator_model->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}
	function page($pg = 1)
	{

		//
		$data = array(
			'operator_list' 	=> 	$this->operator_model->get_list_unit(),
			'name' 			=> 	$this->session->userdata('name'),
			'content' 			=> 	'utilities/operator/list',

		);

		$this->load->view($data['content'], $data);
	}
	function input($id = 0)
	{

		$id_ms_operator = $this->session->userdata('id_ms_operator');
		$id = decode($id);
		$operator = $this->operator_model->get($id);
		$unit = $this->unit_model->get_list();
		$karyawan = $this->karyawan_model->get_list();
		$menu	= $this->db->query("SELECT * FROM PUBLIC.app_menus_dms_new ORDER BY id_app_menu ASC")->result();
		$priv	= $this->db->query("SELECT * FROM PUBLIC.ms_operator_privilege_dms where id_ms_operator = $id_ms_operator")->result();
		//$this->page();
		$data = array(
			'name' 	=> 	$this->session->userdata('name'),
			'content' 		=> 	'utilities/operator/input',
			'title' 		=> 	$id ? 'Edit ' . $operator['username'] : 'Input Baru',
			'operator' 	=> 	$operator,
			'unit' 		=> 	$unit,
			'karyawan'		=>  $karyawan,
			'menu'		=>  $menu
		);
		$this->load->view($data['content'], $data);
	}
	function save()
	{
		// $id = decode($id)?:0;
		$this->db->trans_start();
		$id_operator	= decode($this->input->post('t_id_ms_operator'));
		$username	= ($this->input->post('t_username'));
		$fid_unit	= ($this->input->post('t_fid_unit'));
		$operator = $this->operator_model->get(array('username' => $username));
		$pwd1	= $this->input->post('t_password');
		$pwd2	= $this->input->post('t_password2');
		$id_karyawan = $this->input->post('t_id_karyawan');

		if ($pwd1 <> $pwd2) {
			$this->error('Password tidak sama');
		}
		if ($operator['username']) {
			$this->error('Username sudah ada');
		}
		$data = array();
		$nChar = strlen($pwd1) + 1;
		$cPassGen = $pwd1;
		$x = 1;
		while ($x <= $nChar) {
			$cPassGen = md5($cPassGen);
			$x++;
		}

		$data['id_ms_operator']	= $id_operator;
		$data['username']		= $username;
		$data['fid_unit']		= $fid_unit;
		$data['id_karyawan']	= $id_karyawan;

		if ($pwd1) {
			$data['pwd']			= $cPassGen;
		}
		$data['expiry_date']	= getSQLDate($this->input->post('t_expired_date'));
		$data['last_update']	= date('Ymd');
		// echo print_r($data);
		$save = $this->operator_model->save($data);
		// echo $this->db->last_query();
		// exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			$this->error('Proses gagal');
		} else {
			$this->update['id_ms_operator'] 		= encode($save);
			$this->success('Data berhasil disimpan..');
			$this->db->trans_commit();
		}
	}
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->operator_model->delete($id);

		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
28052016
*/
