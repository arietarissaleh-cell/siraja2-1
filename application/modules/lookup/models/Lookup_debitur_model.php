<?php
class Lookup_debitur_model extends Base_Model {
	var $column_order_list_debitur = array(null, 'nama', 'nik', null, null);
	var $column_search_list_debitur = array('UPPER(mst.nama)','UPPER(mst.nik)');

	var $order_list_debitur = array('nama' => 'asc');

	private function _get_datatables_query_list_debitur($unit, $tahun_awal, $tahun_akhir){
		
		$this->db->select("mst.nama,
							mst.nik, 
							mst.alamat,
							dtl.id,
							mst.id_petani,
							dtl.nilai_pengajuan as nilai_pk,
							STRING_AGG(tebu.no_petak, ', ') AS no_petak,
							sum(tebu.nilai_escrow) as escrow_kebun");
		$this->db->from("public.mst_petani_mitani mst");
		$this->db->join("dtl_petani_mitani dtl", "dtl.id_petani = mst.id_petani and dtl.fid_unit = mst.fid_unit ", "LEFT");
		$this->db->join("dtl_tebu_tanam_dev tebu", "tebu.fid_unit = dtl.fid_unit and tebu.tahun_tanam_awal = dtl.tahun_tanam_awal and tebu.tahun_tanam_akhir = dtl.tahun_tanam_akhir and tebu.id_debitur = mst.id_petani", "LEFT");
		$this->db->where("mst.fid_unit", $unit);
		$this->db->where("mst.is_debitur", 1);
		$this->db->where("dtl.tahun_tanam_awal", $tahun_awal);
		$this->db->where("dtl.tahun_tanam_akhir", $tahun_akhir);

		$this->db->group_by("mst.nama, mst.nik, mst.alamat, dtl.id, dtl.nilai_escrow, mst.id_petani");
		$this->db->order_by("mst.nama", "ASC");

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

	function get_datatables_list_debitur($unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query_list_debitur($unit, $tahun_awal, $tahun_akhir);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_debitur($unit, $tahun_awal, $tahun_akhir){
		$this->_get_datatables_query_list_debitur($unit, $tahun_awal, $tahun_akhir);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_debitur($unit, $tahun_awal, $tahun_akhir){
		$this->db->select("tbl.*");
		$this->db->from("public.dtl_debitur_mitani tbl");
		$this->db->where("tbl.fid_unit", $unit);
		$this->db->where("tbl.tahun_tanam_awal", $tahun_awal);
		$this->db->where("tbl.tahun_tanam_akhir", $tahun_akhir);
		return $this->db->get()->num_rows();
	}
}