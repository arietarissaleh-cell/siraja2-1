<?php

class Debitur_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('mst_debitur_petani_mitani');
		$this->set_pk('id_debitur');
		// $this->set_log(true);
    }
	
	function count()
	{
				
		$this->db->select("count(tbl.*) as num_rows");
		// join ke master Unit
		$this->db->join("public.mst_unit mu","tbl.fid_unit = mu.id_unit","left");
		
		
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
		$this->db->select("
				tbl.*
				
				
				,mu.nama as nama_unit
				,dpm.nama_pemilik as nama_pemilik
				
				,dsm.keterangan as st_escrow
				,slik.keterangan as st_slik
				,sikp.keterangan as st_sikp
				,usaha.keterangan as st_usaha
				
				
				");
				
		
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('public.dtl_pemilik_mitani dpm','tbl.fid_pemilik = dpm.id_pemilik','left');
		//$this->db->join('public.dtl_mitra_petani_mitani dmpm','tbl.id_debitur = dmpm.fid_debitur','left');
		//$this->db->join('public.dtl_kebun_petani_mitani dkpm','tbl.id_debitur = dkpm.fid_debitur','left');
		$this->db->join('public.mst_status_mitani dsm','tbl.status_escrow = dsm.id_status','left');
		$this->db->join('public.mst_status_mitani slik','tbl.slik = slik.id_status','left');
		$this->db->join('public.mst_status_mitani sikp','tbl.sikp = sikp.id_status','left');
		$this->db->join('public.mst_status_mitani usaha','tbl.analisa_usaha_tani = usaha.id_status','left');
		//$this->db->join('public.dtl_mitra_petani_mitani dmpm','tbl.id_debitur = dmpm.fid_debitur and tbl.fid_pemilik = dmpm.fid_pemilik','left');
		//$this->db->join('public.dtl_kebun_petani_mitani dkpm','tbl.id_debitur = dkpm.fid_debitur and tbl.fid_pemilik = dkpm.fid_pemilik ','left');
		
	
		$this->db->order_by("tbl.id_debitur","DESC");
		
		
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
		
			//echo $this->db->last_query(); 665f644e43731ff9db3d341da5c827e1
			//exit;
			
		
		
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
		}else{
			$this->db->where($this->pk_field, $where?:0);
		}
		
		//$this->db->select('tbl.*, js.jenis_surat as jenis_surat
						  
		//				  ');
		// join 
		
		$this->db->select('tbl.*
							,	mu.nama as nama_unit
							,	dpm.nama_pemilik as nama_pemilik
							,	dpm.nik_pemilik as nik_pemilik
							,	kec.nama_kecamatan as nm_kecamatan
							,	kab.nama as nm_kabupaten
							,	prov.nama_provinsi as nm_prov
							
						  ');
		// join 
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('public.dtl_pemilik_mitani dpm','tbl.fid_pemilik = dpm.id_pemilik','left');
		$this->db->join('public.mst_kecamatan kec','tbl.kecamatan = kec.kode_kecamatan','left');
		$this->db->join('public.mst_kabupaten kab','tbl.kabupaten = kab.kode','left');
		$this->db->join('public.mst_provinsi prov','tbl.provinsi = prov.kode_provinsi','left');
			
		
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
	
	function update_slik($id_debitur,$progres,$tanggal_slik,$keterangan){
		//var_dump($id_debitur);
		//die;
		$data = array(
			//'st_approve_kabag' => $status	
			'slik' => $progres	
			,'tgl_slik' => $tanggal_slik	
			,'ket_slik' => $keterangan	
		);
		$this->db->where("id_debitur",$id_debitur);
		$update_data=$this->db->update('public.mst_debitur_petani_mitani', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	
	function update_sikp($id_debitur,$progres,$tanggal_sikp,$keterangan){
		//var_dump($id_debitur);
		//die;
		$data = array(
			//'st_approve_kabag' => $status	
			'sikp' => $progres	
			,'tgl_sikp' => $tanggal_sikp	
			,'ket_sikp' => $keterangan	
		);
		$this->db->where("id_debitur",$id_debitur);
		$update_data=$this->db->update('public.mst_debitur_petani_mitani', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	function update_usaha($id_debitur,$progres_usaha,$keterangan){
		//var_dump($id_debitur);
		//die;
		$tanggal = date('Y-m-d');
		$data = array(
			//'st_approve_kabag' => $status	
			'analisa_usaha_tani' => $progres_usaha	
			,'tgl_usaha' => $tanggal	
			,'ket_usaha' => $keterangan	
		);
		$this->db->where("id_debitur",$id_debitur);
		$update_data=$this->db->update('public.mst_debitur_petani_mitani', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	function update_status_aktif($id_debitur,$update_status,$update_dokumen){
		//var_dump($id_debitur);
		//die;
		$tanggal = date('Y-m-d');
		$data = array(
			//'st_approve_kabag' => $status	
			'status_aktif' => $update_status	
			,'status_update_dokumen' => $update_dokumen	
			
		);
		$this->db->where("id_debitur",$id_debitur);
		$update_data=$this->db->update('public.mst_debitur_petani_mitani', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	function update_escrow($id_debitur,$progres_escrow,$progres_pk,$tanggal_escrow,$nilai_pk,$nilai_escrow,$keterangan,$tanggal_pk){
		//var_dump($id_debitur);
		//die;
		$data = array(
			//'st_approve_kabag' => $status	
			 'status_escrow'	 => $progres_escrow	
			,'status_escrow' 	 => $progres_pk	
			,'tgl_escrow' 	 	 => $tanggal_escrow	
			,'nilai_pk' 		 => $nilai_pk	
			,'nilai_escrow' 	 => $nilai_escrow	
			,'ket_escrow' 	 	 => $keterangan	
			,'tgl_pk' 	 		 => $tanggal_pk	
		);
		$this->db->where("id_debitur",$id_debitur);
		$update_data=$this->db->update('public.mst_debitur_petani_mitani', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	public function getAll() {
		$fid_unit=$this->session->userdata('fid_unit');
		$this->db->select('tbl.*
		
						  ,kec.nama_kecamatan as nama_kecamatan
						  ,kab.nama as nama_kabupaten
						  ,prov.nama_provinsi as nama_provinsi
						  ,mu.nama as nama_unit
			
			');
        
		
		$this->db->from('public.mst_debitur_petani_mitani tbl');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');		
		$this->db->join('public.mst_kecamatan kec','tbl.kecamatan = kec.kode_kecamatan','left');		
		$this->db->join('public.mst_kabupaten kab','tbl.kabupaten = kab.kode','left');		
		$this->db->join('public.mst_provinsi prov','tbl.provinsi = prov.kode_provinsi','left');	
		//$this->db->where('tbl.fid_unit', $fid_unit);
        $query = $this->db->get();
        return $query->result();      
      }
	
	
	
}
/*
*Author: Upri

*/
