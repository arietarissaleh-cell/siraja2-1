<?php
class Kebun_model extends Base_Model {
	var $column_order_list_kebun = array(null, null, 'no_petak', 'kode_kebun', 'nama_kebun', null, null, null, null);
	var $column_search_list_kebun = array('UPPER(tbl.no_petak)', 'UPPER(mst.nama_kebun)','UPPER(tbl.kode_kebun)','UPPER(tbl.kode_rayon)','UPPER(pemilik.nama)','UPPER(debitur.nama_debitur)','UPPER(mitra.nama_mitra)');

	var $order_list_kebun = array('no_petak' => 'asc');

	private function _get_datatables_query_list_kebun($fid_unit, $tahun_tanam_awal, $tahun_tanam_akhir, $wilayah, $rayon){
		$this->db->select("tbl.fid_unit, tbl.no_petak, tbl.kode_kebun, mst.nama_kebun, mst.luas_ha, mst.luas_netto, tbl.kode_rayon, tbl.tahun_tanam_awal, tbl.tahun_tanam_akhir, tbl.tahun_tanam_awal || '-' || tbl.tahun_tanam_akhir AS masatanam, tbl.tahun, pemilik.id_pemilik, pemilik.nama AS nama_pemilik, debitur.id_debitur, debitur.nama_debitur, mitra.id_mitra, mitra.nama_mitra");

		$this->db->from("public.dtl_tebu_tanam tbl");

		$this->db->join("public.mst_tebu_tanam mst", "mst.no_petak = tbl.no_petak AND mst.tahun = tbl.tahun AND mst.tahun_tanam_awal = tbl.tahun_tanam_awal AND mst.tahun_tanam_akhir = tbl.tahun_tanam_akhir AND mst.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->join("mst_pemilik_mitani pemilik", "pemilik.id_pemilik = tbl.id_pemilik AND pemilik.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->join("mst_debitur_petani_mitani debitur", "debitur.id_debitur = tbl.id_debitur AND debitur.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->join("mst_mitra_petani_mitani mitra", "mitra.id_mitra = tbl.id_mitra AND mitra.fid_unit = tbl.fid_unit", "LEFT");


		$this->db->where("tbl.fid_unit", $fid_unit);
		if ($wilayah != "") {
			$this->db->where("tbl.kode_wilayah", $wilayah);
		}
		
		if($rayon != ""){
			$this->db->where("tbl.kode_rayon", $rayon);
		}

		// $this->db->where("tbl.kode_sinder in ($kode_sinder)");
		// $this->db->where("tbl.tahun", date('Y'));
		$this->db->where("tbl.tahun_tanam_awal", $tahun_tanam_awal);
		$this->db->where("tbl.tahun_tanam_akhir", $tahun_tanam_akhir);

		$this->db->order_by("tbl.no_petak, tbl.kode_kebun, mst.nama_kebun", "ASC");

		$i = 0;
		foreach ($this->column_search_list_kebun as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search_list_kebun) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order_list_kebun[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order_list_kebun)){
			$order = $this->order_list_kebun;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_list_kebun($fid_unit, $tahun_tanam_awal, $tahun_tanam_akhir, $wilayah, $rayon){
		$this->_get_datatables_query_list_kebun($fid_unit, $tahun_tanam_awal, $tahun_tanam_akhir, $wilayah, $rayon);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_list_kebun($fid_unit, $tahun_tanam_awal, $tahun_tanam_akhir, $wilayah, $rayon){
		$this->_get_datatables_query_list_kebun($fid_unit, $tahun_tanam_awal, $tahun_tanam_akhir, $wilayah, $rayon);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_list_kebun($fid_unit, $tahun_tanam_awal, $tahun_tanam_akhir, $wilayah, $rayon){
		// $kode_sinder = "'" .str_replace(',', "','", trim($kode, '()')) ."'";
		$this->db->select("tbl.fid_unit, tbl.no_petak, tbl.kode_kebun, mst.nama_kebun, mst.luas_ha, mst.luas_netto, tbl.kode_rayon, tbl.tahun_tanam_awal, tbl.tahun_tanam_akhir, tbl.tahun_tanam_awal || '-' || tbl.tahun_tanam_akhir AS masatanam, tbl.tahun, pemilik.nama AS nama_pemilik, debitur.nama_debitur, mitra.nama_mitra");

		$this->db->from("public.dtl_tebu_tanam tbl");

		$this->db->join("public.mst_tebu_tanam mst", "mst.no_petak = tbl.no_petak AND mst.tahun = tbl.tahun AND mst.tahun_tanam_awal = tbl.tahun_tanam_awal AND mst.tahun_tanam_akhir = tbl.tahun_tanam_akhir AND mst.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->join("mst_pemilik_mitani pemilik", "pemilik.id_pemilik = tbl.id_pemilik AND pemilik.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->join("mst_debitur_petani_mitani debitur", "debitur.id_debitur = tbl.id_debitur AND debitur.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->join("mst_mitra_petani_mitani mitra", "mitra.id_mitra = tbl.id_mitra AND mitra.fid_unit = tbl.fid_unit", "LEFT");

		$this->db->where("tbl.fid_unit", $fid_unit);
		if ($wilayah != "") {
			$this->db->where("tbl.kode_wilayah", $wilayah);
		}
		
		if($rayon != ""){
			$this->db->where("tbl.kode_rayon", $rayon);
		}

		// $this->db->where("tbl.kode_sinder in ($kode_sinder)");
		// $this->db->where("tbl.tahun", date('Y'));
		$this->db->where("tbl.tahun_tanam_awal", $tahun_tanam_awal);
		$this->db->where("tbl.tahun_tanam_akhir", $tahun_tanam_akhir);

		return $this->db->get()->num_rows();
	}
}