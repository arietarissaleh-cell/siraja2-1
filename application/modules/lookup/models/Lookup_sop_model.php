<?php
class Lookup_sop_model extends Base_Model {
	var $column_order_list_sop = array(null, 'no_sop', null);
	var $column_search_list_sop = array('UPPER(tbl.no_sop)','UPPER(tbl.perihal_kegiatan)');

	var $order_list_sop = array('no_sop' => 'asc');

	private function _get_datatables_query_list_sop(){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_sop tbl");
		$this->db->order_by("tbl.id_sop", "ASC");
		//$this->db->where("tbl.nama_sop is not NULL");

		$i = 0;
		foreach ($this->column_search_list_sop as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_sop) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_sop[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_sop)){
			$order = $this->order_list_sop;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_sop(){
		$this->_get_datatables_query_list_sop();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_sop(){
		$this->_get_datatables_query_list_sop();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_sop(){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_sop tbl");
		return $this->db->get()->num_rows();
	}
}