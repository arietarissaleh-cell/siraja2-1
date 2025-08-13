<?php

class File_upload_model extends Base_Model {

    function __construct() {

        parent::__construct();
		$this->set_schema('public');
		$this->set_table('file_upload');
		$this->set_pk('id_file_upload');
		$this->set_log(false);
    }
	function count()
	{
		$this->db->select('count(tbl.id_file_upload) num_rows');
		
		// join ke Detail Kebun
		$this->db->join('public.mst_tebu_tanam tb','tbl.fid_unit = tb.fid_unit and tbl.no_petak = tb.no_petak','left');
		if ($this->where)
		{
			if (count($this->like)>0)
			{
				$like = '( 1=0 ';
				foreach ($this->like as $key => $value)
				{
					$like .= ' OR '.$key." LIKE '%".$value."%'";
				}
				$like .= ')';
				$this->where[$like] = null;
			}
			$this->db->where($this->where);
		}else
		{
			$this->db->or_like($this->like);
		}
		$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		
		// echo $this->db->last_query();
		// exit;

		$data = $query->row_array();
		return $data['num_rows'];
	}
	function get_list($id=0)
	{       
		$this->db->select('tbl.*');
		
		// join ke Detail Kebun
		$this->db->select('tb.nama_kebun');
		$this->db->join('public.mst_tebu_tanam tb','tbl.fid_unit = tb.fid_unit and tbl.no_petak = tb.no_petak','left');
		
		if ($this->where)
		{
			if (count($this->like)>0)
			{
				$like = '( 1=0 ';
				foreach ($this->like as $key => $value)
				{
					$like .= ' OR '.$key." LIKE '%".$value."%'";
				}
				$like .= ')';
				$this->where[$like] = null;
			}
			$this->db->where($this->where);
		}else
		{
			$this->db->or_like($this->like);
		}
	
		$this->db->order_by('tbl.id_file_upload', 'ASC');

		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->table.' tbl');
		else
			$query = $this->db->get($this->table.' tbl',$this->limit,$this->offset);
		
		// echo $this->db->last_query();
		// exit;
		
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
        
    }
	
	function get_images($table_name='',$id=0,$limit=0)
	{
		$this->db->select('tbl.*');
		$this->db->order_by('tbl.id_file_upload', 'ASC');
		$where['tbl.fid_data']=$id;
		$where['tbl.table_name']=$table_name;
		$this->db->where($where);
		//if ($limit>0)
		//{
			$query = $this->db->get($this->table.' tbl');
		//}else
		//{
		//	$query = $this->db->get($this->table.' tbl',$limit);
		//}
		
		//echo $limit.'#'.$this->db->last_query();
		//exit;
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
}