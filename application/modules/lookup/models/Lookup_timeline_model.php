<?php
class Lookup_timeline_model extends Base_Model {
	var $column_order_list_kebun = array(null, 'kode_pekerjaan');
	var $column_search_list_kebun = array('UPPER(nama_pekerjaan)','UPPER(kode_pekerjaan)');

	var $order_list_kebun = array('kode_pekerjaan' => 'asc');

	private function _get_datatables_query_list_kebun($no_petak,$fid_unit, $tahun_awal, $tahun_akhir){
		
		$kebun = $this->db->query("SELECT dtt.kode_jenjang_tanam, 
										  dtt.luas_netto, 
										  ml.value_char5, 
										  mrk.masa_tanam as mt
									FROM public.dtl_tebu_tanam dtt
									LEFT JOIN public.mst_lookup ml
									ON dtt.kode_jenjang_tanam = ml.kode_lookup and ml.group_lookup = 'jenjang_tanam'
									LEFT JOIN public.mst_rak_kebun mrk
									ON mrk.nopetak = dtt.no_petak and dtt.fid_unit = mrk.fid_unit
									
									WHERE dtt.no_petak='".$no_petak."' and dtt.fid_unit = 17 
									and dtt.tahun_tanam_awal = $tahun_awal
									and dtt.tahun_tanam_akhir = $tahun_akhir
									LIMIT 1");
									
		$row_kebun 				= $kebun->row_array(); 
		$masa_tanam				= strtolower($row_kebun['mt']);
		$kode					= $row_kebun['value_char5'];
		$luas_netto				= $row_kebun['luas_netto'];
		
		if ($kode == 1){
			$biaya ='biaya_trs';
		}else {
			$biaya ='biaya_trt';
		}
		if ($masa_tanam	== NULL || $masa_tanam	== '' ){
			$mt = 'mt_5a';
		}else{
			$mt = "mt_$masa_tanam";
		}
		
		
		
			
			
			
		$this->db->select("kode_pekerjaan, satuan, nama_pekerjaan, $mt as tanggal_rencana, $biaya as biaya_rencana
							
			
			");
		
		// join ke master Unit
		//$this->db->select('mu.nama as nama_unit');
		$this->db->from('dtl_tebu_timeline tbl');
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		
		$this->db->where('tbl.fid_unit',17);
		$this->db->where('tbl.tahun_tanam_awal',$tahun_awal);
		$this->db->where('tbl.tahun_tanam_akhir',$tahun_akhir);
		$this->db->order_by('tbl.kode_pekerjaan ASC');

		$i = 0;
		foreach ($this->column_search_list_kebun as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_kebun) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_kebun[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_kebun)){
			$order = $this->order_list_kebun;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_kebun($no_petak,$fid_unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query_list_kebun($no_petak,$fid_unit, $tahun_awal, $tahun_akhir);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_kebun($no_petak,$fid_unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query_list_kebun($no_petak,$fid_unit, $tahun_awal, $tahun_akhir);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_kebun($no_petak,$fid_unit, $tahun_awal, $tahun_akhir){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_tebu_tanam tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		return $this->db->get()->num_rows();
	}
}