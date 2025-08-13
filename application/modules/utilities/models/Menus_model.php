<?php

class Menus_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('app_menus_dms_new');
		$this->set_pk('id_app_menu');
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
	
	function menu_build($id_operator=0)
	{
		$sql = 
<<<EOT
SELECT pkey_tbl.id_app_menu,pkey_tbl.fid_app_menu,pkey_tbl.order_by
,pkey_tbl.title
,COALESCE(tbl.priv_menu,0) priv_menu
,COALESCE(tbl.id_app_menu,0) app_menu
,tbl2.title as sub_menu_title
,COALESCE(tbl2.priv_menu_sub,0) priv_menu_sub
,COALESCE(tbl2.fid_app_menu,0) app_menu_sub
,tbl3.title as shortcut_menu_title
,COALESCE(tbl3.priv_menu_shortcut,0) priv_menu_shortcut
,COALESCE(tbl3.fid_app_menu,0) app_menu_shortcut
FROM (SELECT * FROM saup.app_menus mn WHERE fid_app_menu = 0) pkey_tbl
LEFT JOIN (SELECT mn.title,mn.id_app_menu,prv.id_privilege as priv_menu
			FROM saup.app_menus mn
			LEFT JOIN (SELECT * FROM saup.ms_operator_privilege WHERE fid_operator = '$id_operator') prv ON mn.id_app_menu = prv.fid_app_menu
			WHERE mn.fid_app_menu = 0) tbl ON pkey_tbl.id_app_menu = tbl.id_app_menu
LEFT JOIN (SELECT mn.title,mn.fid_app_menu,prv.id_privilege as priv_menu_sub,mn.order_by
			FROM saup.app_menus mn
			LEFT JOIN (SELECT * FROM saup.ms_operator_privilege WHERE fid_operator = '$id_operator') prv ON mn.id_app_menu = prv.fid_app_menu
			WHERE mn.fid_app_menu > 0) tbl2 ON tbl.id_app_menu = tbl2.fid_app_menu
LEFT JOIN (SELECT mn.title,mn.fid_app_menu,prv.id_privilege_shortcut as priv_menu_shortcut,mn.order_by
			FROM saup.app_menus_shortcut mn
			LEFT JOIN (SELECT * FROM saup.app_menus_shortcut_priv WHERE fid_operator = '$id_operator') prv ON mn.id_app_menu_shortcut = prv.fid_app_menu_shortcut
			WHERE mn.fid_app_menu > 0) tbl3 ON tbl2.priv_menu_sub = tbl3.fid_app_menu
ORDER BY pkey_tbl.id_app_menu,pkey_tbl.order_by,tbl2.order_by,tbl3.order_by
EOT;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	function get_list_menu($id=0)
	{       
		$this->db->select('tbl.*,usr.fid_operator');
		
		$this->db->join('(SELECT * 
							FROM hrms.ms_operator_privilege
							WHERE fid_operator = '.$id.'
							) usr','tbl.id_app_menu = usr.fid_app_menu','left');
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
