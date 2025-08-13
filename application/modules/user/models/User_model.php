<?php

class User_model extends Base_Model {

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
		// join ke master Unit
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		
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
		
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit,kry.nama_depan as nama_depan,kry.nama_belakang as nama_belakang');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('hrms.mst_karyawan kry','tbl.id_karyawan = kry.id_karyawan','left');
		$this->db->order_by("id_ms_operator", "asc");
		foreach ($this->order_by as $key => $value)
		{
			$this->db->order_by($key, $value);
		}
		
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
	
	public function delete_hak_akses($id)
	{
		$st1 = "DELETE FROM hrms.ms_operator_privilege WHERE fid_operator='$id'";
															
		$query1 = $this->db->query($st1);
			
		return $query1;				
	}
	
	public function insert_hak_akses($id_pengguna_grup,$id_menu,$fid_unit){ //id sudah dari sequent
		$query = $this->db->query("INSERT INTO hrms.ms_operator_privilege(fid_operator,fid_app_menu, fid_unit) 
											 VALUES('$id_pengguna_grup','$id_menu','$fid_unit')");
	}
	
	public function getmax() 
	{
		$q = $this->db->query("SELECT MAX(id_ms_operator) as maxid FROM hrms.ms_operator");
			if($q->num_rows()>0){
				foreach($q->result() as $k){
					$tmp = ((int)$k->maxid);
				}	
			}else{
				$tmp = 0;
			}												
		return $tmp;
	}
	
	
	
}
/*
*Author: Hariyo Koco
*Author URL: http://www.koco.com
28032018
*/
