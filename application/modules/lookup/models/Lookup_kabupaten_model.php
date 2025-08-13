<?php
class Lookup_kabupaten_model extends Base_Model {
	var $column_order_list_bank = array(null, 'nama', null);
	var $column_search_list_bank = array('UPPER(tbl.nama)', 'tbl.kode');

	var $order_list_bank = array('nama' => 'asc');

	private function _get_datatables_query_list_bank(){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_kabupaten tbl");
		$this->db->order_by("tbl.nama", "ASC");

		$i = 0;
		foreach ($this->column_search_list_bank as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_bank) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_bank[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_bank)){
			$order = $this->order_list_bank;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_bank(){
		$this->_get_datatables_query_list_bank();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_bank(){
		$this->_get_datatables_query_list_bank();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_bank(){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_kabupaten tbl");
		return $this->db->get()->num_rows();
	}
}