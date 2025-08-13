<?php
class Lookup_material_model extends Base_Model {
	var $column_order_list_material = array(null, 'deskripsi', 'nama_golongan', 'nama_konsol');
	var $column_search_list_material = array('UPPER(tbl.deskripsi)','UPPER(nama_golongan)','UPPER(nama_konsol)');

	var $order_list_material = array('deskripsi' => 'asc');

	private function _get_datatables_query_list_material($fid_unit){
		$tahun = date('Y');
		$this->db->select("tbl.*
							, mg.kode as kode_golongan
							, mg.nama as nama_golongan
							, mk.kode as kode_konsol
							, mk.nama as nama_konsol
							, mu.nama as nama_unit
							");
		$this->db->from("public.mst_coa tbl");
		//$this->db->where("tbl.tahun", $tahun);
		//if ($fid_unit != 11){
		$this->db->where("tbl.fid_unit", $fid_unit);
		$this->db->where("tbl.tahun", $tahun);
		$this->db->where("tbl.flag", 'BM');
		//} else {
			
		//}
		

		$this->db->order_by("tbl.kode_coa", "ASC");
		$this->db->join("mst_unit mu", "tbl.fid_unit = mu.id_unit ", "LEFT");
		$this->db->join("mst_golongan mg", "tbl.fid_golongan = mg.id_golongan ", "LEFT");
		$this->db->join("mst_konsol mk", "tbl.fid_konsol = mk.id_konsol ", "LEFT");

		$i = 0;
		foreach ($this->column_search_list_material as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_material) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_material[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_material)){
			$order = $this->order_list_material;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_material($fid_unit){
		$this->_get_datatables_query_list_material($fid_unit);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_material($fid_unit){
		$this->_get_datatables_query_list_material($fid_unit);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_material($fid_unit){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_coa tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		
		return $this->db->get()->num_rows();
	}
	
	
	
}