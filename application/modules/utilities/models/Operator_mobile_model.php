<?php

class Operator_mobile_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('hrms');
		$this->set_table('ms_operator');
		$this->set_pk('id_ms_operator');
		
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
	
	function count_unit()
	{
		$id_karyawan=$this->session->userdata('id_karyawan');
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit FROM hrms.ms_operator 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$this->db->select('count(tbl.*) as num_rows');
		$this->db->where('tbl.fid_unit',$row_unit['fid_unit']);
		
		/* if ($this->where)
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
		} */
		
		if($this->like)
			$this->db->like($this->like);
		
		if($this->where)
			$this->db->where($this->where);
		
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
	
	
	function get_list_unit()
	{
		$id_karyawan=$this->session->userdata('id_karyawan');
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit FROM hrms.ms_operator 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$this->db->select('tbl.*');
		$this->db->where('tbl.fid_unit',$row_unit['fid_unit']);
		
		/* if ($this->where)
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
		} */
		
		foreach ($this->order_by as $key => $value)
		{
			$this->db->order_by($key, $value);
		}
		
		if($this->like)
			$this->db->like($this->like);
		
		if($this->where)
			$this->db->where($this->where);
		
		

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
	
	
	
}
/*
*Author: Hariyo Koco
*Author URL: 
28052016
*/
