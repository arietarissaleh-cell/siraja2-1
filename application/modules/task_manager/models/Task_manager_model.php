<?php

class Task_manager_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('mst_karyawan_sdm');
		$this->set_pk('id_karyawan');
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
		// join ke master Unit
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->where('tbl.fid_unit',$row_unit['fid_unit']);
		
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
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->order_by("nama_depan", "asc");
		
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
	
	
	
	
	function getDetail($where) 
	{
		$data = array();

		if ( is_array($where) )
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}else
		{
			$this->db->where($this->pk_field, $where?:0);
		}
		
		$this->db->select('tbl.*');
		// join 
		$this->db->select('mu.nama as nama_unit,
						jbt.nama_jabatan as nama_jabatan,						
						glg.nama_golongan_karyawan as nama_golongan,
						cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat as total_hari_masa_kerja,
						(cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat)/365 as jml_tahun_kerja,
						mod((cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat),365)/30 as jml_bulan_kerja,
						mod(mod((cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat),365),30) as jml_hari_kerja,
						bdg.nama_bidang as nama_bidang,
						bgn.nama_bagian as nama_bagian
			');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('hrms.mst_jabatan jbt','tbl.id_jabatan = jbt.id_jabatan','left');
		$this->db->join('hrms.mst_golongan_karyawan glg','tbl.id_golongan_karyawan = glg.id_golongan_karyawan','left');
		$this->db->join('hrms.mst_bidang bdg','tbl.id_bidang = bdg.id_bidang','left');
		$this->db->join('hrms.mst_bagian bgn','tbl.id_bagian = bgn.id_bagian','left');
		
		
		$this->db->order_by($this->pk_field);
		$query = $this->db->get($this->schema.'.'.$this->table.' tbl',1,0);
		if ( $query->num_rows() == 1)
		{
			$data = $query->row_array();
			$query->free_result();
			
		}else
		{
			$data = $this->feed_blank();
			// $data['id_log'] = 0;
		}
		return $data;
	}
	
}
/*
*Author: Hariyo Koco
*Author URL: http://www.koco.com
28032018
*/
