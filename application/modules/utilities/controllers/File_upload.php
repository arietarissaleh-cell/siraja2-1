<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_upload extends MY_Controller {

	//var $table = 'mst_item';
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('file_upload_model');
		$this->load->model('unit/unit_model');
			
	}
	
	
	public function index()
	{
		//$this->page();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'utilities/file_upload/main'
				,'title' 		=> 	'Daftar File'
		);
		$this->load->view($data['content'],$data);
	}
	function filter()
	{
		//$this->page();
		$unit_list = $this->unit_model->get_list();
		$data = array('content' => 	'utilities/file_upload/filter'
						,'unit_list' 		=> $unit_list
						);
		$this->load->view($data['content'],$data);
	}
	
	function page($pg=1)
	{
		$content_type = $this->input->post('content_type');
		$realname = $this->input->post('f_real_name');
		$no_petak = $this->input->post('f_no_petak');
		$kode_kebun = $this->input->post('f_kode_kebun');
		
		$limit = $this->input->post('row_per_page')?:10;
		// binding data
		$this->file_upload_model->set_limit($limit);
		$this->file_upload_model->set_offset(($limit) * ($pg - 1));
		// filtering data
		$where = array();
		$where['tbl.fid_unit'] = $this->input->post('f_unit');
		$where['tbl.tahun_tanam_awal'] = ($this->input->post('f_tahun_tanam_awal'));
		$where['tbl.tahun_tanam_akhir'] =($this->input->post('f_tahun_tanam_akhir'));
		if($no_petak){
			$where['tbl.no_petak'] = $no_petak;
		}
		if($kode_kebun){
			$where["(UPPER(tbl.kode_kebun) LIKE '%$kode_kebun%' OR UPPER(tbl.nama_kebun) LIKE '%$kode_kebun%')"] = NULL;
		}
		$this->file_upload_model->set_where($where);
		
		$like = array();
		// $like['tbl.real_name'] = $realname;
		// $like['tb.nama_kebun'] = $kode_kebun;
		$like['tbl.remark'] = $this->input->post('f_remark');
		$this->file_upload_model->set_like($like);
		//
		$page = array();
		$page['limit'] 			= $limit;
		$page['count_row'] 		= $this->file_upload_model->count() ;
		$page['current'] 		= $pg;
		$page['load_func_name']	= 'loadPageList';
		$page['list'] 			= $this->gen_paging($page);
		//
		$data = array('list' 	=> 	$this->file_upload_model->get_list()
			,'name' 			=> 	$this->session->userdata('name')
			,'content' 			=> 	'utilities/file_upload/list'
			,'paging'			=> 	$page
			,'content_type'		=> 	$content_type
			,'key'				=>  $like
		);

		$this->load->view($data['content'],$data);
	}
	function input($id=0)
	{
		$id = decode($id);
		$file_upload = $this->file_upload_model->get($id);
		$order['kode_usaha'] = 'asc';
		$order['id_unit'] = 'asc';
		$this->unit_model->set_order($order);
		
		$unit_list = $this->unit_model->get_list();
		//$this->page();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'utilities/file_upload/input'
				,'title' 		=> 	$id?'Edit '.$file_upload['real_name']:'Input Baru'
				,'file_upload' 	=> 	$file_upload
				,'unit_list' 	=> 	$unit_list
		);
		$this->load->view($data['content'],$data);
	}
	function upload($id='0',$tahun_awal='',$tahun_akhir='',$unit='18',$remark='',$kode_kebun='',$no_petak='',$tgl_pemotretan='')
	{
		$month = humanize_mdate($tgl_pemotretan,'%m');
		$data['unit'] = $unit;
		$data['tahun_awal'] = $tahun_awal;
		$data['tahun_akhir'] = $tahun_akhir;
		$data['kode_kebun'] = $kode_kebun;
		$data['no_petak'] = $no_petak;
		$data['remark'] = str_replace('_',' ',$remark);
		$_this = & get_Instance();
		$_this->load->library('image_lib');
		$id = decode($id);
		$unix_name = strtolower(GUID());
		$dir1 = './files/'.$data['unit'].'/'.$data['tahun_awal'].'-'.$data['tahun_akhir'].'/'.$month.'/'.$data['kode_kebun'].'/'.$data['no_petak']; 
		$dir2 = './files/'.$data['unit'].'/'.$data['tahun_awal'].'-'.$data['tahun_akhir'].'/'.$month.'/'.$data['kode_kebun'].'/'.$data['no_petak'].'/thumbnails_60'; 
		$dir3 = './files/'.$data['unit'].'/'.$data['tahun_awal'].'-'.$data['tahun_akhir'].'/'.$month.'/'.$data['kode_kebun'].'/'.$data['no_petak'].'/thumbnails_270'; 
		if(!file_exists($dir1))
		{
			!mkdir($dir1, 0777, true);
		}
		if(!file_exists($dir2))
		{
			!mkdir($dir2, 0777, true);
		}
		if(!file_exists($dir3))
		{
			!mkdir($dir3, 0777, true);
		}
		// VARS
		$filedata = $_FILES['Filedata'];
		$tmp = explode('.', $filedata['name']);
		$file_ext = end($tmp);
		// echo(end(explode(".", $filedata['name'])));
		// print_r($data);
		// print_r($_FILES);
		// exit;
		// $file_ext = end(explode(".", $filedata['name']));
		$target_folder = './files/'.$data['unit'].'/'.$data['tahun_awal'].'-'.$data['tahun_akhir'].'/'.$month.'/'.$data['kode_kebun'].'/'.$data['no_petak'].'/'; 
		$upload_image = $target_folder.$unix_name.'.'.$file_ext;

		if(move_uploaded_file($filedata['tmp_name'], $upload_image)) 
		{
			$img_size = getimagesize($upload_image);
			// insert data
			$file['id_file_upload'] = 0;
			$file['file_server_name'] = $unix_name.'.'.$file_ext;
			$file['file_type'] = $file_ext;
			$file['file_path'] = $target_folder	;
			$file['file_ext'] = $file_ext;
			$file['file_size'] = $_FILES['Filedata']['size'];
			$file['is_image'] = 1;
			$file['image_width'] = $img_size[0];
			$file['image_height'] = $img_size[1];
			$file['image_type'] = '0';
			$file['image_size_str'] = '0';
			$file['fid_data'] = $id?:0;
			$file['table_name'] = 'foto_udara';
			$file['real_name'] = $filedata['name'];
			$file['fid_unit'] = $data['unit'];
			$file['remark'] = $data['remark'];
			$file['kode_kebun'] = $data['kode_kebun'];
			$file['no_petak'] = $data['no_petak'];
			$file['tahun_tanam_awal'] = $data['tahun_awal'];
			$file['tahun_tanam_akhir'] = $data['tahun_akhir'];
			$file['tgl_pemotretan'] = getSQLDate($tgl_pemotretan);
			$file_upload = $this->file_upload_model->save($file);
			
			$height_60 = 77;
			$height_270 = 270;
			$size =  array(                
                        array('name'    => 'thumbnails_60','width'    => $file['image_width'] * ($height_60/$file['image_height']), 'height'    => 77, 'quality'    => '100%'),
                        array('name'    => 'thumbnails_270','width'    => $file['image_width'] * ($height_270/$file['image_height']), 'height'    => 231, 'quality'    => '100%')
                    );
            $resize = array();
            foreach($size as $r){                
                $resize = array(
                    "width"            => $r['width'],
                    "height"        => $r['height'],
                    "quality"        => $r['quality'],
                    "source_image"    => $upload_image,
                    "new_image"        => $target_folder.$r['name'].'/'.$file['file_server_name']
                );
				$_this->image_lib->initialize($resize); 
				if(!$_this->image_lib->resize())                    
                    die($_this->image_lib->display_errors());
            }
			echo "Resize oke";
			// echo print_r($config2);
			// exit;
			
			
		}else{
            echo $this->upload->display_errors();
		}
	}
	function delete($id)
	{
		//$id = decode($id);
		$file = $this->file_upload_model->get($id);
		$query	= $this->file_upload_model->delete($id);
		    if($query){
				unlink($file['file_path'].$file['file_server_name']);
				unlink($file['file_path'].'thumbnails_60/'.$file['file_server_name']);
				unlink($file['file_path'].'thumbnails_270/'.$file['file_server_name']);
			}
		if ($query)
			$this->success('Data telah dihapus....');
		else
			$this->error('Proses gagal dijalankan....');
	}
}
/*
*Author: Rickytarius
01082017
*/


