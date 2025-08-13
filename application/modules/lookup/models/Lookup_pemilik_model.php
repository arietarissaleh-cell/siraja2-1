<?php
class Lookup_pemilik_model extends Base_Model {
	var $column_order_list_pemilik = array(null, 'nama', 'nik', 'alamat', null);
	var $column_search_list_pemilik = array('UPPER(tbl.nama)','UPPER(tbl.nik)','UPPER(tbl.alamat)');

	var $order_list_pemilik = array('nama' => 'asc');

	private function _get_datatables_query_list_pemilik($fid_unit){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_petani_mitani tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		$this->db->where("tbl.is_pemilik", 1);

		$this->db->order_by("tbl.nama", "ASC");

		$i = 0;
		foreach ($this->column_search_list_pemilik as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_pemilik) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_pemilik[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_pemilik)){
			$order = $this->order_list_pemilik;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_pemilik($fid_unit){
		$this->_get_datatables_query_list_pemilik($fid_unit);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_pemilik($fid_unit){
		$this->_get_datatables_query_list_pemilik($fid_unit);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_pemilik($fid_unit){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_pemilik_mitani tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		return $this->db->get()->num_rows();
	}
}