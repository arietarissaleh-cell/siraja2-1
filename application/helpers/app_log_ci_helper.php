<?php if(!defined('BASEPATH'))
exit('No direct script access allowed');

function insert_app_log($namatabel, $data, $fid_user, $fid_unit, $pk_data, $st_log){
	$CI = & get_instance();
	$object = json_encode($data);
	$ganti_ke_panah = str_replace(":","->",$object);

	$data_insert = array(
		'data_log' => $ganti_ke_panah,
		'nama_table' => $namatabel,
		'fid_user' =>  $fid_user,
		'fid_unit' => $fid_unit,
		'pk_data' =>  $pk_data,
		'st_log' => $st_log
	);

	$CI->db->insert('app_log_ci', $data_insert);
}

function update_app_log($namatabel, $data, $fid_user, $fid_unit, $pk_data, $primary_key, $no_trans, $st_log){
	// $CI = & get_instance();
	// $data_baru = $data;
	
	// $where = (key((array)$primary_key));
	// $field = $CI->db->query("select * from information_schema.columns where table_name = '".$namatabel."'")->result();
	// $namafield = array();
	// for ($i=0; $i < count($field); $i++) { 
	// 	$namafield[$field[$i]->column_name] = $field[$i]->column_name;
	// }

	// $kolomnya = implode(",",$namafield);
	// $CI->db->select($kolomnya);
	// $CI->db->from($namatabel);
	// $CI->db->where($where,$pk_data);

	// $data_lama = $CI->db->get()->result_array();
	
	// $array_kolom = explode(",", $kolomnya);

	// for ($i=0; $i < count($array_kolom); $i++) { 
	// 	if (isset($data_baru[$array_kolom[$i]])) {

	// 	}else{
	// 		unset($data_lama[0][$array_kolom[$i]]);
	// 	}
	// }

	// $data_hasil = array();
	// foreach($data_lama[0] as $dt => $value){
	// 	if ($data_lama[0][$dt] == $data_baru[$dt]) {
	// 		unset($data_lama[0][$dt]);
	// 		unset($data_baru[$dt]);
	// 	}
	
	// }

	// foreach($data_lama[0] as $dt => $value){
	// 	$data_hasil[$dt] = $data_lama[0][$dt] . " -> " . $data_baru[$dt];
	// }

	// $data_log = json_encode($data_hasil);

	// $data_update = array(
	// 	'data_log' => $data_log,
	// 	'nama_table' => $namatabel,
	// 	'fid_user' =>  $fid_user,
	// 	'fid_unit' => $fid_unit,
	// 	'fid_data' => $pk_data,
	// 	'pk_data' =>  $no_trans,
	// 	'st_log' => $st_log
	// );

	// $CI->db->insert('app_log_ci', $data_update);
	
	$CI = & get_instance();
	$data_baru = $data;

    // Mengambil nama kolom dari tabel yang diberikan dengan query binding untuk keamanan
	$field = $CI->db->query("SELECT column_name FROM information_schema.columns WHERE table_name = ?", array($namatabel))->result();
	$namafield = array();
	for ($i = 0; $i < count($field); $i++) { 
		$namafield[$field[$i]->column_name] = $field[$i]->column_name;
	}

    // Membuat string nama kolom yang dipisahkan dengan koma
	$kolomnya = implode(",", $namafield);

    // Mengambil data lama dari tabel berdasarkan primary key
	$CI->db->select($kolomnya);
	$CI->db->from($namatabel);
	$CI->db->where($primary_key, $pk_data);

	$data_lama = $CI->db->get()->result_array();

    // Mengubah kolom yang dipisahkan dengan koma menjadi array
	$array_kolom = explode(",", $kolomnya);

    // Menghapus kolom yang tidak ada di data baru
	foreach ($array_kolom as $kolom) {
		if (!isset($data_baru[$kolom])) {
			unset($data_lama[0][$kolom]);
		}
	}

    // Membandingkan data lama dan data baru serta menghapus kolom yang tidak berubah
	foreach ($data_lama[0] as $dt => $value) {
		if (isset($data_baru[$dt]) && $data_lama[0][$dt] == $data_baru[$dt]) {
			unset($data_lama[0][$dt]);
			unset($data_baru[$dt]);
		}
	}

    // Membuat log data perubahan
	$data_hasil = array();
	foreach ($data_lama[0] as $dt => $value) {
		$data_hasil[$dt] = $data_lama[0][$dt] . " -> " . $data_baru[$dt];
	}

    // Mengkodekan data hasil menjadi JSON
	$data_log = json_encode($data_hasil);

    // Menyiapkan data untuk log
	$data_update = array(
		'data_log' => $data_log,
		'nama_table' => $namatabel,
		'fid_user' => $fid_user,
		'fid_unit' => $fid_unit,
		'fid_data' => $pk_data,
		'pk_data' => $no_trans,
		'st_log' => $st_log
	);

    // Memasukkan log ke dalam tabel 'app_log_ci'
	$CI->db->insert('app_log_ci', $data_update);
	
}

function delete_app_log($namatabel, $data, $fid_user, $fid_unit, $fid_data, $pk_data, $st_log){
	$CI = & get_instance();
	$data_log = json_encode($data);
	$ganti_ke_panah = str_replace(":","->",$data_log);

	$data_delete = array(
		'data_log' => $ganti_ke_panah,
		'nama_table' => $namatabel,
		'fid_user' =>  $fid_user,
		'fid_unit' => $fid_unit,
		'fid_data' => $fid_data,
		'pk_data' =>  $pk_data,
		'st_log' => $st_log
	);

	$CI->db->insert('app_log_ci', $data_delete);

}
?>