<?php
class Lookup_coa_model extends Base_Model {
	var $column_order = array(null, null, null, null, null, null);
	var $column_search = array('UPPER(CAST(coa.kode_coa AS TEXT))','UPPER(CAST(coa.deskripsi AS TEXT))','UPPER(CAST(gol.nama AS TEXT))','UPPER(CAST(ksl.nama AS TEXT))');

	var $order = array('coa.kode_coa' => 'asc');

	private function _get_datatables_query($fid_unit, $tahun){
		$this->db->select("
			CAST(0 AS INT) AS liNo,
			CAST ( unt.id_unit || ' : ' || unt.nama AS VARCHAR ( 50 ) ) AS c_unit,
			coa.kode_coa,
			coa.deskripsi,
			CAST ( gol.kode || ' : ' || gol.nama AS VARCHAR ( 50 ) ) AS c_golongan,
			CAST ( ksl.kode || ' : ' || ksl.nama AS VARCHAR ( 50 ) ) AS c_konsol,
			dtl.saldo,
			CAST ( cf.kode || ' : ' || cf.nama AS VARCHAR ( 50 ) ) AS c_cash_flow,
			cf.kode AS cash_flow_kode,
			coa.flag,
			coa.id_coa,
			coa.cek_rak,
			coa.cek_rkap
			");
		$this->db->from("mst_coa coa");
		$this->db->join("(SELECT CAST(awald - awalk + deb01 - kre01 + deb02 - kre02 + deb03 - kre03 + deb04 - kre04 + deb05 - kre05 + deb06 - kre06 + deb07 - kre07 + deb08 - kre08 + deb09 - kre09 + deb10 - kre10 + deb11 - kre11 + deb12 - kre12 AS NUMERIC ( 25, 2 )) AS saldo, fid_coa, fid_unit FROM dtl_coa WHERE tahun = $tahun AND fid_unit = $fid_unit) dtl","coa.id_coa = dtl.fid_coa AND coa.fid_unit = dtl.fid_unit","LEFT");
		$this->db->join("mst_konsol ksl","coa.fid_konsol = ksl.id_konsol","LEFT");
		$this->db->join("mst_cash_flow cf","coa.fid_cash_flow = cf.id_cash_flow","LEFT");

		$this->db->join("mst_golongan gol","coa.fid_golongan = gol.id_golongan","LEFT");
		$this->db->join("mst_unit unt","coa.fid_unit = unt.id_unit","LEFT");

		$this->db->where("( 1 = 1 )");
		$this->db->where("coa.fid_unit", $fid_unit);
		$this->db->where("coa.tahun", $tahun);
		$this->db->where("LENGTH ( coa.konsol_induk ) >= 20");
		$this->db->order_by("coa.fid_unit", "ASC");

		$i = 0;
		foreach ($this->column_search as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			for ($i=0; $i < count($_POST['order']); $i++) { 
				$this->db->order_by($this->column_order[$_POST['order'][$i]['column']], $_POST['order'][$i]['dir']);
			}
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($fid_unit, $tahun){
		$this->_get_datatables_query($fid_unit, $tahun);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($fid_unit, $tahun){
		$this->_get_datatables_query($fid_unit, $tahun);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($fid_unit, $tahun){
		$this->db->select("
			CAST(0 AS INT) AS liNo,
			CAST ( unt.id_unit || ' : ' || unt.nama AS VARCHAR ( 50 ) ) AS c_unit,
			coa.kode_coa,
			coa.deskripsi,
			CAST ( gol.kode || ' : ' || gol.nama AS VARCHAR ( 50 ) ) AS c_golongan,
			CAST ( ksl.kode || ' : ' || ksl.nama AS VARCHAR ( 50 ) ) AS c_konsol,
			dtl.saldo,
			CAST ( cf.kode || ' : ' || cf.nama AS VARCHAR ( 50 ) ) AS c_cash_flow,
			cf.kode AS cash_flow_kode,
			coa.flag,
			coa.id_coa,
			coa.cek_rak,
			coa.cek_rkap
			");
		$this->db->from("mst_coa coa");
		$this->db->join("(SELECT CAST(awald - awalk + deb01 - kre01 + deb02 - kre02 + deb03 - kre03 + deb04 - kre04 + deb05 - kre05 + deb06 - kre06 + deb07 - kre07 + deb08 - kre08 + deb09 - kre09 + deb10 - kre10 + deb11 - kre11 + deb12 - kre12 AS NUMERIC ( 25, 2 )) AS saldo, fid_coa, fid_unit FROM dtl_coa WHERE tahun = $tahun AND fid_unit = $fid_unit) dtl","coa.id_coa = dtl.fid_coa AND coa.fid_unit = dtl.fid_unit","LEFT");
		$this->db->join("mst_konsol ksl","coa.fid_konsol = ksl.id_konsol","LEFT");
		$this->db->join("mst_cash_flow cf","coa.fid_cash_flow = cf.id_cash_flow","LEFT");

		$this->db->join("mst_golongan gol","coa.fid_golongan = gol.id_golongan","LEFT");
		$this->db->join("mst_unit unt","coa.fid_unit = unt.id_unit","LEFT");

		$this->db->where("( 1 = 1 )");
		$this->db->where("coa.fid_unit", $fid_unit);
		$this->db->where("coa.tahun",$tahun);
		$this->db->where("LENGTH ( coa.konsol_induk ) >= 20");
		$this->db->order_by("coa.fid_unit", "ASC");
		return $this->db->get()->num_rows();
	}
}