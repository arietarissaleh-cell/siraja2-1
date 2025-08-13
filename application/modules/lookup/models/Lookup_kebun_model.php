<?php
class Lookup_kebun_model extends Base_Model {
	var $column_order_list_kebun = array(null, 'no_petak');
	var $column_search_list_kebun = array('UPPER(mtt.nama_kebun)','UPPER(tbl.no_petak)','UPPER(tbl.kode_kebun)');

	var $order_list_kebun = array('no_petak' => 'asc');

	private function _get_datatables_query_list_kebun($fid_unit, $tahun_awal, $tahun_akhir){
		$this->db->select("tbl.*
						   , mtt.nama_kebun as nama_kebun
						   , mtt.rayon
						   , mtt.wilayah
						   , skk.nama_person as nama_skk
						   , skw.nama_person as nama_skw
						   , mu.nama as nama_unit
						   
						   ");
		$this->db->from("public.dtl_tebu_tanam tbl");
		//$this->db->where("tbl.fid_unit", $fid_unit);
		
		$this->db->join('public.mst_unit mu','tbl.fid_unit = mu.id_unit','left');
		$this->db->join('public.mst_tebu_tanam mtt','tbl.no_petak = mtt.no_petak and tbl.fid_unit = mtt.fid_unit and tbl.tahun_tanam_awal = mtt.tahun_tanam_awal and tbl.tahun_tanam_akhir = mtt.tahun_tanam_akhir','left');
		$this->db->join("public.mst_person skk","mtt.rayon = skk.kode_ref and skk.fid_unit = mtt.fid_unit and skk.jabatan = 'SKK'","left");
		$this->db->join("public.mst_person skw","mtt.wilayah = skw.kode_ref and skw.fid_unit = mtt.fid_unit and skw.jabatan = 'SKW'","left");
		$this->db->where("tbl.fid_unit", 17);
		$this->db->where("tbl.tahun_tanam_awal", $tahun_awal);
		$this->db->where("tbl.tahun_tanam_akhir", $tahun_akhir);

		$this->db->order_by("tbl.no_petak", "ASC");

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

	function get_datatables_list_kebun($fid_unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query_list_kebun($fid_unit, $tahun_awal, $tahun_akhir);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_kebun($fid_unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query_list_kebun($fid_unit, $tahun_awal, $tahun_akhir);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_kebun($fid_unit, $tahun_awal, $tahun_akhir){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_tebu_tanam tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		return $this->db->get()->num_rows();
	}
}