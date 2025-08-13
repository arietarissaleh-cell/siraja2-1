<?php

class Operator_model extends Base_Model {
	
	private $primary_key = 'id_ms_operator';
	private $table_name	= 'ms_operator_sdm';
	var $column_order = array(null, null,'tbl.username','tbl.nik',null,null,null);
	var $column_search = array('UPPER(tbl.username)','tbl.nik');
	var $order = array('tbl.username' => 'ASC');

	function __construct() {
		
		

		parent::__construct();
		$this->set_schema('public');
		$this->set_table('ms_operator_sdm');
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
	
	public function getMaxNoPesertaLelang(){
		$q = $this->db->query("select MAX(RIGHT(no_peserta,5)) as kd_max from public.ms_operator_sdm
			WHERE LEFT(no_peserta,5)='MITRA'");
		$kd = "";
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%05s", $tmp);
			}
		}else{
			$kd = "00001";
		}	
		return "MITRA".$kd;
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
		//$this->db->where('tbl.fid_unit',$row_unit['fid_unit']);
		
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
	
	function get_drm_detail($fid_unit=0,$id_ms_operator=0) 
	{
		$data = array();	
		$this->db->select("tbl.*");
		$this->db->where("tbl.fid_unit=".$fid_unit);
		$this->db->where("tbl.id_ms_operator=".$id_ms_operator);
		$this->db->order_by("tbl.id_ms_operator",'ASC');
		
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
	
	private function _get_datatables_query(){
		$fid_lokasi_kerja=$this->session->userdata('fid_lokasi_kerja');
		$this->db->select("
			tbl.*,
			unit.nama as nama_unit
			");
		
		$this->db->from("public.ms_operator_sdm tbl");
		$this->db->join("mst_unit unit","unit.id_unit = tbl.fid_lokasi_kerja","LEFT");

		$i = 0;
		foreach ($this->column_search as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables(){
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered(){
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all(){
		$fid_lokasi_kerja=$this->session->userdata('fid_lokasi_kerja');
		$this->db->select("
			tbl.*,
			unit.nama as nama_unit
			");
		// $this->db->where("tbl.fid_lokasi_kerja", $fid_lokasi_kerja);
		$this->db->from("public.ms_operator_sdm tbl");
		$this->db->join("mst_unit unit","unit.id_unit = tbl.fid_lokasi_kerja","LEFT");
		return $this->db->count_all_results();
	}
	
	
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
28052016
*/
