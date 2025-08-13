<?php 
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	function __construct()
	{	
		parent::__construct();
		// $name = $this->session->name;
		if(!is_logged_in())
		{
			redirect('login');
		}
		else{
			redirect('main');
		}
		
	}
	
	function index()
	{
		//echo 'hokeeeeeeeeee';
		
	}
}

