<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends MY_Controller {

	//var $table = 'mst_item';
	
	function __construct()
	{
		parent::__construct();
		
		
	}
	
	
	public function index()
	{
		//$this->page();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'utilities/akun/main'
				,'title' 		=> 	'Akun'
		);
		$this->load('tpl',$data['content'],$data);
	}
	
	function input($id=0)
	{
		$data = array('name' 		=> 	$this->session->userdata('username')
			,'content' 				=> 	'utilities/akun/input'
		);

		$this->load->view($data['content'],$data);
	}
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
*/

