<?php
class Lookup_kode_hp_model extends Base_Model {
	var $column_order_list_kode_hp = array(null, 'kode_hp', 'nama', 'alamat', null);
	var $column_search_list_kode_hp = array('UPPER(tbl.kode_hp)','UPPER(tbl.nama)','UPPER(tbl.alamat)');

	var $order_list_kode_hp = array('nama' => 'asc');

	private function _get_datatables_query_list_kode_hp($fid_unit){
		$tahun = date('Y');
		$this->db->select("tbl.*, mu.nama as nama_unit");
		$this->db->from("public.mst_hp tbl");
		$this->db->where("tbl.tahun", $tahun);
		if ($fid_unit != 11){
		$this->db->where("tbl.fid_unit", $fid_unit);
		} else {
			
		}
		

		$this->db->order_by("tbl.nama", "ASC");
		$this->db->join("mst_unit mu", "tbl.fid_unit = mu.id_unit ", "LEFT");

		$i = 0;
		foreach ($this->column_search_list_kode_hp as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_kode_hp) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_kode_hp[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_kode_hp)){
			$order = $this->order_list_kode_hp;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_kode_hp($fid_unit){
		$this->_get_datatables_query_list_kode_hp($fid_unit);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_kode_hp($fid_unit){
		$this->_get_datatables_query_list_kode_hp($fid_unit);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_kode_hp($fid_unit){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_hp tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		
		return $this->db->get()->num_rows();
	}
}