<?php

class Perlu_tl_model extends Base_Model {
	var $column_order = array(null, 'kode_tm', 'keterangan', null, null);
	var $column_search = array('UPPER(tbl.kode_tm)', 'UPPER(tbl.bagian)', 'UPPER(tbl.keterangan)');
	var $order = array('tbl.kode_tm' => 'asc');

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('dtl_task_manager');
		$this->set_pk('id_tm');
		// $this->set_log(true);
    }
	
	private function _get_datatables_query($id_unit){
		
		$nik = $this->session->userdata('nik');

		$this->db->select("tbl.*");

		$this->db->from($this->schema.".".$this->table. " tbl");

		//$this->db->join("public.mst_tebu_tanam mtt", "mtt.no_petak = tbl.nopetak and mtt.fid_unit = tbl.fid_unit", "LEFT");
		//$this->db->join("public.dtl_tebu_tanam dtt", "dtt.no_petak = tbl.nopetak and dtt.fid_unit = tbl.fid_unit", "LEFT");
		//$this->db->join("public.mst_unit unit", "unit.id_unit = tbl.fid_unit", "LEFT");
		//$this->db->join("public.mst_lookup st", "dtt.kode_status_lahan = st.kode_lookup", "LEFT");

		//$this->db->where("tbl.fid_unit $id_unit");

		//$this->db->where("dtt.tahun_tanam_awal", $tahun_awal);
		//$this->db->where("dtt.tahun_tanam_akhir", $tahun_akhir);
		//$this->db->group_by("tbl.kodekebun,  tbl.fid_unit,tbl.nobukti, tbl.no_truk,tbl.nopetak, mtt.nama_kebun, mtt.rayon, mtt.wilayah, mtt.tahun_tanam_awal
			//		, mtt.tahun_tanam_akhir, dtt.luas_netto, st.deskripsi");
		
		$this->db->where("tbl.pic", $nik);
		$this->db->where("tbl.status", 3);
		$this->db->order_by("tbl.id_tm", "ASC");

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

	function get_datatables($id_unit){
		$this->_get_datatables_query($id_unit);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_unit){
		$this->_get_datatables_query($id_unit);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all($id_unit){
		$nik = $this->session->userdata('nik');
		$this->db->select("tbl.*");

		$this->db->from($this->schema.".".$this->table. " tbl");

		//$this->db->join("public.mst_tebu_tanam mtt", "mtt.no_petak = tbl.nopetak and mtt.fid_unit = tbl.fid_unit", "LEFT");
		//$this->db->join("public.dtl_tebu_tanam dtt", "dtt.no_petak = tbl.nopetak and dtt.fid_unit = tbl.fid_unit", "LEFT");
		//$this->db->join("public.mst_unit unit", "unit.id_unit = tbl.fid_unit", "LEFT");

		//$this->db->where("tbl.fid_unit $id_unit");

		//$this->db->where("mtt.tahun_tanam_awal", $tahun_awal);
		//$this->db->where("mtt.tahun_tanam_akhir", $tahun_akhir);
		$this->db->where("tbl.pic", $nik);
		$this->db->where("tbl.status", 3);
		$this->db->order_by("tbl.id_tm", "ASC");

		return $this->db->get()->num_rows();
	}
	
    function count()
	{
		$nik = $this->session->userdata('nik');
		$this->db->select('count(tbl.*) as num_rows');
		// join ke master Unit
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		
		$this->db->where("tbl.pic", $nik);
		$this->db->where("tbl.status", 3);
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
		$tahun = 2023;
		$unit = 15;
		$this->db->select('tbl.*');
		// join ke master Unit
		$this->db->select('mu.nama as nama_unit');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->order_by("id_tm", "asc");
		//$this->db->where('tbl.tahun',$tahun);
		$this->db->where('tbl.fid_unit',$unit);
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
	
	public function noTiket(){
		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_unit = $this->db->query('SELECT fid_unit, fid_lokasi_kerja FROM public.ms_operator_sdm 
											   WHERE id_ms_operator='.$id_ms_operator.'
											   LIMIT 1');
		$row_unit = $query_unit->row_array();
		
		$q = $this->db->query("SELECT
								MAX (RIGHT(kode_tm, 3)) as kd_max
							FROM
								public.dtl_task_manager
							WHERE
								tanggal IN (
									SELECT
										MAX (tanggal)
									FROM
										public.dtl_task_manager
									WHERE
										tanggal = CURRENT_DATE and fid_unit=".$row_unit['fid_lokasi_kerja']."
							)");
		$kd = "";
		$tahun = date('Y'); 
		$bulan = date('m'); 
		$hari = date('d'); 
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%03s", $tmp);
			}
		}else{
			$kd = "001";
		}	
		return "IT/".$row_unit['fid_lokasi_kerja']."/".$tahun."/".$bulan."/".$hari.".".$kd;
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
		$this->db->select('mu.nama as nama_unit, kry.nama_depan as nama_pembuat, ats.nama_depan as nama_atasan
						
			');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('public.mst_karyawan_sdm kry','tbl.pembuat = kry.nik','left');
		$this->db->join('public.mst_karyawan_sdm ats','tbl.atasan = ats.nik','left');
		
		
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
	
	
	public function post_wa_done($id_tm){

		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		
		//var_dump($no_hp_kabag);
		
		//echo $no_hp_kabag;
		
		$query_data_penerima = $this->db->query("SELECT
			

			tbl.kode_tm
			,tbl.pembuat
			,tbl.katagori
			,tbl.tipe
			,tbl.keterangan
			,tbl.create_date
			,tbl.create_by
			
			,kry_ats.telp_hp as tlpn_atasan
			,pembuat.telp_hp as tlpn_user
			
			FROM dtl_task_manager tbl
			LEFT JOIN mst_karyawan_sdm kry_ats
			ON tbl.atasan = kry_ats.nik and tbl.fid_unit = kry_ats.fid_lokasi_kerja and kry_ats.status_kry_aktif = 1
			LEFT JOIN mst_karyawan_sdm pembuat
			ON tbl.pembuat = pembuat.nik and tbl.fid_unit = pembuat.fid_lokasi_kerja and pembuat.status_kry_aktif = 1

			
			
			where tbl.id_tm= '".$id_tm."'  
			"
		);
		
		
		foreach($query_data_penerima->result() as $row){
			$kode_tm		= $row->kode_tm;
			
			$katagori			= $row->katagori;
			$tipe				= $row->tipe;
			$create_by			= $row->create_by;
			$keterangan			= $row->keterangan;
			$create_date		= $row->create_date;
			
			
			$tlpn_atasan		= $row->tlpn_atasan;
			$tlpn_user			= $row->tlpn_user;
			
			$message_anggaan="Anda Mendapatkan Konfirmasi Selesai Task Management :

			No Tiket        : *$kode_tm*
			Pembuat  		: *$create_by*
			Katagori		: *$katagori*
			Merk/Tipe/Spesifikasi		    : *$tipe* 
			Ringkasan Permintaan / Permasalahan		    : *$keterangan* 
			
			Untuk Melihat detail Silahkan login ke *http://e-siraja.rajawali2.co.id/siraja*
			" ;
			//echo $telp_hp;
			$telp_kry = $tlpn_user;
			if ($telp_kry <> null && $telp_kry <> 0){
				$send_to_admin = $this->wa->send_text_now($telp_kry,$message_anggaan); 
			} 
			
			$telp_ats = $tlpn_atasan;
			if ($telp_ats <> null && $telp_ats <> 0){
				$send_to_admin = $this->wa->send_text_now($telp_ats,$message_anggaan); 
			} 
			
			
		}
		// echo $this->db->last_query();



	} //end notif WA
	
	public function post_wa_proses($id_tm){

		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		
		
		//var_dump($no_hp_kabag);
		
		//echo $no_hp_kabag;
		
		$query_data_penerima = $this->db->query("SELECT
			

			tbl.kode_tm
			,tbl.pembuat
			,tbl.katagori
			,tbl.tipe
			,tbl.keterangan
			,tbl.create_date
			,tbl.create_by
			
			,kbg_it.telp_hp as tlpn_atasan
			,pembuat.telp_hp as tlpn_user
			
			FROM dtl_task_manager tbl
			LEFT JOIN mst_karyawan_sdm kbg_it
			ON tbl.nik_kabag_it = kbg_it.nik and tbl.fid_unit = kbg_it.fid_lokasi_kerja and kbg_it.status_kry_aktif = 1
			LEFT JOIN mst_karyawan_sdm pembuat
			ON tbl.pembuat = pembuat.nik and tbl.fid_unit = pembuat.fid_lokasi_kerja and pembuat.status_kry_aktif = 1

			
			
			where tbl.id_tm= '".$id_tm."'  
			"
		);
		
		
		foreach($query_data_penerima->result() as $row){
			$kode_tm		= $row->kode_tm;
			
			$katagori			= $row->katagori;
			$tipe				= $row->tipe;
			$create_by			= $row->create_by;
			$keterangan			= $row->keterangan;
			$create_date		= $row->create_date;
			
			
			$tlpn_atasan		= $row->tlpn_atasan;
			$tlpn_user			= $row->tlpn_user;
			
			$message_anggaan="Anda Mendapatkan Konfirmasi Selesai Task Management :

			No Tiket        : *$kode_tm*
			Pembuat  		: *$create_by*
			Katagori		: *$katagori*
			Merk/Tipe/Spesifikasi		    : *$tipe* 
			Ringkasan Permintaan / Permasalahan		    : *$keterangan* 
			
			Untuk Melihat detail Silahkan login ke *http://e-siraja.rajawali2.co.id/siraja*
			" ;
			//echo $telp_hp;
			$telp_kry = $tlpn_user;
			if ($telp_kry <> null && $telp_kry <> 0){
				$send_to_admin = $this->wa->send_text_now($telp_kry,$message_anggaan); 
			} 
			
			$telp_ats = $tlpn_atasan;
			if ($telp_ats <> null && $telp_ats <> 0){
				$send_to_admin = $this->wa->send_text_now($telp_ats,$message_anggaan); 
			} 
			
			
		}
		// echo $this->db->last_query();



	} //end notif WA
	
}
/*
*Author: Uprayy
*/
