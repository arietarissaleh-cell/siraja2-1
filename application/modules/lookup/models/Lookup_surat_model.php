<?php
class Lookup_surat_model extends Base_Model {
	var $column_order_list_surat = array(null, 'nomor_surat', null);
	var $column_search_list_surat = array('UPPER(tbl.nomor_surat)','UPPER(tbl.perihal)');

	var $order_list_surat = array('id_surat' => 'DESC');

	private function _get_datatables_query_list_surat(){
		$fid_unit			= $this->session->userdata('fid_lokasi_kerja');
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_surat_dms tbl");
		$this->db->order_by("tbl.id_surat", "DESC");
		$this->db->where("tbl.fid_unit", $fid_unit);
		//$this->db->where("tbl.nama_surat is not NULL");

		$i = 0;
		foreach ($this->column_search_list_surat as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_surat) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_surat[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_surat)){
			$order = $this->order_list_surat;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_surat(){
		$this->_get_datatables_query_list_surat();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_surat(){
		$this->_get_datatables_query_list_surat();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_surat(){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_surat_dms tbl");
		return $this->db->get()->num_rows();
	}
}