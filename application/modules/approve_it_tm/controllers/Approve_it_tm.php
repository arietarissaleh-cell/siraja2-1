<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_it_tm extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('approve_it_tm_model');
		$this->load->model('approve_atasan_tm/approve_atasan_tm_model');
		$this->load->library('wa');
		
	}
	
	
	public function index()
	{
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'main'
				,'title' 		=> 	'Daftar Karyawan'
		);
		$this->load->view($data['content'],$data);
	}
	
	function filter()
	{
		$unit = $this->unit_model->get_list();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'filter'
				,'title' 		=> 	'Filter Karyawan'
				,'unit' 		=> 	$unit
		);
		$this->load->view($data['content'],$data);
	}
	
	
	
	function page($pg=1)
	{
		$limit = $this->input->post('row_per_page')?:20;
		$where=array();
		$where_unit = '';
		
		$modul['unit'] = ($this->input->post('t_unit'));
		
		if($modul['unit'][0]){
			$i=0;
			
			$where_unit .= '(';
			foreach ($modul['unit'] as $selectedOption)
			{	
				$i++;
				$modul_array[$selectedOption] = $selectedOption;
				
				if($i > 1){
					$where_unit .=" OR ";
				}
				
				$where_unit .="tbl.\"fid_unit\" = '$modul_array[$selectedOption]'";
			}
			
			$where_unit .=')';
			if($modul_array[$selectedOption]=='all'){
				
			}else{
				$where["$where_unit"] = NULL;
			}
		}
		
		$nik = $this->input->post('t_nik');
		$nama = $this->input->post('t_nama');
		
		
		$this->approve_it_tm_model->set_where($where);
		// binding data
		$this->approve_it_tm_model->set_limit($limit);
		$this->approve_it_tm_model->set_offset(($limit) * ($pg - 1));
		
		
		// filtering data
		$like = array();
		//$like['nik'] = $nik;
		//$like['nama_depan'] = $nama;
		$this->approve_it_tm_model->set_like($like);
		
		
		//generate paging
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->approve_it_tm_model->count_unit();
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		
		$fid_lokasi_kerja = $this->session->userdata('fid_lokasi_kerja');
		$nik = $this->session->userdata('nik');
		$history = $this->db->query("SELECT tbl.* , kry.nama_depan as nama_pembuat, kry_pic.nama_depan as nama_pic
								, (case WHEN tbl.status = 0 THEN 'Baru'
									WHEN tbl.status = 1 THEN 'Approved'
									WHEN tbl.status = 2 THEN 'Technical Review'
									WHEN tbl.status = 3 THEN 'Task Preparation'
									WHEN tbl.status = 4 THEN 'In Progress'
									WHEN tbl.status = 5 THEN 'Completed'
									WHEN tbl.status = 6 THEN 'Completed'
									WHEN tbl.status = 7 THEN 'Penanganan Pihan ke 3'
									end) as st
								FROM dtl_task_manager tbl
								
								left join mst_karyawan_sdm kry 
								on kry.nik = tbl.pembuat
								left join mst_karyawan_sdm kry_pic 
								on kry_pic.nik = tbl.pic
								WHERE tbl.status not in ('0', '1', '2') 
								and tbl.fid_unit = $fid_lokasi_kerja 
								and tbl.nik_kabag_it = '$nik' order by tbl.id_tm DESC")->result();
		
		$data = array('karyawan_list' 	=> 	$this->approve_it_tm_model->get_list()
			,'name' 				=> 	$this->session->userdata('name')
			,'content' 				=> 	'approve_it_tm/list'
			
			,'paging'				=> 	$page
			,'history'				=> 	$history
			// ,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);
		
		$this->load->view($data['content'],$data);
		
	}
	
	public function ajax_list(){
            $unit = $this->input->post('unit', TRUE);
            $mt = $this->input->post('mt', TRUE);
            $id_lok = $_SESSION['fid_lokasi_kerja'];
            if($unit == ""){
                  if ($id_lok == "11") {
                        $fid_lokasi_kerja = "in (15, 17, 18)";
                  }else{
                        $fid_lokasi_kerja = "in (".$id_lok.")";
                  }
            }else{
                  $id = implode(', ', $unit);
                  $fid_lokasi_kerja = "in (".$id.")";
            }

            $bulan = date('m');
            $tahun_ini = date("Y");


           /*  if($mt == ""){
                  if ($bulan > 5){
                       // $tahun_awal = date('Y');
                        //$tahun_akhir = date('Y')+1;
						$tahun_awal = 2022;
                        $tahun_akhir = 2023;
                  }else {
                        $tahun_awal = date('Y')-1;
                        $tahun_akhir = date('Y');
                  }
            }else{
                  list($tahun_awal, $tahun_akhir) = explode('/', $mt);
            } */



            $list = $this->approve_it_tm_model->get_datatables($fid_lokasi_kerja);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $approve_it_tm_model) {
                  $edit = '
                  <a href="javascript:void(0);" onclick="inputData(\''.$approve_it_tm_model->id_tm.'\', \''.$approve_it_tm_model->fid_unit.'\')" title="Detail $approve_it_tm_model->kode_tm"><i class="fas fa-list"> Approve</i></a>';
                 

                  $no++;
                  $row = array();
                  $row[] = $no;
                 
                  $row[] = $approve_it_tm_model->kode_tm;
                 
                  $row[] = $approve_it_tm_model->tanggal;
                  
                  $row[] = $approve_it_tm_model->nama_depan;
                  $row[] = $approve_it_tm_model->nama_bagian;
                  $row[] = $approve_it_tm_model->katagori;
                  $row[] = $approve_it_tm_model->keterangan;
                  $row[] = $edit;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->approve_it_tm_model->count_all($fid_lokasi_kerja),
                  "recordsFiltered" => $this->approve_it_tm_model->count_filtered($fid_lokasi_kerja),
                  "data" => $data,
            );
            echo json_encode($output);
      }
	
	
	function detail($id)
	{
		
		
		$data_tm = $this->approve_atasan_tm_model->getDetail($id);
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('name')
				,'content' 			 => 'approve_it_tm/detail'
				,'title' 			 => $id?'Detail '.$data_tm['kode_tm']:'Input Baru'
				
				,'data_tm'		 => $data_tm
		);
		
		$this->load->view($data['content'],$data);
	}

	
	
	function delete($id)
	{
		//$id = decode($id);
		$query	= $this->approve_it_tm_model->delete($id);
		    
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
	
	function input($id=0)
	{
		
		$data_tm = $this->approve_it_tm_model->getDetail($id);
		$id_ms_operator=$this->session->userdata('id_ms_operator');
		$nik=$this->session->userdata('nik');
		
		//query untuk mendapatkan fid_unit dari ms_operator berdasarkan session id_ms_operator
		$query_it = $this->db->query("SELECT tbl.kode_penerima_disposisi FROM public.mst_kodesurat_jabatan_dms tbl
											   
											   WHERE tbl.kode_jabatan='1005'
											   LIMIT 1");
		$row_it 		= $query_it->row_array(); 
		$dispo		 	= $row_it['kode_penerima_disposisi'];


       $disposisi_surat = explode(',',$dispo);
       $surat_dispo = implode("','",$disposisi_surat);
	   
	   
	   $query_nama_jabatan = $this->db->query("SELECT
            kry.nik,
            kry.nama_depan,
            kry.kode_jabatan,
            jbt.nama_jabatan

            FROM
            PUBLIC.mst_karyawan_sdm kry
            LEFT JOIN PUBLIC.mst_jabatan_sdm jbt
            ON kry.kode_jabatan = jbt.kode_jabatan
            WHERE
            kry.kode_jabatan  IN ('".$surat_dispo."' )
                AND kry.status_kry_aktif = 1 
                ORDER BY jbt.nomor_urut asc
                ");
		
		
		 
		
		
		//$fid_unit=$this->session->userdata('fid_unit');
		
		
		//$this->page();
		$data = array('name' 		 => $this->session->userdata('nik')
		,'content' 			 => 'approve_it_tm/input'
		
		,'data_tm' 	 	 	 => $data_tm
		,'query_nama_jabatan' 	 	 	 => $query_nama_jabatan 
		
		
		
		
		);
		
		$this->load->view($data['content'],$data);
	}
	
	
	function save()
	{
		
		$this->db->trans_start();
		//$detail_data = $this->approve_it_tm_model->getDetail($id);
		
		$fid_lokasi_kerja					= $this->session->userdata('fid_lokasi_kerja');
		$id_tm								= ($this->input->post('id_tm'));
		$catatan_it							= ($this->input->post('catatan_it'));
		$pic								= ($this->input->post('pic'));
		$sla								= ($this->input->post('level_sla'));
		$tanggal							= date('Y-m-d H:i:s');
		$update = $this->db->query("UPDATE dtl_task_manager SET catatan_kabag_it = '$catatan_it', level_sla = '$sla', kabag_it_approve_date = '$tanggal', status = 3, pic ='$pic' WHERE id_tm = '$id_tm'");
		
		$send_wa = $this->approve_it_tm_model->post_wa($id_tm);
		
		$result = array();
		$this->db->trans_complete();
		if ($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->error('Proses gagal');
			$result['sukses'] = 0;
			echo json_encode($result);
			
		}else{
			$result['sukses'] = 1;
			//$this->update['id_tm'] = ($save);
			$result['success_upload'] = 1;
				$result['upload'] = 'File Successfully Uploaded';
				
				$result['pesan'] = 'Berhasil Terkirim';
			$this->db->trans_commit();
			
			echo json_encode($result); 
			//redirect($this->uri->uri_string());
		}
			
		
		
	}
	
	
}
/*
*Author: Upray
*/

