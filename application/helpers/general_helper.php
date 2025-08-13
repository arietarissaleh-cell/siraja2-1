<?php

function get_themes(){
	$_this = & get_Instance();
	$conf = site_url('asset/themes');
	if($conf <> ''){
		return $conf;
	}else{
		return false;
	}
}

function tgl_indo($tanggal, $diambil){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	if($diambil == "ALL"){
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}elseif($diambil == "bulan"){
		return $bulan[ (int)$pecahkan[1] ];
	}elseif($diambil == "tahun"){
		return $pecahan[0];
	}
}

function get_myconf($var){
	$_this = & get_Instance();
	$conf = $_this->config->item($var);
	if($conf <> ''){
		return $conf;
	}else{
		return false;
	}
}

if ( ! function_exists('match_key'))
{
	function match_key($data,$key)
	{
		$data_upper = trim(strtoupper($data));
		$key_upper = trim(strtoupper($key));
		$pos_start = strrpos($data_upper,$key_upper);
		$result = $data;
		//$mark_start = '<span style="background-color: rgb(178, 179, 0);">';
		//$mark_start = '<span class="marked">';
		$mark_start = '<b><span style="color:red;">';
		$mark_end = '</span></b>';
		if ($pos_start OR $key_upper == substr($data_upper,0,strlen($key_upper)) )
		{
			$pos_end = $pos_start + strlen($key_upper);
			$result = substr_replace($data,$mark_start,$pos_start,0);
			$result = substr_replace($result,$mark_end,$pos_end+strlen($mark_start),0);
		}
		
		return $result;
	}
}
if ( ! function_exists('text2num'))
{
	function text2num($text='0')
	{
		$result = str_replace(",", "", $text);
		$result = $result?$result:'0';
		return $result;
	}
}

//decode
if ( ! function_exists('encode'))
{
	function encode($str='')
	{
		$result = base64_encode($str);		
		$result = base64_encode($result);
		//$result = strtr($result, '+/', '-_');
		return $result;
	}
}
if ( ! function_exists('decode'))
{
	function decode($str='')
	{
		$result = base64_decode($str);		
		$result = base64_decode($result);		
		return $result;
	}
}

// check privilage user
if ( ! function_exists('check_priv'))
{
	function check_priv($priv=false)
	{
		$_this = & get_Instance();
		
		$_this->load->model('utilities/operator_priv_model');
		$hasil = 0;
		$where = array();
		$where['tbl.fid_operator'] = $_this->session->userdata('id_operator');
		if ($priv)
		{
			$where['prv.kode'] = $priv;
		}
		$_this->operator_priv_model->set_where($where);
		$hasil = ($_this->operator_priv_model->count() > 0);
		return $hasil;
	}
}

// check file poto is exist
if ( ! function_exists('check_profile_pict'))
{
	function check_profile_pict($id,$path=false)
	{
		$path = $path?$path.'/':'';
		$foto = 'files/foto/'.$path.$id.'.jpg';
		if (!file_exists($foto))
			$foto = base_url().'files/foto/nopict.jpg';
		else
			$foto = base_url().$foto;
		return $foto;
	}
}
// check file poto is exist
if ( ! function_exists('thausand_spar'))
{
	function thausand_spar($num,$dec_digit=0)
	{
		return number_format($num,$dec_digit,'.',',');
	}
}

