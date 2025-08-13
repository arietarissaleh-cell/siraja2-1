<?php
class Base_model extends CI_Model 
{
	public $table = '';
	public $schema = '';
	public $pk_field = '';
	public $pk_field2 = '';
	public $pk_field3 = '';
	public $pk_field4 = '';
	public $pk_field5 = '';
	public $code_field = '';
	public $limit = 0;
	public $offset = 0;
	public $where = array();
	public $like = array();
	public $order_by = array();
	public $is_trap = true;
	
    function __construct() 
	{
        parent::__construct();

    }
	
	function count() 
	{
		$data = array();
		$this->db->where($this->where);
		$this->db->or_like($this->like);
		
		$query = $this->db->get($this->table.' t1');
	
		return $query->num_rows();
	}
	
	function get($where) 
	{
		$data = array();
	
		if ( is_array($where) )
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}else
		{
			$this->db->where($this->pk_field, $where?:0);
		}
		// if ($this->is_trap)
		// {
			// $this->db->select('lg.id_log');
			// $sql_log = "(SELECT max(tr.id_log) as id_log,tr.fid_data
							// FROM tr_log tr 
							// WHERE tr.table_name = '".$this->table."'
							// GROUP BY tr.fid_data) lg";
			// $this->db->join($sql_log,'tbl.'.$this->pk_field.' = lg.fid_data','left');
		// }
		// get array data
		$this->db->select('tbl.*');
		$this->db->order_by($this->pk_field);
		$query = $this->db->get($this->schema.'.'.$this->table.' tbl',1,0);
		if ( $query->num_rows() == 1)
		{
            $data = $query->row_array();
			$query->free_result();
			
		}else
		{
			$data = $this->feed_blank();
			// $data['id_log'] = 0;
		}
        return $data;
	}
	
	function get_list()
	{
		$this->db->select('tbl.*');
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
		
		foreach ($this->order_by as $key => $value)
		{
			$this->db->order_by($key, $value);
		}

		if (!$this->limit AND !$this->offset)
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl');
		else
			$query = $this->db->get($this->schema.'.'.$this->table.' tbl',$this->limit,$this->offset);
		
		if($query->num_rows()>0)
		{
			return $query;
        
		}else
		{
			$query->free_result();
            return $query;
        }
	}
	
	public function set_table($table)
	{
		$this->table = $table;
	}
	
	public function set_schema($schema_name='public')
	{
		$this->schema = $schema_name;
	}
	
	public function set_log($trap)
	{
		$this->is_trap = $trap;
	}
	
	public function set_pk($field,$field2=false,$field3=false,$field4=false,$field5=false)
	{
		$this->pk_field = $field;
		$this->pk_field2 = $field2;
		$this->pk_field3 = $field3;
		$this->pk_field4 = $field4;
		$this->pk_field5 = $field5;
	}
	
	public function set_code($table)
	{
		$this->code_field = $table;
	}
	
	public function set_limit($limit=0)
	{
		if ($limit > 0)
			$this->limit = $limit;
	}
	
	public function set_offset($offset=0)
	{
		if ($offset > 0)
			$this->offset = $offset;
	}
	
	public function set_where($where=array())
	{
		if ($where)
			$this->where = $where;
	}
	public function set_order($order=array())
	{
		if ($order)
			$this->order_by = $order;
	}
	public function set_group($group=array())
	{
		if ($group)
			$this->group_by = $group;
	}
	public function set_like($like=array())
	{
		$this->like = $like;
	}
	/*
	public function set_like($like=array())
	{
		if ($like)
		{
			$where = '( ';
			$i = 0;
			foreach($like as $key => $value)
			{
				if ($i>0)
					$where .= ' OR ';
					
				if ($value)
				{
					$where .= " $key LIKE '%".$value."%'";
					$i++;
				}
			}
			$where .= ' )';
			if ($i)
				$this->where[$where] = null;
			//$this->like = $like;
		}
	}
	*/
	function log($type='',$old_value='',$fid_data=0)
	{
		$data['value_before'] = $old_value;
		$data['log_type'] = $type;
		$data['ip_comp'] = $this->input->ip_address();
		$data['fid_operator'] = $this->session->userdata('id_operator');
		$data['table_name'] = $this->table;
		$data['fid_data'] = $fid_data;
		$this->db->insert('tr_log', $data);
	}
	function save($data,$act=null)
	{
		$return = 0;
		$action = '';
		// $data = $this->clean_data($data);
		// setup PK
		if ($this->pk_field)
			$where[$this->pk_field] = $data[$this->pk_field]?:0;
		if ($this->pk_field2)
			$where[$this->pk_field2] = $data[$this->pk_field2]?:0; 
		if ($this->pk_field3)
			$where[$this->pk_field3] = $data[$this->pk_field3]?:0; 
		if ($this->pk_field4)
			$where[$this->pk_field4] = $data[$this->pk_field4]?:0; 
		if ($this->pk_field5)
			$where[$this->pk_field5] = $data[$this->pk_field5]?:0; 
		/*
		$this->message = '---';
		return false;
		exit;
		*/
		
		$this->db->select($this->pk_field);
		$this->db->where($where);
		$query = $this->db->get($this->schema.'.'.$this->table);
		//
		$num_rows = $query->num_rows();
		if($num_rows==0)
		{
			$action = 'New Data';
			// insert new row
			unset($data[$this->pk_field]);
			unset($data[$this->pk_field2]);
			unset($data[$this->pk_field3]);
			unset($data[$this->pk_field4]);
			unset($data[$this->pk_field5]);
			$new = $this->db->insert($this->schema.'.'.$this->table, $data);		
			$return = $new;
		}elseif($num_rows==1)
		{
			$action = 'Edit Data';
			// update data
			$this->db->where($where);		
			$update = $this->db->update($this->schema.'.'.$this->table,$data);		
			// $return = $update;
			// $return = $data[$this->pk_field];
			
			if ($this->pk_field)
				$return .= $data[$this->pk_field];
			if ($this->pk_field2)
				$return .= $data[$this->pk_field2]; 
			if ($this->pk_field3)
				$return .= $data[$this->pk_field3]; 
			if ($this->pk_field4)
				$return .= $data[$this->pk_field4]; 
			if ($this->pk_field5)
				$return .= $data[$this->pk_field5]; 
			
		}elseif($num_rows>1)
		{
			$return = false;
			$this->message = 'Ditemukan data diserver lebih dari satu. [ '.$num_rows.' rows]'.chr(13)
							.$this->pk_field.' = '.$data[$this->pk_field].chr(13);
			if ($this->pk_field2)
				$this->message .= $this->pk_field2.' = '.$data[$this->pk_field2].chr(13);
			if ($this->pk_field3)
				$this->message .= $this->pk_field3.' = '.$data[$this->pk_field3].chr(13); 
			if ($this->pk_field4)
				$this->message .= $this->pk_field4.' = '.$data[$this->pk_field4]; 
			if ($this->pk_field5)
				$this->message .= $this->pk_field5.' = '.$data[$this->pk_field5]; 
		}
		return $return;
	}
	
	// function insert new data
	public function insert($data = null)
	{
		return $this->db->insert($this->table, $data);
	}
	
	public function delete($where = NULL, $table = FALSE)
	{
		$table = (FALSE !== $table) ? $table : $this->schema.'.'.$this->table;
		
		if ( is_array($where) )
		{
			$this->db->where($where);
		}
		else
		{
			$this->db->where($this->pk_field, $where);
		}
	
		return $this->db->delete($table);
				
		//return (int) $this->db->affected_rows();
	}
	
	function clean_data($value, $table = FALSE)
	{
		/* $data = $value;
		*/
		$data = array();
		foreach($value as $key => $val)
        {	
            if(!is_array($val))
            {
                $data[$key]     = $val;
                $data[$key]     = strip_image_tags($data[$key]);
                $data[$key]     = quotes_to_entities($data[$key]);
                $data[$key]     = encode_php_tags($data[$key]);
                $data[$key]     = trim($data[$key]);
            }
        }		
       
		$cleaned_data = array();
	
		if ( ! empty($data))
		{
			$table = ($table !== FALSE) ? $table : $this->table;
			
			$fields = $this->db->list_fields($table);
			
			$fields = array_fill_keys($fields,'');
	
			$cleaned_data = array_intersect_key($data, $fields);
		}
		return $cleaned_data;
	}
	
	function feed_blank()
	{
		$template = array();
		$fields = $this->db->list_fields($this->table);

		$fields_data = $this->field_data($this->table);

		foreach ($fields as $field)
		{
			//$field_data = array_values(array_filter($fields_data, create_function('$row', 'return $row["Field"] == "'. $field .'";')));
			$field_data = (isset($field_data[0])) ? $field_data[0] : false;

			$template[$field] = (isset($field_data['Default'])) ? $field_data['Default'] : '';
		}
		return $template;
	}
	
	function field_data($table)
	{
		return $this->db->list_fields($table);
	}
	
	function gen_xml_structure()
	{
		$xml_data = '	
		<xsd:schema id="VFPData" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
		<xsd:element name="VFPData" msdata:IsDataSet="true">
			<xsd:complexType>
				<xsd:choice maxOccurs="unbounded">
					<xsd:element name="'.$this->table.'" minOccurs="0" maxOccurs="unbounded">
						<xsd:complexType>
							<xsd:sequence>
							';
		// get table structure
		$this->db->select('column_name,data_type,character_maximum_length,numeric_precision,numeric_precision_radix,numeric_scale');
		$where['table_name'] = $this->table;
		$where['table_schema'] = 'public';
		if ($this->schema)
			$where['table_schema'] = $this->schema;
		$this->db->where($where);
		$this->db->order_by('ordinal_position', 'ASC');
		$query = $this->db->get('information_schema.columns');

		// Start SCanning
		foreach($query->result_array() as $row)
		{
			if ($row['data_type'] == 'character varying')
			{
				$xml_data.= '<xsd:element name="'.$row['column_name'].'" minOccurs="0">
						<xsd:simpleType>
							<xsd:restriction base="xsd:string">
								<xsd:maxLength value="'.$row['character_maximum_length'].'"/>
							</xsd:restriction>
						</xsd:simpleType>
					</xsd:element>
					';
			}elseif ($row['data_type'] == 'numeric')
			{
				$xml_data.= '<xsd:element name="'.$row['column_name'].'" minOccurs="0">
						<xsd:simpleType>
							<xsd:restriction base="xsd:decimal">
								<xsd:totalDigits value="'.$row['numeric_precision_radix'].'"/>
								<xsd:fractionDigits value="'.$row['numeric_scale'].'"/>
							</xsd:restriction>
						</xsd:simpleType>
					</xsd:element>
					';
			}elseif ($row['data_type'] == 'integer' || $row['data_type'] == 'smallint' )
			{
				$xml_data.= '<xsd:element name="'.$row['column_name'].'" minOccurs="0">
						<xsd:simpleType>
							<xsd:restriction base="xsd:decimal">
								<xsd:totalDigits value="25"/>
								<xsd:fractionDigits value="'.$row['numeric_scale'].'"/>
							</xsd:restriction>
						</xsd:simpleType>
					</xsd:element>
					';
			}elseif ($row['data_type'] == 'timestamp without time zone')
			{
				$xml_data.= '<xsd:element name="'.$row['column_name'].'" type="xsd:dateTime" minOccurs="0"/>
							';
			}elseif ($row['data_type'] == 'date')
			{
				$xml_data.= '<xsd:element name="'.$row['column_name'].'" type="xsd:date" minOccurs="0"/>
				';
			}
		}
		// end scanning
		$xml_data.= '
			</xsd:sequence>
							</xsd:complexType>
						</xsd:element>
					</xsd:choice>
					<xsd:anyAttribute namespace="http://www.w3.org/XML/1998/namespace" processContents="lax"/>
				</xsd:complexType>
			</xsd:element>
		</xsd:schema>
		';
		return $xml_data;
	}
	
}