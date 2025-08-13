<?php

class Drone_slide_model extends Base_Model {
	var $column_order = array(null, 'tanggal_foto', null, null, null);
	var $column_search = array('tanggal_foto');
	var $order = array('tbl.tanggal_foto' => 'desc');

	function __construct() {

		parent::__construct();
		$this->set_schema('public');
		//$this->set_table('dtl_pengamatan_drone');
		$this->set_table('dtl_foto_drone');
		$this->set_pk('id_drone');
		// $this->set_log(true);
	}
	
	
	private function _get_datatables_query($id_unit, $tahun_awal, $tahun_akhir){

		$this->db->select(" COUNT
			( foto ) as jumlah_foto, tanggal_foto, st_validasi");

		$this->db->from($this->schema.".".$this->table. " tbl");

		//$this->db->join("public.mst_tebu_tanam mst", "mst.no_petak = tbl.no_petak AND mst.fid_unit = tbl.fid_unit AND mst.tahun_tanam_awal = tbl.tahun_tanam_awal AND mst.tahun_tanam_akhir = tbl.tahun_tanam_akhir", "LEFT");
		//$this->db->join("public.mst_unit unit", "unit.id_unit = tbl.fid_unit", "LEFT");

		$this->db->where("tbl.fid_unit $id_unit");

		$this->db->where("tbl.tahun_tanam_awal", $tahun_awal);
		$this->db->where("tbl.tahun_tanam_akhir", $tahun_akhir);
		$this->db->group_by("tanggal_foto, st_validasi");
		$this->db->order_by("tbl.tanggal_foto", "DESC");

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

	function get_datatables($id_unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query($id_unit,  $tahun_awal, $tahun_akhir);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_unit,  $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query($id_unit,  $tahun_awal, $tahun_akhir);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id_unit,  $tahun_awal, $tahun_akhir){
		$this->db->select("COUNT
			( foto ) as jumlah_foto, tanggal_foto, st_validasi");

		$this->db->from($this->schema.".".$this->table. " tbl");

		//$this->db->join("public.mst_tebu_tanam mst", "mst.no_petak = tbl.no_petak AND mst.fid_unit = tbl.fid_unit AND mst.tahun_tanam_awal = tbl.tahun_tanam_awal AND mst.tahun_tanam_akhir = tbl.tahun_tanam_akhir", "LEFT");
		//$this->db->join("public.mst_unit unit", "unit.id_unit = tbl.fid_unit", "LEFT");

		$this->db->where("tbl.fid_unit $id_unit");

		$this->db->where("tbl.tahun_tanam_awal", $tahun_awal);
		$this->db->where("tbl.tahun_tanam_akhir", $tahun_akhir);
		$this->db->group_by("tanggal_foto, st_validasi");
		$this->db->order_by("tbl.tanggal_foto", "DESC");

		return $this->db->get()->num_rows();
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
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$bulan = date('m');
		$tahun = date('Y');
		$tahun_1 = date('Y') - 1;
		$tahun_2 = date('Y') + 1;
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_id_karyawan = $this->db->query('SELECT id_karyawan,fid_lokasi_kerja FROM public.ms_operator_sdm 
			WHERE id_ms_operator='.$id_ms_operator.'
			LIMIT 1');
		$row_id_karyawan = $query_id_karyawan->row_array(); 
		$id_karyawan = $row_id_karyawan['id_karyawan'];
		$fid_lokasi_kerja = $row_id_karyawan['fid_lokasi_kerja'];
		
		echo $fid_lokasi_kerja;
		 //exit;

		$this->db->select('tbl.*
			,nama as nama_unit

			');
		//$this->db->join('public.dtl_dok_drone ddd','tbl.no_petak = ddd.no_petak','left');
		//$this->db->join('public.dtl_tebu_tanam dtt','tbl.no_petak = dtt.no_petak','left');
		//$this->db->join('public.mst_person mp','dtt.kode_sinder = mp.kode_person and dtt.fid_unit = mp.fid_unit','left');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		
		$this->db->order_by("tbl.id_drone", "desc");
		
		if($bulan >= 5){
			$this->db->where('tbl.tahun_tanam_awal', $tahun);
			$this->db->where('tbl.tahun_tanam_akhir', $tahun_2);
		}else {
			$this->db->where('tbl.tahun_tanam_awal', $tahun_1);
			$this->db->where('tbl.tahun_tanam_akhir', $tahun);
		}
		
		//$this->db->grup('tbl.tahun', 2021);
		
		if($fid_lokasi_kerja!=11){
			$this->db->where('tbl.fid_unit', $fid_lokasi_kerja);
		}  

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
			//$fid_unit=$this->session->userdata('fid_unit');
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



			');
		
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		//$this->db->join('public.mst_person_ecadong skk', 'tbl.rayon = CAST(REPLACE(skk.kode_person, 'K', ' ') AS INTEGER) and skk.flag_person = 'K'', 'left');
		
		//echo $this->db->last_query();
		// exit;

		/* if($fid_unit!=0){
			$this->db->where('tbl.fid_unit', $fid_unit);
		} */
		
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
	
	
	function getDetail_data($no_petak) 
	{
		$data = array();
			//$fid_unit=$this->session->userdata('fid_unit');
		
		
		$this->db->select('tbl.*
			,mu.nama as nama_unit



			');
		
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		//$this->db->join('public.mst_person_ecadong skk', 'tbl.rayon = CAST(REPLACE(skk.kode_person, 'K', ' ') AS INTEGER) and skk.flag_person = 'K'', 'left');
		
		//echo $this->db->last_query();
		// exit;

		/* if($fid_unit!=0){
			$this->db->where('tbl.fid_unit', $fid_unit);
		} */
		
		$this->db->where('tbl.tahun_tanam_awal', 2023);
		$this->db->where('tbl.tahun_tanam_akhir', 2024);
		
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
	
	
	function get_photo_drone_slide($id_drone,$fid_unit,$tahun_awal,$tahun_akhir){
		//$fid_unit=$this->session->userdata('fid_unit');
		echo	$mt = $tahun_awal - $tahun_akhir;
		$sql=
		"
		SELECT tanggal_foto,
		foto,
		CASE
		WHEN status_kualitas = 1 THEN 'BAIK' 
		WHEN status_kualitas = 2 THEN 'SEDANG' 
		WHEN status_kualitas = 3 THEN 'KURANG' 


		ELSE NULL 
		END AS status
		FROM public.dtl_foto_drone
		WHERE no_petak='$id_drone' and fid_unit='$fid_unit' and tahun_tanam_awal='$tahun_awal' and tahun_tanam_akhir='$tahun_akhir'
		";

		$query = $this->db->query($sql);
		
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
	// echo $this->db->last_query();
		// exit;

	}
	
	
	function get_data($id_drone){
		

		$query = $this->db->query("
			SELECT
			
			
			tbl.fid_unit
			,tbl.nama_kebun
			,tbl.no_petak
			,tbl.rayon
			,tbl.wilayah
			,skk.nama_person as nama_skk
			,skk.nik as nik_skk
			,kry.nama_depan
			,kry.telp_hp as no_skk
			,skw.nama_person as nama_skw
			,skw.nik as nik_skw
			,kry_skw.telp_hp as no_skw
			
			FROM dtl_foto_drone tbl
			LEFT JOIN mst_person_ecadong skk
			ON tbl.rayon = REPLACE(skk.kode_person, 'K', ' ') and skk.flag_person = 'K'
			
			LEFT JOIN mst_person_ecadong skw
			ON tbl.wilayah = REPLACE(skw.kode_person, 'S', ' ') and skw.flag_person = 'S'
			
			LEFT JOIN mst_karyawan_sdm kry
			ON skk.nik = kry.nik
			
			LEFT JOIN mst_karyawan_sdm kry_skw
			ON skw.nik = kry_skw.nik
			
			where tbl.id_drone= '".$id_drone."' 
			ORDER BY tbl.tanggal_foto DESC 
			LIMIT 1
			");
		
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
*Author: Ade
// echo $this->db->last_query();
		// exit;
*/
