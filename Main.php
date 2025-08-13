<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		//load model disini
		
		
	}
	
	public function index()
	{
		// exit;
		// echo('masuk');
		$today = date("j - M - Y");
		$id_operator = $this->session->userdata('id_ms_operator');
		$data = array('name' 		=> $this->session->userdata('name')
					,'content' 		=> 'main'
					,'title' 		=> 'Daftar yang Cuti Hari Ini ('.$today.')'
					);
		$this->load('tpl',$data['content'], $data);
	}
	function dashboard()
	{
		$today = date("j - M - Y");
		$id_operator = $this->session->userdata('id_ms_operator');
		$data = array('name' 		=> $this->session->userdata('name')
					,'content' 		=> 'dashboard'
					,'title' 		=> 'Daftar yang Cuti Hari Ini ('.$today.')'
					);
		$this->load->view($data['content'], $data);
	}
}
/*
*Author: Rickytarius
28052016
*/
