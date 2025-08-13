<?php

class Wilayah_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('mst_wilayah');
		$this->set_pk('id_wilayah');
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
		//$this->db->select('tbl.*');
		
		//$fid_unit = $this->session->userdata('fid_unit');
		//$id_ms_operator=$this->session->userdata('id_ms_operator');
		$this->db->select('tbl.*');
		//$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		//$this->db->join('public.mst_jenis_surat_dms js','tbl.fid_jenis_surat = js.id_jenis_surat','left');
		
		$this->db->order_by("tbl.id_wilayah", "asc");
		//$this->db->where("tbl.jabatan", "SKK");
		//$this->db->where("tbl.fid_unit", $fid_unit);
		
		if($this->like)
		$this->db->like($this->like);
		
		if($this->where)
		$this->db->where($this->where);
		

		//
		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		else
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl',$this->limit,$this->offset);
		
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	
	function get_list_wilayah($unit)
	{	
		//$this->db->select('tbl.*');
		
		$fid_unit = $this->session->userdata('fid_unit');
		$this->db->select('tbl.*');
		//$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		//$this->db->join('public.mst_jenis_surat_dms js','tbl.fid_jenis_surat = js.id_jenis_surat','left');
		
		$this->db->order_by("tbl.id_wilayah", "asc");
		//$this->db->where("tbl.jabatan", "SKK");
		$this->db->where("tbl.fid_unit", $unit);
		
		if($this->like)
		$this->db->like($this->like);
		
		if($this->where)
		$this->db->where($this->where);
		

		//
		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		else
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl',$this->limit,$this->offset);
		
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
