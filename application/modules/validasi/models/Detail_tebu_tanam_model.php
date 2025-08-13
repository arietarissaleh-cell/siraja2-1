<?php

class Detail_tebu_tanam_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		//$this->set_table('dtl_pengamatan_drone');
		$this->set_table('dtl_tebu_tanam');
		$this->set_pk('tbl.no_petak');
		// $this->set_log(true);
    }
	
	
    function count()
	{
		
		$fid_unit=$this->session->userdata('fid_unit');
		
		$this->db->select('count(tbl.*) as num_rows');
		//$this->db->select('tbl.*, si.perihal as perihal');
		// join ke master Unit
		//$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		
		if($fid_unit!=0){
			
			$this->db->where('tbl.fid_unit', $fid_unit);
			
		}

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
		//$fid_unit=$this->session->userdata('fid_unit');
		//echo $fid_unit;
		 //exit;
			
		$this->db->select('tbl.*
						   , dtt.kode_kebun as kode_kebun
						   , dtt.nama_kelompok as petani
						   
						   ');
		$this->db->join('public.dtl_dok_drone ddd','tbl.no_petak = ddd.no_petak','left');
		$this->db->join('public.dtl_tebu_tanam dtt','tbl.no_petak = dtt.no_petak','left');
		//$this->db->join('public.mst_person mp','dtt.kode_sinder = mp.kode_person and dtt.fid_unit = mp.fid_unit','left');
		
		
		$this->db->order_by("tbl.id_tg", "desc");
		
		$this->db->where('ddd.tahun', 2021);
		
		 /* if($fid_unit!=0){
			$this->db->where('tbl.fid_unit', $fid_unit);
		}  */

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
		
		//  echo $this->db->last_query();
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
	

	
	


	 function getDetail($where) 
	{
		$data = array();
			$fid_unit=$this->session->userdata('fid_unit');
		if ( is_array($where) )
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}else{
			$this->db->where($this->pk_field, $where?:0);
		}
		
		$this->db->select('tbl.*
						  ,mu.nama as nama_unit
						  ,mtt.nama_kebun
						  ,mtt.rayon
						  ,mtt.wilayah
						  
						   
						   ');
		//join
		//$this->db->join('public.dtl_dok_drone ddd','tbl.no_petak = ddd.no_petak','left');
		//$this->db->join('public.dtl_tebu_tanam dtt','tbl.no_petak1 = dtt.no_petak and tbl.tahun = dtt.tahun','left');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('public.mst_tebu_tanam mtt','tbl.no_petak = mtt.no_petak and tbl.fid_unit = mtt.fid_unit','left');
		
		
		//echo $this->db->last_query();
		// exit;
		
		$this->db->where('tbl.tahun_tanam_awal', 2023);
		$this->db->where('tbl.tahun_tanam_akhir', 2024);
			
		if($fid_unit!=0){
			//$this->db->where('tbl.fid_unit', $fid_unit);
		}
		
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
		
		
		 // echo $this->db->last_query();
		// exit;
	}
 
 
	  
}
/*
*Author: Ade

*/
