<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
	var $template_data = array();
	var $update = array();
	var $title = '..: GioParfum  :..';
	public function __construct()
	{
		parent::__construct();
		if (!$this->is_logged_in())
		{
			redirect('/login');
		}
		
	}
		
	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
	{               
		if (!isset($view_data['title']))
			$view_data['title'] = $this->title;
			
		$this->CI =& get_instance();
		$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));			
		return $this->CI->load->view($template, $this->template_data, $return);
	}
		
	public function is_logged_in()
	{
		return is_logged_in();
	}
	
	function success($msg='',$uri='')
	{
		$this->update['error']='';
		$this->update['message']=$msg;
		echo json_encode($this->update);
	}
	function error($err)
	{
		$this->update['error']=$err;
		$this->update['message']='';
		echo json_encode($this->update);
		exit;
	}
	
	function success_redirect($msg='',$uri='')
	{
		redirect($uri);
	}	
	
	
	function gen_paging($page_data=array())
	{
		// exit;
		$func_name = "pageLoad";
		if (isset($page_data['load_func_name']))
		{
			if ($page_data['load_func_name'])
				$func_name = $page_data['load_func_name'];
		}
		if ($page_data['count_row']>0)
			$count = ceil($page_data['count_row'] / $page_data['limit']) ;
		
		$limit = $page_data['limit'];
		$limit = $limit?$limit:1;
		$count = ceil($page_data['count_row'] / $limit) ;
		$last_row = $limit*$page_data['current'];
		if ($last_row > $page_data['count_row'])
			$last_row = $page_data['count_row'];
		$page_result = '<div class="row">
							<div class="col-md-6">
								<div class="dataTables_info" id="DataTables_Table_0_info">Showing '.(($limit*($page_data['current']-1))+1).' to '.$last_row.' of '.$page_data['count_row'].' entries
								</div>
							</div>
							';
		$previous = $page_data['current'] - 1;
		$next = $page_data['current'] + 1;
		 
									
		$page_result .= '<div class="col-md-6">
							 <div class="mt-4">
								<ul class="pagination justify-content-end">
		 
									<li class="prev '.($page_data['current']==1?'active':'').'"><a class="page-link" href="javascript:void(0)" '.($page_data['current']==1?'':'onclick="'.$func_name.'('.$previous.')"').'>Previous</a></li>';
									
		
		$paging_show = 3;
		$page_start = $page_data['current'] - $paging_show;
		$page_start = $page_start<1?1:$page_start;
		//$page_end	= $count;
		$page_end = $page_data['current'] + $paging_show;
		$page_end = $count > $page_end ? $page_end : $count;
		$page_end = $count > 1 ? $page_end : 1;
		
		 
		for($i=$page_start; $i<=$page_end; $i++)
		{ 
			$page_result .= '<li   '.($page_data['current']==$i?'class="page-item active"':'').'>'
							.'<a class="page-link" href="javascript:void(0)" '.($page_data['current']==$i?'':'onclick="'.$func_name.'('.$i.')"').'>'.$i.'</a>'
							.'</li>'
							 
							;
		}
	 
		
	 	$page_result .= '<li class="page-item '.($page_data['current']==$page_end?'active':'').'"><a class="page-link" href="javascript:void(0)" '.($page_data['current']==$count?'':'onclick="'.$func_name.'('.$next.')"').'>Next </a></li>';
		//$page_result .= '<li class="next '.($page_data['current']==$page_end?'active':'').'"><a href="javascript:void(0)" onclick="'.$func_name.'('.$count.')">Last &gt; </a></li></ul></div>';
		
		 
						
						
		return $page_result;
	}
	
	function reject()
	{
		$this->load->view('rejected');
	}
	
	function gen_xml($data,$model)
	{
		$data_start="<![CDATA["; 
		$data_end="]]>";
		$cr=chr(13).chr(10);
		$xmldump="";
		$xmldump.='<?xml version = "1.0" encoding="Windows-1252" standalone="yes"?>';
		$xmldump.=$cr."<VFPData>";
		$xmldump.=$model->gen_xml_structure();
		foreach($data->result_array() as $row)
		{
			$xmldump = $xmldump."<crsoheader>";
			foreach($row as $field=>$value)
			{
				$xmldump = $xmldump."<".$field.">".str_replace('&','_amp',$value)."</".$field.">".chr(13);
			}
			$xmldump = $xmldump.$cr."</crsoheader>".chr(13);
				
		}
		
		$xmldump = $xmldump.$cr."</VFPData>";
		
		return $xmldump;
	}
	
} 
