<?php

class Validasi_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('dtl_histori_kebun_problem');
		$this->set_pk('id_kebun_problem');
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
		$this->db->select('tbl.*');
		//$this->db->select('mu.nama_usaha');
		//$this->db->join('mst_usaha mu','tbl.kode_usaha = mu.kode','left');
		
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
		
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	
	function update_status($id_drone,$status_kualitas,$keterangan){
		//var_dump($id_debitur);
		//die;
		$create_by						= $this->session->userdata('username'); 
		$tanggal = date('Y-m-d');
		$data = array(
			//'st_approve_kabag' => $status	
			 'status_kualitas' 	=> $status_kualitas	
			,'validasi_date' 	=> $tanggal	
			,'validasi_by'		=> $create_by	
			,'validasi_ket'		=> $keterangan	
		);
		$this->db->where("id_drone",$id_drone);
		$update_data=$this->db->update('public.dtl_foto_drone', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	function update_all($tanggal){
		
		//echo $tanggal;
		//die;
		$create_by						= $this->session->userdata('username'); 
		$tgl = date('Y-m-d');
		$data = array(
			//'st_approve_kabag' => $status	
			
			 'validasi_date' 	=> $tgl	
			,'validasi_by'		=> $create_by	
			,'st_validasi'		=> 1	
		);
		$this->db->where("tanggal_foto",$tanggal);
		$update_data=$this->db->update('public.dtl_foto_drone', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	
	function update_Kabid($id_drone,$keterangan,$nik_kabid,$nik){
		//var_dump($id_debitur);
		//die;
		$create_by						= $this->session->userdata('username'); 
		$tanggal = date('Y-m-d H:i:s');
		$data = array(
			//'st_approve_kabag' => $status	
			 'status' 			=> 2	
			,'kabid_by' 		=> $nik_kabid	
			,'kabid_date'		=> $tanggal	
			,'kabid_catatan'	=> $keterangan	
			,'ca_by'			=> $nik	
		);
		$this->db->where("fid_drone",$id_drone);
		$update_data=$this->db->update('public.dtl_histori_kebun_problem', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	function update_CA($id_drone,$keterangan,$nik){
		//var_dump($id_debitur);
		//die;
		$create_by						= $this->session->userdata('username'); 
		$tanggal = date('Y-m-d H:i:s');
		$data = array(
			//'st_approve_kabag' => $status	
			 'status' 			=> 3	
			
			,'ca_date'		=> $tanggal	
			,'ca_catatan'	=> $keterangan	
			,'skk_by'		=> $nik	
		);
		$this->db->where("fid_drone",$id_drone);
		$update_data=$this->db->update('public.dtl_histori_kebun_problem', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	
	function update_SKK($id_drone,$keterangan,$nik){
		//var_dump($id_debitur);
		//die;
		$create_by						= $this->session->userdata('username'); 
		$tanggal = date('Y-m-d H:i:s');
		$data = array(
			//'st_approve_kabag' => $status	
			 'status' 			=> 4	
			
			,'skk_date'		=> $tanggal	
			,'skk_catatan'	=> $keterangan	
			,'skw_by'		=> $nik	
		);
		$this->db->where("fid_drone",$id_drone);
		$update_data=$this->db->update('public.dtl_histori_kebun_problem', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	function update_SKW($id_drone,$keterangan){
		//var_dump($id_debitur);
		//die;
		$create_by						= $this->session->userdata('username'); 
		$tanggal = date('Y-m-d H:i:s');
		$data = array(
			//'st_approve_kabag' => $status	
			 'status' 			=> 5	
			
			,'skw_date'		=> $tanggal	
			,'skw_catatan'	=> $keterangan	
			
		);
		$this->db->where("fid_drone",$id_drone);
		$update_data=$this->db->update('public.dtl_histori_kebun_problem', $data);
		
		return $update_data;
		//echo $this->db->last_query();
	}
	
	
	public function post_wa_kabid($tanggal){

		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$nik=$this->session->userdata('nik');
		
		//nomor_kabid
		$query_nik_penerima = $this->db->query("SELECT telp_hp, nama_depan FROM public.mst_karyawan_sdm 
			WHERE kode_jabatan='1166' and status_kry_aktif = 1
			
			LIMIT 1");
		$row_nik_penerima = $query_nik_penerima->row_array();
		//$telp_hp = $row_nik_penerima['telp_hp'];
		$nama_depan = $row_nik_penerima['nama_depan'];
		
		$telp_hp ='089650277416';
		
		$sekarang = date('Y-m-d');
		
			
		$query_data_penerima = $this->db->query("SELECT
			fid_unit, nama_unit, count(*) as jumlah_foto
FROM dtl_foto_drone
WHERE tahun_tanam_awal = 2023 and tahun_tanam_akhir = 2024
and status_kualitas in(2,3)
GROUP BY fid_unit, nama_unit
			"
		);
		
$message_anggaan = "[ChatBoot]
*PT. PG Rajawali II*
Validasi date : $sekarang
Anda Mendapatkan Report Kebun dengan Katagori Kerapatan Kebun *KURANG* dan *SEDANG* :\n\n";
	
		
		foreach($query_data_penerima->result() as $row){
			$fid_unit			= $row->fid_unit;
			$nama_unit			= $row->nama_unit;
			$jumlah_foto		= $row->jumlah_foto;
			
			$message_anggaan .= "$nama_unit: $jumlah_foto\n";

		}
			
	$message_anggaan .= "Untuk Melihat Foto Udara Silahkan login ke https://e-siraja.rajawali2.co.id/siRajaPantau/main \n Kemudian klik menu pengamatan drone";		
		
		
		$send_to_admin = $this->wa->send_text_now($telp_hp,$message_anggaan); 
		
	} //end notif WA
	
	
	public function post_wa_ca($tanggal){

		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$nik=$this->session->userdata('nik');
		
		//nomor_kabid
		$query_nik_penerima = $this->db->query("SELECT telp_hp, nama_depan FROM public.mst_karyawan_sdm 
			WHERE kode_jabatan='1166' and status_kry_aktif = 1
			
			LIMIT 1");
		$row_nik_penerima = $query_nik_penerima->row_array();
		//$telp_hp = $row_nik_penerima['telp_hp'];
		$nama_depan = $row_nik_penerima['nama_depan'];
		
		//$telp_hp ='089650277416';
		
		$query_data_penerima = $this->db->query("SELECT
    foto.fid_lokasi_kerja, foto.nama_unit, count(foto.*) as jumlah_foto,
    kry.nama_depan, kry.telp_hp
    FROM dtl_foto_drone foto
    LEFT JOIN mst_karyawan_sdm kry
    ON foto.fid_lokasi_kerja = kry.fid_lokasi_kerja AND kry.status_kry_aktif = 1 
    AND kry.kode_jabatan IN ('1035','1177','1178')
    WHERE foto.tahun_tanam_awal = 2023 AND foto.tahun_tanam_akhir = 2024
    AND foto.status_kualitas IN (2,3)
    GROUP BY foto.fid_lokasi_kerja, foto.nama_unit, kry.nama_depan, kry.telp_hp");

foreach ($query_data_penerima->result() as $row) {
    $fid_lokasi_kerja = $row->fid_lokasi_kerja;
    $nama_unit = $row->nama_unit;
    $jumlah_foto = $row->jumlah_foto;
    $telp_hp = $row->telp_hp;

    $message = "[ChatBoot]\n*PT. PG Rajawali II*\nAnda Mendapatkan Report Kebun dengan Katagori Kerapatan Kebun *KURANG* dan *SEDANG*:\n\n";
    $message .= "$nama_unit: $jumlah_foto\n";

    // Kirim notifikasi ke nomor telepon yang sesuai
    $send_to_admin = $this->wa->send_text_now($telp_hp, $message);
}

	}
	
	
	public function post_wa_skk($tanggal){

		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$nik=$this->session->userdata('nik');
		
		//nomor_kabid
		$query_nik_penerima = $this->db->query("SELECT telp_hp, nama_depan FROM public.mst_karyawan_sdm 
			WHERE kode_jabatan='1166' and status_kry_aktif = 1
			
			LIMIT 1");
		$row_nik_penerima = $query_nik_penerima->row_array();
		//$telp_hp = $row_nik_penerima['telp_hp'];
		$nama_depan = $row_nik_penerima['nama_depan'];
		
		//$telp_hp ='089650277416';
		
		$query_data_penerima = $this->db->query("SELECT
    foto.fid_lokasi_kerja,
    SUM(CASE WHEN foto.status_kualitas = 2 THEN 1 ELSE 0 END) AS jumlah_sedang,
    SUM(CASE WHEN foto.status_kualitas = 3 THEN 1 ELSE 0 END) AS jumlah_kurang,
    foto.kode_rayon_ecadong,
    kry.nama_depan as nama_skk,
    mu.nama as nama_unit,
    kry.telp_hp
FROM dtl_foto_drone foto
LEFT JOIN mst_person_ecadong skk ON foto.kode_rayon_ecadong = CAST(REPLACE(skk.kode_person, 'K', '') AS VARCHAR)
    AND skk.flag_person = 'K'
    AND foto.fid_unit = skk.fid_unit
LEFT JOIN mst_karyawan_sdm kry ON skk.nik = kry.nik
LEFT JOIN mst_unit mu ON mu.id_unit = foto.fid_unit
WHERE foto.tahun_tanam_awal = 2023
    AND foto.tahun_tanam_akhir = 2024
  
GROUP BY foto.fid_lokasi_kerja, foto.kode_rayon_ecadong, kry.nama_depan, kry.telp_hp, mu.nama ;

			
			");

foreach ($query_data_penerima->result() as $row) {
    $fid_lokasi_kerja = $row->fid_lokasi_kerja;
    $jumlah_sedang = $row->jumlah_sedang;
    $jumlah_kurang = $row->jumlah_kurang;
    
    
    $nama_unit = $row->nama_unit;
    $nama_skk = $row->nama_skk;
    $kode_rayon_ecadong = $row->kode_rayon_ecadong;
    $telp_hp = $row->telp_hp;
    $fid_unit = $row->fid_lokasi_kerja;

    $message = "[ChatBoot]\n*PT. PG Rajawali II*\nReport Kebun";
    $message .= "$nama_unit \n Rayon K$kode_rayon_ecadong atas nama $nama_skk \n *Sedang* : *$jumlah_sedang* kebun \n *Kurang* : *$jumlah_kurang* kebun
				";

    // Kirim notifikasi ke nomor telepon yang sesuai
    $send_to_admin = $this->wa->send_text_now($telp_hp, $message);
}

	}
	
	
	public function post_wa_skw($tanggal){

		
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$nik=$this->session->userdata('nik');
		
		//nomor_kabid
		$query_nik_penerima = $this->db->query("SELECT telp_hp, nama_depan FROM public.mst_karyawan_sdm 
			WHERE kode_jabatan='1166' and status_kry_aktif = 1
			
			LIMIT 1");
		$row_nik_penerima = $query_nik_penerima->row_array();
		//$telp_hp = $row_nik_penerima['telp_hp'];
		$nama_depan = $row_nik_penerima['nama_depan'];
		
		//$telp_hp ='089650277416';
		
		$query_data_penerima = $this->db->query("SELECT
    foto.fid_lokasi_kerja,
    SUM(CASE WHEN foto.status_kualitas = 2 THEN 1 ELSE 0 END) AS jumlah_sedang,
    SUM(CASE WHEN foto.status_kualitas = 3 THEN 1 ELSE 0 END) AS jumlah_kurang,
    foto.kode_wilayah_ecadong,
    kry.nama_depan as nama_skk,
    mu.nama as nama_unit,
    kry.telp_hp
FROM dtl_foto_drone foto
LEFT JOIN mst_person_ecadong skk ON foto.kode_wilayah_ecadong = CAST(REPLACE(skk.kode_person, 'S', '') AS VARCHAR)
    AND skk.flag_person = 'S'
    AND foto.fid_unit = skk.fid_unit
LEFT JOIN mst_karyawan_sdm kry ON skk.nik = kry.nik
LEFT JOIN mst_unit mu ON mu.id_unit = foto.fid_unit
WHERE foto.tahun_tanam_awal = 2023
    AND foto.tahun_tanam_akhir = 2024
   
GROUP BY foto.fid_lokasi_kerja, foto.kode_wilayah_ecadong, kry.nama_depan, kry.telp_hp, mu.nama ;

			
			");

foreach ($query_data_penerima->result() as $row) {
    $fid_lokasi_kerja = $row->fid_lokasi_kerja;
    $jumlah_sedang = $row->jumlah_sedang;
    $jumlah_kurang = $row->jumlah_kurang;
    
    
    $nama_unit = $row->nama_unit;
    $nama_skk = $row->nama_skk;
    $kode_wilayah_ecadong = $row->kode_wilayah_ecadong;
    $telp_hp = $row->telp_hp;
    $fid_unit = $row->fid_lokasi_kerja;

    $message = "[ChatBoot]\n*PT. PG Rajawali II*\nReport Kebun";
    $message .= "$nama_unit \n Rayon S$kode_wilayah_ecadong atas nama $nama_skk \n *Sedang* : *$jumlah_sedang* kebun \n *Kurang* : *$jumlah_kurang* kebun
				";

    // Kirim notifikasi ke nomor telepon yang sesuai
    $send_to_admin = $this->wa->send_text_now($telp_hp, $message);
}

	}
	
	
	
	
	
}
/*
*Author: Upray
*/
