<?php

class Menus_shortcut_mobile_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('hrms');
		$this->set_table('app_menus_shortcut_mobile');
		$this->set_pk('id_app_menu_shortcut');
		// $this->set_log(true);
    }
	
    function count()
	{
		$this->db->select('count(tbl.*) as num_rows');
		if ($this->where)
		{
			if (count($this->like)>0)
			{
				$like = '( 1=0 ';
				foreach ($this->like as $key => $value)
				{
					$like .= ' OR '.$key." LIKE '%".$value."%'";
				}
				$like .= ')';
				$this->where[$like] = null;
			}
			$this->db->where($this->where);
		}else
		{
			$this->db->or_like($this->like);
		}
		
		$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		
		// echo $this->db->last_query();
		// exit;

		$data = $query->row_array();
		return $data['num_rows'];
	}
	function get_list()
	{
		$this->db->select('tbl.*');
		if ($this->where)
		{
			if (count($this->like)>0)
			{
				$like = '( 1=0 ';
				foreach ($this->like as $key => $value)
				{
					$like .= ' OR '.$key." LIKE '%".$value."%'";
				}
				$like .= ')';
				$this->where[$like] = null;
			}
			$this->db->where($this->where);
		}else
		{
			$this->db->or_like($this->like);
		}
		
		foreach ($this->order_by as $key => $value)
		{
			$this->db->order_by($key, $value);
		}

		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		else
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl',$this->limit,$this->offset);
		
		// echo $this->db->last_query();
		// exit;

		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	function menu($id_user,$app_menu)
	{
		$this->db->select('tbl.*');
		$this->db->join('hrms.app_menus_shortcut_priv_mobile prv','tbl.id_app_menu_shortcut = prv.fid_app_menu_shortcut','');
		$where['prv.fid_operator']	= $id_user;
		$where['prv.fid_app_menu']	= $app_menu;
		$this->db->where($where);
		$this->db->order_by('tbl.order_by');
		
		

		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		else
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl',$this->limit,$this->offset);
		
		// echo $this->db->last_query();
		// exit;

		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	function get_list_shortcut($id=0)
	{       
		$this->db->select('tbl.*,usr.fid_operator,usr.read,usr.create,usr.update,usr.delete,usr.id_privilege_shortcut');
		
		$this->db->join('(SELECT * 
							FROM hrms.app_menus_shortcut_priv_mobile
							WHERE fid_operator = '.$id.'
							) usr','tbl.id_app_menu_shortcut = usr.fid_app_menu_shortcut','left');
		$this->db->order_by('tbl.order_by', 'ASC');
		$this->db->where($this->where);
		
		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		else
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl',$this->limit,$this->offset);
		/*
		echo $this->db->last_query();
		exit;
		*/
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
        
    }
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
28052016
*/
