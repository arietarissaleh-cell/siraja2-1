<?php
class Lookup_direksi_model extends Base_Model {
	var $column_order_list_direksi = array(null, 'nama_direktorat', null);
	var $column_search_list_direksi = array('UPPER(tbl.nama_direktorat)');

	var $order_list_direksi = array('id_direktorat' => 'asc');

	private function _get_datatables_query_list_direksi(){
		$this->db->select("tbl.id_direktorat, tbl.nama_direktorat");
		$this->db->from("public.mst_direktorat_dms tbl");
		$this->db->order_by("tbl.id_direktorat", "ASC");
		$this->db->where("tbl.status_dir", 1);

		$i = 0;
		foreach ($this->column_search_list_direksi as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_direksi) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_direksi[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_direksi)){
			$order = $this->order_list_direksi;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_direksi(){
		$this->_get_datatables_query_list_direksi();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_direksi(){
		$this->_get_datatables_query_list_direksi();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_direksi(){
		$this->db->select("tbl.id_direktorat, tbl.nama_direktorat");
		$this->db->from("public.mst_direktorat_dms tbl");
		return $this->db->get()->num_rows();
	}
}