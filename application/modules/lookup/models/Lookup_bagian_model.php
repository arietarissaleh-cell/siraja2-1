<?php
class Lookup_bagian_model extends Base_Model {
	var $column_order_list_bagian = array(null, 'nama_bagian', null);
	var $column_search_list_bagian = array('UPPER(tbl.nama_bagian)');

	var $order_list_bagian = array('nomor_sop' => 'asc');

	private function _get_datatables_query_list_bagian(){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_kodesurat_jabatan_dms tbl");
		$this->db->order_by("tbl.nomor_sop", "ASC");
		$this->db->where("tbl.nama_bagian is not NULL");

		$i = 0;
		foreach ($this->column_search_list_bagian as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_bagian) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_bagian[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_bagian)){
			$order = $this->order_list_bagian;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_bagian(){
		$this->_get_datatables_query_list_bagian();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_bagian(){
		$this->_get_datatables_query_list_bagian();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_bagian(){
		$this->db->select("tbl.*");
		$this->db->from("public.mst_kodesurat_jabatan_dms tbl");
		return $this->db->get()->num_rows();
	}
}