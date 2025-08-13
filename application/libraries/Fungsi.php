<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fungsi
{
    function Fungsi()
    {
        $this->CI =& get_instance();
    }
    
    function accept_data($value)
    {
        foreach($value as $key => $val)
        {	
            $data[$val]  = $this->CI->input->post($val,TRUE);
            if(!is_array($data[$val]))
            {
                $data[$val]     = strip_image_tags($data[$val]);
                $data[$val]     = quotes_to_entities($data[$val]);
                $data[$val]     = encode_php_tags($data[$val]);
                $data[$val]     = trim($data[$val]);
            }
        }		
        return $data;
    }
    
	function build_menu(){
        $menu = array();
	 	$this->CI->db->order_by('position','asc');
	 	$query = $this->CI->db->get('sys_menu');
		
		$html_out  = '<div class="accordion-group">';
		
		foreach ($query->result() as $row){
			
			$this->CI->db->where('menu_id',$row->menu_id);
			$sql = $this->CI->db->get('sys_submenu');
			
			$m_id = count($sql->result_array());
			$html_out .= '<div class="accordion-heading">
								<a href="#collapse'.$row->menu_id.'" 
								data-parent="#side_accordion" 
								data-toggle="collapse" 
								class="accordion-toggle">
								<i class="'.$row->icon.'"></i> 
								'.$row->menu.'
								</a>
							</div>';
				
			if(count($sql->result_array())>0){
		   		$html_out .= $this->get_childs($row->menu_id);      
			}
		}
                  
	    
        $html_out .= '</div>';

        return $html_out;
    }  
	
	function get_childs($id){ 
		$has_subcats = FALSE;
		$sgm = $this->CI->uri->segment(1);
		$this->CI->db->where('url',''.$sgm.'');
		$query = $this->CI->db->get('sys_submenu');
		
		$html_out = '';
		if($query->num_rows() <> 0){
			$act = $query->row();
			if($id == $act->menu_id){
				$html_out .= '<div class="accordion-body 
							collapse in" id="collapse'.$id.'">';
			}else{
				$html_out .= '<div class="accordion-body 
							collapse" id="collapse'.$id.'">';
			}
		}else{
			$html_out .= '<div class="accordion-body 
					collapse" id="collapse'.$id.'">';
		}
		$html_out .= '<div class="accordion-inner">';
		$html_out .= '<ul class="nav nav-list">';
		
		$this->CI->db->where('menu_id',$id);
		$this->CI->db->order_by('position','asc');
	    $query2 = $this->CI->db->get('sys_submenu');
		
		foreach ($query2->result() as $row){
			$this->CI->db->where('submenu_id',$row->submenu_id);
			$sql2 = $this->CI->db->get('sys_subinmenu');
			
			$has_subcats = TRUE;
			$html_out .= "<li";
			if($sgm == $row->url){
				 $html_out .= " class='active'";
			}
			if($sql2->num_rows() > 0){
				$html_out .= "><a href='#coll".$row->submenu_id."' 
								data-parent='#side_accordions' 
								data-toggle='collapse'>&nbsp;&nbsp; ".$row->title."</a>";
				$html_out .= $this->get_child_of_child($row->submenu_id);
			}else{
				$html_out .= "><a href='".base_url()."".$row->url."' 
							title='".$row->title."' 
							class='mws-tooltip-w'>
							&nbsp;&nbsp; ".$row->title."</a>";
			}
			
			$html_out .= "</li>";
		}		
		$html_out .= '</ul>';
		$html_out .= '</div>';
	  	$html_out .= '</div>';
        return ($has_subcats) ? $html_out : FALSE;
    }
	
	function get_child_of_child($id){ 
		$has_subcats = FALSE;
		$sgm = $this->CI->uri->segment(1);
		$this->CI->db->where('url',''.$sgm.'');
		$query = $this->CI->db->get('sys_subinmenu');
		
		$html_out = '';
		
		if($query->num_rows() <> 0){
			$act = $query->row();
			$html_out .= '<div class="accordion-body collapse';
			if($id == $act->submenu_id){
				$html_out .= ' in"';
			}
				$html_out .= 'id="coll'.$id.'">';
		}else{
			$html_out .= '<div class="accordion-body
			 			collapse" id="coll'.$id.'">';
		}
		$html_out .= '<div class="accordion-inner">';
		$html_out .= '<ul class="nav nav-list">';
		
	    $this->CI->db->where('submenu_id',$id);
		$this->CI->db->order_by('position','asc');
	    $query2 = $this->CI->db->get('sys_subinmenu');
		
		foreach ($query2->result() as $row){
			
			$has_subcats = TRUE;
			$html_out .= "<li";
			if($sgm == $row->url){
				 $html_out .= " class='active'";
			}
			$html_out .= "><a href='".base_url()."".$row->url."' 
							title='".$row->subinmenu."' 
							class='mws-tooltip-w'>";
			$html_out .= "&nbsp;&nbsp; ".$row->subinmenu."</a>";
			$html_out .= "</li>";
		}		
		$html_out .= '</ul>';
		$html_out .= '</div>';
	  	$html_out .= '</div>';
        return ($has_subcats) ? $html_out : FALSE;
    }  
}