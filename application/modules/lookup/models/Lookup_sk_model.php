<?php
class Lookup_sk_model extends Base_Model {
	var $column_order_list_sk = array(null, 'nomor_sk', 'judul_sk');
	var $column_search_list_sk = array('UPPER(tbl.nomor_sk)','UPPER(tbl.judul_sk)');

	var $order_list_sk = array('id_sk' => 'asc');

	private function _get_datatables_query_list_sk(){
		$this->db->select("tbl.nomor_sk, tbl.id_sk, tbl.judul_sk");
		$this->db->from("public.dtl_sk tbl");
		$this->db->order_by("tbl.id_sk", "ASC");
		$this->db->where("tbl.status", 1);

		$i = 0;
		foreach ($this->column_search_list_sk as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_sk) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_sk[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_sk)){
			$order = $this->order_list_sk;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_sk(){
		$this->_get_datatables_query_list_sk();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_sk(){
		$this->_get_datatables_query_list_sk();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_sk(){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_sk tbl");
		return $this->db->get()->num_rows();
	}
}