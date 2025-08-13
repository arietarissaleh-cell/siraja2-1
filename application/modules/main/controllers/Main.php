<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		//load model disini
		$this->load->model('dashboard_model');
		
	}
	
	public function index()
	{
		// exit;
		// echo('masuk');
		//$today = date("j - M - Y");
		//$id_operator = $this->session->userdata('id_ms_operator');
		$data = array('name' 		=> $this->session->userdata('name')
					,'content' 		=> 'main'
					
					);
		$this->load('tpl',$data['content'], $data);
	}
	
	
	function dashboard()
	{
		//$today = date("j - M - Y");
		$nik = $this->session->userdata('nik');
		
		$data_karyawan = $this->db->query("SELECT kry.nama_depan,bag.deskripsi, kry.fid_lokasi_kerja, kry.kode_jabatan, kry.jenis_kelamin_id, jbt.nama_jabatan FROM public.mst_karyawan_sdm kry
											   LEFT JOIN public.mst_jabatan_sdm jbt ON kry.kode_jabatan = jbt.kode_jabatan
											   LEFT JOIN public.mst_lookup bag ON kry.kode_bagian = bag.kode_lookup
											   WHERE nik='$nik'
											   LIMIT 1");
		$row_data_karyawan = $data_karyawan->row_array(); 
		$nama = $row_data_karyawan['nama_depan']; 
		$gen = $row_data_karyawan['jenis_kelamin_id']; 
		$nama_jabatan = $row_data_karyawan['nama_jabatan']; 
		$kode_jabatan = $row_data_karyawan['kode_jabatan']; 
		$fid_lokasi_kerja = $row_data_karyawan['fid_lokasi_kerja']; 
		$bagian = $row_data_karyawan['deskripsi']; 
		
		// query untuk atasan
		$data_atasan = $this->db->query("SELECT nama_pejabat_kode_surat, nama_jabatan FROM public.mst_kodesurat_jabatan_dms 

											   WHERE kode_penerima_disposisi LIKE '%$kode_jabatan%'
											   LIMIT 1");
		$row_data_atasan = $data_atasan->row_array();
		$nama_atasan = $row_data_atasan['nama_pejabat_kode_surat']; 
		$atasan_jabatan = $row_data_atasan['nama_jabatan']; 
		
		
		$sppd =  $this->dashboard_model->count_sppd();
		$cuti =  $this->dashboard_model->count_cuti();
		$sps  =  $this->dashboard_model->count_sps();
		$do  =  $this->dashboard_model->count_do();
		$surat_masuk  =  $this->dashboard_model->count_surat_masuk();
		$tandatangan  =  $this->dashboard_model->count_tandatangan_keluar();
		$pemerikasa   =  $this->dashboard_model->count_pemerikasa_keluar();
		$disposisi    =  $this->dashboard_model->count_surat_disposisi_masuk();
		$ecadong      =  $this->dashboard_model->count_ecadong();
		$drone        =  $this->dashboard_model->count_drone();
		
		if ($nik =='2015101016'){
			$conten = 'dboard_lahan/list';
		}else {
			$conten = 'main/list';
		}
		
		
		
		
		$data = array('name' 		=> $this->session->userdata('name')
					,'content' 		=> $conten
					,'title' 		=> ''
					,'nik' 			=> $nik
					,'nama' 		=> $nama
					,'sppd' 		=> $sppd
					,'gen' 			=> $gen
					,'cuti' 		=> $cuti
					,'sps' 			=> $sps
					,'do' 			=> $do
					,'surat_masuk' 	=> $surat_masuk
					,'tandatangan' 	=> $tandatangan
					,'pemerikasa' 	=> $pemerikasa
					,'disposisi' 	=> $disposisi
					,'nama_jabatan' => $nama_jabatan
					,'nama_atasan' 	=> $nama_atasan
					,'atasan_jabatan' => $atasan_jabatan
					,'ecadong' 		  => $ecadong
					,'drone' 		  => $drone
					,'bagian' 		  => $bagian
					,'fid_lokasi_kerja' 		  => $fid_lokasi_kerja
					);
		$this->load->view($data['content'], $data);
	}
}
/*
*Author: Rickytarius
28052016
*/
