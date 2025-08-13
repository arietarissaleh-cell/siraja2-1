<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Wilayah extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('wilayah_model');
		
	}
	
	
	public function index()
	{
		
	}
	function get_wilayah($unit,$rayon) {
		$tmp    = '';
		if($unit)
		{
			$where['fid_unit'] = $unit;
			$where['kode_rayon'] = $rayon;
			$this->wilayah_model->set_where($where);
			$data   = $this->wilayah_model->get_list();
        }else{
			$where['(1=0)'] = NULL;
			$this->wilayah_model->set_where($where);
			$data   = $this->wilayah_model->get_list();
		}
		if(!empty($data)) {
			$tmp 		.= "<option value=''>Option</option>"; 
            foreach($data->result_array() as $row){ 
            	$tmp 	.= "<option value='".($row['kode_wilayah'])."'>
							".$row['nama_wilayah']."
							</option>";
            }
		}else{
            $tmp 		.= "<option value=''>Option</option>"; 
        }
        die($tmp);
    }
	function get_wilayah2() 
	{
		$tmp    = '';
		$rayon_selected = $this->input->post('t_rayon');
		$where = array();
		if($rayon_selected)
		{
			$where_in = "'0'";
			foreach($rayon_selected as $value)
			{
			
				$where_in .= ",'".$value."'";
			}
			$where[" (tbl.fid_unit||'_'||tbl.kode_rayon) in (".$where_in.")"] = null;
		}else{
			$where['1 = 0'] = null;
		}
		$this->wilayah_model->set_where($where);
		$data   = $this->wilayah_model->get_list();
		if(!empty($data)) {
			$tmp 		.= "<option value=''>Option</option>"; 
            $nama_group = '';
			$i = 0;
            foreach($data->result_array() as $row)
			{ 
            	if ($nama_group <> $row['unit_rayon'])
				{
					if ($i > 0)
					{
						$tmp 	.= '</optgroup>';
					}
					$tmp 	.= '<optgroup label="'.$row['unit_rayon'].'">';
				}
				$tmp 	.= "<option value='".($row['kode_wilayah'])."'>
							".$row['nama_wilayah']."
							</option>";
				$nama_group = $row['unit_rayon'];
				$i++;
            }
		}else{
            $tmp 		.= "<option value=''>Option</option>"; 
        }
        die($tmp);
    }
	
	function get_wilayah2_old($unit,$rayon) {
		$tmp    = '';
		
		if($unit)
		{
			$where['fid_unit in ('.$unit.')'] = null;
			$where['kode_rayon in ('.$rayon.')'] = null;
			$this->wilayah_model->set_where($where);
			$data   = $this->wilayah_model->get_list();
        }else{
			$where['(1=0)'] = NULL;
			$this->wilayah_model->set_where($where);
			$data   = $this->wilayah_model->get_list();
		}
		if(!empty($data)) {
			$tmp 		.= "<option value=''>Option</option>"; 
            foreach($data->result_array() as $row){ 
            	$tmp 	.= "<option value='".($row['kode_wilayah'])."'>
							".$row['nama_wilayah']."
							</option>";
            }
		}else{
            $tmp 		.= "<option value=''>Option</option>"; 
        }
        die($tmp);
    }
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
28052016
*/


