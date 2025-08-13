<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth {

	var $CI = null;

	function Auth()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
	}
	
	function do_login($login = NULL)
	{
		if(!isset($login))
			return FALSE;
		
		if(count($login) != 2)
			return FALSE;
		
		$username = $login['username'];
		$password = $login['password'];
		$nChar = strlen($password)+1;
		$cPassGen = $password;
		$x = 1; 
		while($x <= $nChar) 
		{
			$cPassGen = md5($cPassGen);
			$x++;
		} 
		$this->CI->db->from('public.ms_operator_sdm opt');
		$this->CI->db->where('username', $username);		
		$this->CI->db->where('pwd',$cPassGen);
		$query = $this->CI->db->get();
		
		foreach ($query->result() as $row)
		{
			$id = $row->id_ms_operator;
			$LoginName = $row->username;
			$fid_unit = $row->fid_unit;
			$id_karyawan = $row->id_karyawan;
			$nik = $row->nik;
			$lokasi_kerja = $row->fid_lokasi_kerja;
			
		}
		if ($query->num_rows() == 1)
		{
			$fid_lokasi_kerja = "";
			if ($lokasi_kerja == '19' || $lokasi_kerja == '26') {
				$fid_lokasi_kerja = '18';
			}else{
				$fid_lokasi_kerja = $lokasi_kerja;
			}
			$newdata['id_ms_operator']	= $id;
			$newdata['username']	= $LoginName;
			$newdata['fid_unit']	= $fid_unit;
			$newdata['fid_lokasi_kerja']	= $fid_lokasi_kerja;
			$newdata['nik']	= $nik;
			$newdata['id_karyawan']	= $id_karyawan;
			$newdata['LoggedIn']	= true;
			
			$newdata['jabatan'] = '';
			$newdata['kode_person'] = '';
			$newdata['nama_person'] = '';
			$newdata['rayon_skk'] = '';
			$person = '';

			$mst_person = $this->CI->db->query("SELECT fid_unit, kode_person, rayon_skk, nama_person, jabatan, nik FROM mst_person WHERE nik = '$nik' AND fid_unit = '$fid_lokasi_kerja'")->result();
			if($mst_person){
				foreach($mst_person as $dt){
					$newdata['jabatan'] = $dt->jabatan;
					$person[] = $dt->kode_person;
					$newdata['nama_person'] = $dt->nama_person;
					$newdata['rayon_skk'] = $dt->rayon_skk;

				}

				$newdata['kode_person'] = implode(',',$person);
			}



			$this->CI->session->set_userdata($newdata);	  
			
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	 /**
         *
         * This function restricts users from certain pages.
         * use restrict(TRUE) if a user can't access a page when logged in
         *
         * @access	public
         * @param	boolean	wether the page is viewable when logged in
         * @return	void
         */	
	 function restrict($logged_out = FALSE)
	 {
		// If the user is logged in and he's trying to access a page
		// he's not allowed to see when logged in,
		// redirect him to the index!
	 	if ($logged_out && is_logged_in())
	 	{
	 		redirect('');
	 		exit;
			  //echo $this->CI->fungsi->warning('Maaf, sepertinya Anda sudah login...',site_url());
		      //die();
	 	}
	 	
		// If the user isn' logged in and he's trying to access a page
		// he's not allowed to see when logged out,
		// redirect him to the login page!
	 	if ( ! $logged_out && !is_logged_in()) 
	 	{
	 		echo $this->CI->fungsi->warning('Anda diharuskan untuk Login bila ingin mengakses halaman ini.',site_url());
	 		die();
	 	}
	 }
	 
	 function logout() 
	 {
	 	$this->CI->session->sess_destroy();	
	 	return TRUE;
	 }
	 
	 function cek($id,$ret=false)
	 {
	 	$menu = array(
	 		'data_master'=>'+admin+',
	 		'manajemen_user'=>'+admin+'
	 	);
	 	$allowed = explode('+',$menu[$id]);
	 	if(!in_array(from_session('level'),$allowed))
	 	{
	 		if($ret) return false;
	 		echo $this->CI->fungsi->warning('Anda tidak diijinkan mengakses halaman ini.',site_url());
	 		die();
	 	}
	 	else
	 	{
	 		if($ret) return true;
	 	}
	 }	
	}
// End of library class
// Location: system/application/libraries/Auth.php
