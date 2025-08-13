<?php

class Dashboard_model extends Base_Model {

	function __construct() {

		parent::__construct();
		$this->set_schema('public');
		$this->set_table('dtl_cadongan');
	}
	
	function count_sppd(){
		$nik = $this->session->userdata('nik');
		$this->db->select("tbl.*");
		$this->db->where('tbl.status_sppd', 1);
		$this->db->where("tbl.nik_atasan", $nik);
		//$this->db->where("tbl.status_draft = 1");
		
		//$this->db->where("tbl.tahun='".date('Y')."'");
		$query = $this->db->get($this->schema.'.'.'dtl_data_sppd_sdm'.' tbl');
		return count($query->result());
		// echo "<pre>";
		// echo var_dump($query->result());
		// // $data = $query->row_array();
		// // return $data['num_rows'];
	}
	
	function count_cuti(){
		$nik = $this->session->userdata('nik');
		$this->db->select("tbl.*");
		$this->db->where('tbl.status', '1');
		$this->db->where("tbl.nik_atasan", $nik);
		//$this->db->where("tbl.status_draft = 1");
		
		//$this->db->where("tbl.tahun='".date('Y')."'");
		$query = $this->db->get($this->schema.'.'.'dtl_data_cuti_sdm'.' tbl');
		return count($query->result());
		// echo "<pre>";
		// echo var_dump($query->result());
		// // $data = $query->row_array();
		// // return $data['num_rows'];
	}
	
	
	function count_sps(){
		$nik = $this->session->userdata('nik');
		
		$data_karyawan = $this->db->query("SELECT kode_jabatan, nama_depan, jenis_kelamin_id FROM public.mst_karyawan_sdm 
											   WHERE nik='$nik'
											   LIMIT 1");
		$row_data_karyawan = $data_karyawan->row_array(); 
		$jabatan = $row_data_karyawan['kode_jabatan']; 
		
		$this->db->select("tbl.*");
		if ($jabatan == '1011'){
		$this->db->where('tbl.status_approve', '0');
		}else if ($jabatan == '1009'){
		$this->db->where('tbl.status_approve', '1');
		}else if ($jabatan == '1001'){
		$this->db->where('tbl.status_approve', '2');
		}else if ($jabatan == '1167'){
		$this->db->where('tbl.status_approve', '3');
		}else {
		$this->db->where('tbl.status_approve', '5');
		}
		//$this->db->where("tbl.nik_atasan", $nik);
		//$this->db->where("tbl.status_draft = 1");
		
		//$this->db->where("tbl.tahun='".date('Y')."'");
		$query = $this->db->get($this->schema.'.'.'mst_penjualan_sps'.' tbl');
		return count($query->result());
		// echo "<pre>";
		// echo var_dump($query->result());
		// // $data = $query->row_array();
		// // return $data['num_rows'];
	}
	
	function count_do(){
		$nik = $this->session->userdata('nik');
		
		$data_karyawan = $this->db->query("SELECT kode_jabatan, nama_depan, jenis_kelamin_id FROM public.mst_karyawan_sdm 
											   WHERE nik='$nik'
											   LIMIT 1");
		$row_data_karyawan = $data_karyawan->row_array(); 
		$jabatan = $row_data_karyawan['kode_jabatan']; 
		
		$this->db->select("tbl.*");
		if ($jabatan == '1011'){
		$this->db->where('tbl.st_approve', '0');
		}else if ($jabatan == '1009'){
		$this->db->where('tbl.st_approve', '1');
		}else {
		$this->db->where('tbl.st_approve', '5');
		}
		//$this->db->where("tbl.nik_atasan", $nik);
		//$this->db->where("tbl.status_draft = 1");
		
		//$this->db->where("tbl.tahun='".date('Y')."'");
		$query = $this->db->get($this->schema.'.'.'dtl_penjualan_hasil'.' tbl');
		return count($query->result());
		// echo "<pre>";
		// echo var_dump($query->result());
		// // $data = $query->row_array();
		// // return $data['num_rows'];
	}
	
	
	function count_surat_masuk(){
		$this->db->select("tbl.tembusan, tbl.nik_tembusan, tbl.st_tandatangan, tbl.nik_tujuan_surat, tbl.status_draft, tbl.status_disposisi");
		$nik=$this->session->userdata('nik');
		$query_surat 		= $this->db->query("SELECT tbl.kode_jabatan, jbt.id_kodesurat_jabatan FROM public.mst_karyawan_sdm tbl
			LEFT JOIN public.mst_kodesurat_jabatan_dms jbt
			ON tbl.kode_jabatan = jbt.kode_jabatan
			WHERE nik='".$nik."'
			LIMIT 1");
		$row_surat = $query_surat->row_array();
		$id_kodesurat_jabatan = $row_surat['id_kodesurat_jabatan'];
		
		// join ke master Unit
		//$this->db->join('public.mst_unit unit_gudang','tbl.fid_unit_gudang = unit_gudang.id_unit','left');
		//$this->db->where('tbl.fid_unit=11');
		//$this->db->where('tbl.jenis_surat=3');
		//$this->db->where("tbl.status_tembusan ='1'");
		$this->db->where("status_draft = '1'");
		$this->db->where("tbl.nik_tujuan_surat LIKE '%$nik%'");
		
		$this->db->where("tbl.tahun='".date('Y')."'");
		
		//$this->db->order_by("tbl.id_surat", "desc");
		if($this->like)
			$this->db->like($this->like);
		if($this->where)
			$this->db->where($this->where);
		$query = $this->db->get($this->schema.'.'.'dtl_surat_dms'.' tbl');
		// echo $this->db->last_query();
		// exit;
		$data = $query->result();
		// echo "<pre>";
		 //echo var_dump($data);
		 //die;
		
		for ($jumlah_data=0; $jumlah_data < count($data); $jumlah_data++) { 
			$nik_tembusan = explode(",", $data[$jumlah_data]->nik_tujuan_surat);
			$status_drafnya = explode(",",$data[$jumlah_data]->status_disposisi);

			for ($tembusan=0; $tembusan < count($nik_tembusan); $tembusan++) { 
				if ($nik_tembusan[$tembusan] == $_SESSION['nik']) {
					if($status_drafnya[$tembusan] == 1){
						$data[$jumlah_data]->status_disposisi = 1;
					}else if($status_drafnya[$tembusan] != 1){
						$data[$jumlah_data]->status_disposisi = 0;
					}
				} else {
					
				}
			}
		}

		$sum_tembusan = 0;
		
		foreach($data as $dt => $v){
			if ($v->status_disposisi === intval(0)) {
				unset($data[$dt]);
			}
		}

		foreach($data as $dt){
			$sum_tembusan += $dt->status_disposisi;
		}

		return $sum_tembusan;
	}
	
	
	function count_tandatangan_keluar(){
		$this->db->select("tbl.tandatangan_surat1, tbl.nik_tandatangan, tbl.st_tandatangan");
		$nik=$this->session->userdata('nik');
		$query_surat 		= $this->db->query("SELECT tbl.kode_jabatan, jbt.id_kodesurat_jabatan FROM public.mst_karyawan_sdm tbl
			LEFT JOIN public.mst_kodesurat_jabatan_dms jbt
			ON tbl.kode_jabatan = jbt.kode_jabatan
			WHERE nik='".$nik."'
			LIMIT 1");
		$row_surat			= $query_surat->row_array();
		$id_kodesurat_jabatan 		= $row_surat['id_kodesurat_jabatan'];
		
		// join ke master Unit
		//$this->db->join('public.mst_unit unit_gudang','tbl.fid_unit_gudang = unit_gudang.id_unit','left');
		//$this->db->where('tbl.fid_unit=11');
		$this->db->where('tbl.status_draft=5');
		$this->db->where('tbl.nik_tandatangan', $nik);
		
		$this->db->where("tbl.tahun='".date('Y')."'");
		//$this->db->from('dtl_disposisi_dms tbl');
		
		//$this->db->order_by("tbl.id_surat", "desc");
		if($this->like)
			$this->db->like($this->like);
		if($this->where)
			$this->db->where($this->where);
		$query = $this->db->get($this->schema.'.'.'dtl_surat_dms'.' tbl');
		// echo $this->db->last_query();
		// exit;
		$data = $query->result();

		for ($jumlah_data=0; $jumlah_data < count($data); $jumlah_data++) { 
			$nik_tandatangan = explode(",", $data[$jumlah_data]->nik_tandatangan);
			$status_tandatangannya = explode(",", $data[$jumlah_data]->st_tandatangan);

			for ($tandatangan=0; $tandatangan < count($nik_tandatangan); $tandatangan++) { 
				if ($nik_tandatangan[$tandatangan] == $_SESSION['nik']) {
					// Belum tandatangan
					if($status_tandatangannya[$tandatangan] == 1){
						$data[$jumlah_data]->status_tandatangannya = 1;
					// Sudah tandatangan
					}else if($status_tandatangannya[$tandatangan] != 1){
						$data[$jumlah_data]->status_tandatangannya = 0;
					}
				}
			}
		}

		$sum_tandatangan = 0;

		foreach($data as $dt){
			$sum_tandatangan += $dt->status_tandatangannya;
		}

		return $sum_tandatangan;
	}
	
	
	function count_pemerikasa_keluar(){
		$this->db->select("tbl.kode_pemeriksa, tbl.nik_pemeriksa, tbl.status_pemeriksa, tbl.status_draft, tbl.index_pemeriksa");
		$nik = $this->session->userdata('nik');
		$query_surat = $this->db->query("SELECT tbl.kode_jabatan, jbt.id_kodesurat_jabatan FROM public.mst_karyawan_sdm tbl
			LEFT JOIN public.mst_kodesurat_jabatan_dms jbt
			ON tbl.kode_jabatan = jbt.kode_jabatan
			WHERE nik='".$nik."'
			LIMIT 1");
		$row_surat			= $query_surat->row_array();
		$id_kodesurat_jabatan 		= $row_surat['id_kodesurat_jabatan'];
		
		$this->db->where("tbl.status_draft",4);
		$this->db->where("tbl.nik_pemeriksa LIKE '%$nik%'");
		
		$this->db->where("tbl.tahun='".date('Y')."'");
		
		if($this->like)
			$this->db->like($this->like);
		if($this->where)
			$this->db->where($this->where);
		$query = $this->db->get($this->schema.'.'.'dtl_surat_dms'.' tbl');
		$data = $query->result();

		for ($jumlah_data=0; $jumlah_data < count($data); $jumlah_data++) { 
			$nik_pemeriksa = explode(",", $data[$jumlah_data]->nik_pemeriksa);
			$st_pemeriksa= explode(",", $data[$jumlah_data]->status_pemeriksa);
			$index_pem = $data[$jumlah_data]->index_pemeriksa;

			for ($disposisi=0; $disposisi < count($nik_pemeriksa); $disposisi++) { 
				/* if ($nik_pemeriksa[$disposisi] == $_SESSION['nik']) {
					// Belum diperiksa
					if($status_pemeriksanya[$disposisi] == 1){
						$data[$jumlah_data]->status_pemeriksanya = 1;
					// Sudah periksa
					}else if($status_pemeriksanya[$disposisi] != 1){
						$data[$jumlah_data]->status_pemeriksanya = 0;
					}
				} */
				
				if ($nik_pemeriksa[$disposisi] == $_SESSION['nik']) {
					if($disposisi==$index_pem && $st_pemeriksa[$disposisi] == "1"){
						$data[$jumlah_data]->status_pemeriksanya = 1;
						$data[$jumlah_data]->status_periksa = '<img src="/siRajaDMS/assets/images/belum_dibaca.png" title="Belum DiApprove" style="width:30px;height:30px;"> Belum DiApprove';
					}else if($disposisi==$index_pem && $st_pemeriksa[$disposisi] == "2"){
						$data[$jumlah_data]->status_pemeriksanya = 0;
						$data[$jumlah_data]->status_periksa = '<i class="fas fa-check-double"></i>';
					}else if($disposisi==$index_pem && $st_pemeriksa[$disposisi] == "3"){
						// Bikin 1 array kalo Koreksi isi nya 1
						$data[$jumlah_data]->status_pemeriksanya = 1;
						$data[$jumlah_data]->status_periksa = '<i class="fas fa-exclamation"></i>';
					}else {
						// Bikin 1 array kalo Koreksi isi nya 1
						$data[$jumlah_data]->status_pemeriksanya = 0;
						$data[$jumlah_data]->status_periksa = '<i class="fas fa-exclamation"></i>';
					}
					
				}else{
						//$data[$jumlah_data]->status_pemeriksanya = 0;
				}
				
				
			}
		}

		$sum_pemeriksa = 0;

		foreach($data as $dt){
			$sum_pemeriksa += $dt->status_pemeriksanya;
		}

		return $sum_pemeriksa;
	}
	
	function count_surat_disposisi_masuk(){
		$this->db->select("tbl.*");
		$nik=$this->session->userdata('nik');
		$query_surat 		= $this->db->query("SELECT tbl.kode_jabatan, jbt.id_kodesurat_jabatan FROM public.mst_karyawan_sdm tbl
			LEFT JOIN public.mst_kodesurat_jabatan_dms jbt
			ON tbl.kode_jabatan = jbt.kode_jabatan
			WHERE nik='".$nik."'
			LIMIT 1");
		$row_surat			= $query_surat->row_array();
		$id_kodesurat_jabatan 		= $row_surat['id_kodesurat_jabatan'];
		$this->db->where("tbl.nik_penerima LIKE '%$nik%'");
		$this->db->where("tbl.nomor_surat != ", "");
		//$this->db->or("tbl.nomor_surat != ", null);
		$this->db->where("tbl.tahun='".date('Y')."'");
		
		if($this->like)
			$this->db->like($this->like);
		if($this->where)
			$this->db->where($this->where);
		$query = $this->db->get($this->schema.'.'.'dtl_disposisi_dms'.' tbl');
		$data = $query->result();

		for ($jumlah_data=0; $jumlah_data < count($data); $jumlah_data++) { 
			$nik_penerima = explode(",", $data[$jumlah_data]->nik_penerima);
			$status_disposisinya = explode(",", $data[$jumlah_data]->status_disposisi);

			for ($disposisi=0; $disposisi < count($nik_penerima); $disposisi++) { 
				if ($nik_penerima[$disposisi] == $_SESSION['nik']) {
					// Belum disposisi
					if($status_disposisinya[$disposisi] == 1 || $status_disposisinya[$disposisi] == "3" || $status_disposisinya[$disposisi] == "7"){
						$data[$jumlah_data]->status_disposisinya = 1;
					// Sudah disposisi
					}else if($status_disposisinya[$disposisi] != 1 || $status_disposisinya[$disposisi] != "3" || $status_disposisinya[$disposisi] != "7"){
						$data[$jumlah_data]->status_disposisinya = 0;
					}
				}
			}
		}

		$sum_disposisi = 0;

		foreach($data as $dt){
			$sum_disposisi += $dt->status_disposisinya;
		}

		return $sum_disposisi;
	}
	
	function count_ecadong(){
		$nik = $this->session->userdata('nik');
		
		$data_karyawan = $this->db->query("SELECT kode_jabatan, nama_depan, fid_lokasi_kerja,jenis_kelamin_id FROM public.mst_karyawan_sdm 
											   WHERE nik='$nik'
											   LIMIT 1");
		$row_data_karyawan = $data_karyawan->row_array(); 
		$jabatan = $row_data_karyawan['kode_jabatan']; 
		$fid_lokasi_kerja = $row_data_karyawan['fid_lokasi_kerja']; 
		
		$this->db->select("tbl.*");
		if ($jabatan == '1118'){
		$this->db->where('tbl.status_approve', '0');
		$this->db->where('tbl.fid_lokasi_kerja', $fid_lokasi_kerja);
		}else if ($jabatan == '1022' || $jabatan == '1173'|| $jabatan == '1174'){
		$this->db->where('tbl.status_approve', '1');
		$this->db->where('tbl.fid_lokasi_kerja', $fid_lokasi_kerja);
		}else if ($jabatan == '1035' ){
		$this->db->where('tbl.status_approve', '2');
		$this->db->where('tbl.fid_lokasi_kerja', $fid_lokasi_kerja);
		}else {
		$this->db->where('tbl.status_approve', '7');
		}
		//$this->db->where("tbl.nik_atasan", $nik);
		//$this->db->where("tbl.status_draft = 1");
		
		//$this->db->where("tbl.tahun='".date('Y')."'");
		$query = $this->db->get($this->schema.'.'.'dtl_cadongan'.' tbl');
		return count($query->result());
		// echo "<pre>";
		// echo var_dump($query->result());
		// // $data = $query->row_array();
		// // return $data['num_rows'];
	}
	
	function count_drone(){
		$nik = $this->session->userdata('nik');
		
		$data_karyawan = $this->db->query("SELECT kode_jabatan, nama_depan, fid_lokasi_kerja,jenis_kelamin_id FROM public.mst_karyawan_sdm 
											   WHERE nik='$nik'
											   LIMIT 1");
		$row_data_karyawan = $data_karyawan->row_array(); 
		$jabatan = $row_data_karyawan['kode_jabatan']; 
		$fid_lokasi_kerja = $row_data_karyawan['fid_lokasi_kerja']; 
		
		$this->db->select("tbl.*");
		if ($jabatan == '1005'){
		$this->db->where('tbl.st_validasi', '0');
		}else {
		$this->db->where('tbl.st_validasi', '7');
		}
		//$this->db->where("tbl.nik_atasan", $nik);
		//$this->db->where("tbl.status_draft = 1");
		
		//$this->db->where("tbl.tahun='".date('Y')."'");
		$query = $this->db->get($this->schema.'.'.'dtl_foto_drone'.' tbl');
		return count($query->result());
		// echo "<pre>";
		// echo var_dump($query->result());
		// // $data = $query->row_array();
		// // return $data['num_rows'];
	}
}

