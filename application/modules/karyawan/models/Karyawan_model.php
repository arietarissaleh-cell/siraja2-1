<?php

class Karyawan_model extends Base_Model {
	//untuk get karyawan di lembur
private $primary_key = 'id_karyawan';
	private $table_name	= 'mst_karyawan_sdm';
//sampe sini 

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
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		
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
		$query_unit = $this->db->query('SELECT fid_unit FROM public.ms_operator_sdm
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		
		$this->db->select('count(tbl.*) as num_rows');
		// join ke master Unit
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_unit']);
		
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
		//$fid_lokasi_kerja=$this->session->userdata('fid_lokasi_kerja');
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit, fid_lokasi_kerja, nik FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		$fid_lokasi_kerja = $row_unit['fid_lokasi_kerja'];
		$nik = $row_unit['nik'];
		
		$query_bag = $this->db->query("SELECT fkode_jabatan, kode_bagian, kode_jabatan FROM public.mst_karyawan_sdm 
											   WHERE nik='".$nik."'
											   LIMIT 1");
		
		$row_bag = $query_bag->row_array();
		$bagian1 = $row_bag['fkode_jabatan'];
		$bagian = $row_bag['kode_bagian'];
		$jabatan = $row_bag['kode_jabatan'];
		
		
		
		
		
		$this->db->select("tbl.*, jbt.nama_jabatan as jabatan");
		// join ke master Unit
		$this->db->select("mu.nama as nama_unit");
		$this->db->join("public.mst_unit mu","tbl.fid_lokasi_kerja = mu.id_unit","left");
		$this->db->join("public.mst_jabatan_sdm jbt","tbl.kode_jabatan = jbt.kode_jabatan","left");
		$this->db->where('tbl.fid_lokasi_kerja',$fid_lokasi_kerja);
		$this->db->where('tbl.kode_bagian',$bagian);
		$this->db->where('tbl.status_kry_aktif',1);
		
		
		
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
	
	
	function get_list_unit()
	{
		$id_karyawan=$this->session->userdata('id_karyawan');
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit, fid_lokasi_kerja FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		$fid_lokasi_kerja=$row_unit['fid_lokasi_kerja'];
		
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		//$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_unit']);
		
		if ($fid_lokasi_kerja==17 ){
		//$this->db->where('kry.fid_lokasi_kerja',$fid_loasi_kerja);
		$this->db->where("tbl.fid_lokasi_kerja IN(17,15)");
		}
		else if ($fid_lokasi_kerja==18){
		$this->db->where("tbl.fid_lokasi_kerja IN(18,19)");
		}
		else if ($fid_lokasi_kerja==11){
		$this->db->where("tbl.fid_lokasi_kerja IN(11)");
		}
		else if ($fid_lokasi_kerja==23){
		$this->db->where("tbl.fid_lokasi_kerja IN(23)");
		}else {}
		
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
	
	//untuk kebutuhan CV
	function get_list_cv()
	{
		$id_karyawan=$this->session->userdata('id_karyawan');
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_lokasi_kerja,id_karyawan FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		//$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_lokasi_kerja']);
		$this->db->where('tbl.id_karyawan',$id_karyawan);
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
	
	
	
	
	function get_atasan_list()
	{
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		$this->db->join('public.mst_jabatan_sdm mjb','tbl.kode_jabatan = mjb.kode_jabatan','left');
		
		//$this->db->where("tbl.jabatan_group IN('DIREKTUR','GM','KABAG','KABID','KADIV','PJS_GM','PJS_KABAG','PJS_KABID')");
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
	
	
	function get_atasan_list_unit()
	{
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_lokasi_kerja FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		$this->db->join('public.mst_jabatan_sdm mjb','tbl.kode_jabatan = mjb.kode_jabatan','left');
		$this->db->where("mjb.group_kode NOT IN(0)");
		$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_lokasi_kerja']);
		$this->db->order_by("tbl.nama_depan","asc");
		
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
		
		
		/* echo $this->db->last_query();
		exit; */

		
		
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	
	
	function get_atasan_list_unit_flag()
	{
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_lokasi_kerja FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		$fid_lokasi_kerja = $row_unit['fid_lokasi_kerja'];
		
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		$this->db->join('public.mst_jabatan_sdm mjb','tbl.kode_jabatan = mjb.kode_jabatan','left');
		$this->db->where('tbl.flag_approve',1);
		$this->db->where('tbl.status_kry_aktif',1);
		//$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_lokasi_kerja']);
		
		if ($fid_lokasi_kerja==17 || $fid_lokasi_kerja==15){
		
		$this->db->where("tbl.fid_lokasi_kerja IN(17,15)");
		}
		else if ($fid_lokasi_kerja==18){
		$this->db->where("tbl.fid_lokasi_kerja IN(18,19)");
		}
		else if ($fid_lokasi_kerja==11){
		$this->db->where("tbl.fid_lokasi_kerja IN(11)");
		}
		else if ($fid_lokasi_kerja==23){
		$this->db->where("tbl.fid_lokasi_kerja IN(23)");
		}else {}
		
		$this->db->order_by("tbl.nama_depan","asc");
		
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
		
		
		/* echo $this->db->last_query();
		exit; */

		
		
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	
	function get_kabag_list_unit()
	{
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		$this->db->where("tbl.jabatan_group IN('KABAG','KADIV','PJS_KABAG')");
		$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_unit']);
		$this->db->order_by("tbl.nama_depan","asc");
		
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
	
	
	function get_kabid_list_unit()
	{
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_lokasi_kerja = mu.id_unit','left');
		$this->db->where("tbl.jabatan_group IN('GM','KABID','PJS_GM','PJS_KABID')");
		$this->db->where('tbl.fid_lokasi_kerja',$row_unit['fid_unit']);
		$this->db->order_by("tbl.nama_depan","asc");
		
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
		$this->db->select("mu.nama as nama_unit,
						jbt.nama_jabatan as nama_jabatan, 					
						glg.deskripsi as deskripsi, 
						cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat as total_hari_masa_kerja,
						(cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat)/365 as jml_tahun_kerja,
						mod((cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat),365)/30 as jml_bulan_kerja,
						mod(mod((cast(substr(cast(now() as varchar(32)),1,10) as date) -  tbl.tanggal_diangkat),365),30) as jml_hari_kerja,
						
						bgn.deskripsi as nama_bagian 
			");
		$this->db->join("public.mst_unit mu","tbl.fid_lokasi_kerja = mu.id_unit","left");
		$this->db->join("public.mst_jabatan_sdm jbt","tbl.jabatan_group = jbt.jabatan_group","left");
		$this->db->join("public.mst_golongan_sdm glg","tbl.kode_golongan = glg.kode_golongan","left");
		//$this->db->join('public.mst_bidang_sdm bdg','tbl.id_bidang = bdg.id_bidang','left');
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'bagian') bgn","tbl.kode_bagian = bgn.kode_lookup","left");
		
		
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
	
	
	function getDetail_cv($where) 
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
		$this->db->select("mu.nama as nama_unit,
						
						agm.deskripsi as agama 
						,jk.deskripsi as jk 
						,spk.deskripsi as kawin 
			");
		$this->db->join("public.mst_unit mu","tbl.fid_unit = mu.id_unit","left");
		//$this->db->join("public.mst_jabatan_sdm jbt","tbl.jabatan_group = jbt.jabatan_group","left");
		//$this->db->join("public.mst_golongan_sdm glg","tbl.kode_golongan = glg.kode_golongan","left");
		//$this->db->join('public.mst_bidang_sdm bdg','tbl.id_bidang = bdg.id_bidang','left');
		//$this->db->join("(select * from public.mst_lookup where group_lookup = 'bagian') bgn","tbl.kode_bagian = bgn.kode_lookup","left");
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'agama') agm","tbl.kode_agama = agm.kode_lookup","left");
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'jenis_kelamin') jk","tbl.jenis_kelamin_id = jk.kode_lookup","left");
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'status_kawin') spk","tbl.status_pernikahan = spk.kode_lookup","left");
		
		
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
	
	
	function getDetail_gaji($where) 
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
		$this->db->select("mu.nama as nama_unit,
						
						agm.deskripsi as agama 
						,jk.deskripsi as jk 
						,spk.deskripsi as kawin 
						,jbt.nama_jabatan as nama_jabatan 
			");
		$this->db->join("public.mst_unit mu","tbl.fid_unit = mu.id_unit","left");
		$this->db->join("public.mst_jabatan_sdm jbt","tbl.kode_jabatan = jbt.kode_jabatan","left");
		//$this->db->join("public.mst_jabatan_sdm jbt","tbl.jabatan_group = jbt.jabatan_group","left");
		//$this->db->join("public.mst_golongan_sdm glg","tbl.kode_golongan = glg.kode_golongan","left");
		//$this->db->join('public.mst_bidang_sdm bdg','tbl.id_bidang = bdg.id_bidang','left');
		//$this->db->join("(select * from public.mst_lookup where group_lookup = 'bagian') bgn","tbl.kode_bagian = bgn.kode_lookup","left");
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'agama') agm","tbl.kode_agama = agm.kode_lookup","left");
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'jenis_kelamin') jk","tbl.jenis_kelamin_id = jk.kode_lookup","left");
		$this->db->join("(select * from public.mst_lookup where group_lookup = 'status_kawin') spk","tbl.status_pernikahan = spk.kode_lookup","left");
		
		
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
	
	public function getNikKaryawan($id_karyawan) {
		$q = $this->db->query("SELECT nik FROM public.mst_karyawan_sdm where id_karyawan='$id_karyawan'");
			if($q->num_rows()>0){
				$tmp = null;
				foreach($q->result() as $k){
					$tmp = $k->nik;
				}	
			}else{
				$tmp = null;
			}
		return $tmp;       
    }
	
	public function get_lokasi_kerja($id_karyawan) {
		$q = $this->db->query("SELECT fid_lokasi_kerja FROM public.mst_karyawan_sdm where id_karyawan='$id_karyawan'");
			if($q->num_rows()>0){
				$tmp = null;
				foreach($q->result() as $k){
					$tmp = $k->fid_lokasi_kerja;
				}	
			}else{
				$tmp = null;
			}
		return $tmp;       
    }
	
	
	
	//function untuk get karyawan lembur
	public function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id); 
		
		$this->db->select('tbl.*');
		
		
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
	//	 echo $this->db->last_query();
		if($query->num_rows()>0) 
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	
	function get_list_lembur()
	{
		//$fid_lokasi_kerja=$this->session->userdata('fid_lokasi_kerja');
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit, fid_lokasi_kerja, nik FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		$fid_lokasi_kerja = $row_unit['fid_lokasi_kerja'];
		$nik = $row_unit['nik'];
		
		$query_bag = $this->db->query("SELECT fkode_jabatan, kode_bagian FROM public.mst_karyawan_sdm 
											   WHERE nik='".$nik."'
											   LIMIT 1");
		
		$row_bag = $query_bag->row_array();
		$bagian1 = $row_bag['fkode_jabatan'];
		$bagian = $row_bag['kode_bagian'];
		
		
		$this->db->select("tbl.*");
		// join ke master Unit
		$this->db->select("mu.nama as nama_unit");
		$this->db->join("public.mst_unit mu","tbl.fid_lokasi_kerja = mu.id_unit","left");
		$this->db->where('tbl.fid_lokasi_kerja',$fid_lokasi_kerja);
		$this->db->where('tbl.kode_bagian',$bagian);
		$this->db->where('tbl.status_kry_aktif',1);
		$this->db->where('tbl.pengganti_lembur',0);
		$this->db->where('tbl.status_p2k',0);
		$this->db->where('tbl.flag_approve',0);
		$this->db->where("tbl.status_staf IN('SF06','SF08','SF09','SF10','SF11','SF12')");
		
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
	
	
	function get_list_lembur_unit()
	{
		//$fid_lokasi_kerja=$this->session->userdata('fid_lokasi_kerja');
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit, fid_lokasi_kerja, nik FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		$fid_lokasi_kerja = $row_unit['fid_lokasi_kerja'];
		$nik = $row_unit['nik'];
		
		$query_bag = $this->db->query("SELECT fkode_jabatan, kode_bagian FROM public.mst_karyawan_sdm 
											   WHERE nik='".$nik."'
											   LIMIT 1");
		
		$row_bag = $query_bag->row_array();
		$bagian1 = $row_bag['fkode_jabatan'];
		$bagian = $row_bag['kode_bagian'];
		
		
		$this->db->select("tbl.*");
		// join ke master Unit
		$this->db->select("mu.nama as nama_unit");
		$this->db->join("public.mst_unit mu","tbl.fid_lokasi_kerja = mu.id_unit","left");
		$this->db->where('tbl.fid_lokasi_kerja',$fid_lokasi_kerja);
		//$this->db->where('tbl.kode_bagian',$bagian);
		$this->db->where('tbl.status_kry_aktif',1);
		$this->db->where('tbl.pengganti_lembur',0);
		$this->db->where('tbl.status_p2k',0);
		$this->db->where('tbl.flag_approve',0);
		$this->db->where("tbl.status_staf IN('SF06','SF08','SF09','SF10','SF11','SF12')");
		
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
	
	
	
	
	
	
}
/*
*Author: Hariyo Koco
*Author URL: http://www.koco.com
28032018
*/
