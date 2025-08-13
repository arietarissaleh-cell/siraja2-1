<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Unit_pg extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('unit/unit_model');
		
	}
	
	
	public function index()
	{
		
	}
	
	
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
28052016
*/


