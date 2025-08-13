<?php

class Menus_priv_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('ms_operator_privilege_produksi');
		$this->set_pk('id_privilege');
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
	function get_list_menu($id=0)
	{       
		$this->db->select('tbl.*,usr.fid_karyawan');
		
		$this->db->join('(SELECT * 
							FROM karyawan_priv
							WHERE fid_karyawan = '.$id.'
							) usr','tbl.id_app_menu = usr.fid_app_menu','left');
		$this->db->order_by('tbl.order_by', 'ASC');
		$this->db->where($this->where);
		
		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->table.' tbl');
		else
			$query = $this->db->get($this->table.' tbl',$this->limit,$this->offset);
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
	
	
	function hapus_menu_priv($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	
	
	function insert_menu($fid_operator,$fid_app_menu,$fid_unit){
		$data = array(
			'fid_operator' => $fid_operator,
			'fid_app_menu' => $fid_app_menu,
			'fid_unit'	   => $fid_unit
		);

		$this->db->insert('public.ms_operator_privilege_mitra',$data);
	}
	
	
	 function hapus_menu($fid_operator,$fid_app_menu,$fid_unit){
		$data = array(
			'fid_operator' => $fid_operator,
			'fid_app_menu' => $fid_app_menu,
			'fid_unit'	   => $fid_unit
		);
		
		$this->db->delete('public.ms_operator_privilege_mitra',$data);
	 }
}
/*
*Author: Hariyo
*Author URL: http://www.hariyo.com
28052016
*/
