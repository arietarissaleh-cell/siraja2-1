<?php
class Lookup_debitur_model extends Base_Model {
	var $column_order_list_debitur = array(null, 'nama_debitur', 'nik_debitur', null, null);
	var $column_search_list_debitur = array('UPPER(tbl.nama_debitur)','UPPER(tbl.nik_debitur)');

	var $order_list_debitur = array('nama_debitur' => 'asc');

	private function _get_datatables_query_list_debitur($fid_unit){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_debitur_petani_mitani tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);

		$this->db->order_by("tbl.nama_debitur", "ASC");

		$i = 0;
		foreach ($this->column_search_list_debitur as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_debitur) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_debitur[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_debitur)){
			$order = $this->order_list_debitur;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_debitur($fid_unit){
		$this->_get_datatables_query_list_debitur($fid_unit);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_debitur($fid_unit){
		$this->_get_datatables_query_list_debitur($fid_unit);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_debitur($fid_unit){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_debitur_petani_mitani tbl");
		$this->db->where("tbl.fid_unit", $fid_unit);
		return $this->db->get()->num_rows();
	}
}