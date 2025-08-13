<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Priv_menu_mobile extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('operator_mobile_model');
		$this->load->model('menus_mobile_model');
		$this->load->model('menus_shortcut_mobile_model');
		$this->load->model('menus_shortcut_priv_mobile_model');
		$this->load->model('menus_priv_mobile_model');
		
	}
	
	
	public function index()
	{
		//$this->page();
		$data = array('name' 	=> 	$this->session->userdata('name')
				,'content' 		=> 	'utilities/akun_mobile/main'
				,'title' 		=> 	'Privasi Menu'
		);
		$this->load('tpl',$data['content'],$data);
	}
	
	function input($id=0)
	{
		$id = decode($id);
		$mn = 0;
		$operator = $this->operator_mobile_model->get($id);
		
		//
		//$app_menu = '<table class="table table-striped table-bordered table-advance table-hover">';
		$app_menu = '<table style="width: 100%;">';
		$app_menu .= '<thead>
							<tr>
								<th style="width:125px;"><p class="lead border-bottom">Menu</p></th>
								<th style="width:260px;"><p class="lead border-bottom">Sub Menu</p></th>
								<th style="width:300px;"><p class="lead border-bottom">Shortcut Sub Menu</p></th>
							</tr>
						</thead>';
		$app_menu .= '<tbody>';
		$app_menu .= $this->_load_menu($id,$mn);
		$app_menu .= '</tr>';
		$app_menu .= '</tbody>';
		$app_menu .= '</table>';
		// load read
		$data['content']		= 'utilities/priv_menu_mobile/input';
		$data['app_menu']		= $app_menu;
		$data['operator']		= $operator;
		// $data['priv_create_operator'] = check_privileges('create');
		// echo $app_menu;
		// exit;
		$data['title']			= $operator['username'];
		$this->load->view($data['content'], $data);
	}
	/*
	*/
	private function _load_menu($id=0,$mn=0)
	{
		$content = '';
		$menu_list = array();
		$where['tbl.fid_app_menu'] = $mn;
		// $where['tbl.fid_operator'] = $id;
		$this->menus_mobile_model->set_where($where);
		// $menu_list = $this->menus_model->get_list();
		$menu_list = $this->menus_mobile_model->get_list_menu($id);
		// echo $this->db->last_query();
		$content .= '<tr>';
		foreach($menu_list->result_array() as $row)
		{
			
			if($row['fid_app_menu']==0)
			{
				$content .= '<td>
								<div class="uniformjs">
									<label>
										<input type="checkbox" name="cb_id_menu_'.$row['id_app_menu'].'" id="id_menu_'.$row['id_app_menu'].'" '.($row['fid_operator']?'checked="checked"':'').'>'.$row['menu_title'].'
										<input type="hidden" name="t_id_menu_'.$row['id_app_menu'].'"  value="'.$row['id_app_menu'].'"/>
										
									</label>
								</div>
							</td>';
			}else{
				$content .= '<td></td>';
				$content .= '<td>
								<div class="uniformjs">
									<label>
										<input type="checkbox" name="cb_id_menu_'.$row['id_app_menu'].'" id="id_menu_'.$row['id_app_menu'].'" '.($row['fid_operator']?'checked="checked"':'').'>'.$row['menu_title'].'
										<input type="hidden" name="t_id_menu_'.$row['id_app_menu'].'"  value="'.$row['id_app_menu'].'"/>
									</label>
								</div>
							</td>';
				$content .= '<td></td>';
				$content .= $this->_load_menu_sub($id,$row['id_app_menu']);
			}
			$content .= $this->_load_menu($id,$row['id_app_menu']);
		}
		$content .= '</tr>';
		return $content;
	}
	
	private function _load_menu_sub($id=0,$mn=0)
	{
		
		$content = '';
		$menu_sub_list = array();
		$where['tbl.fid_app_menu'] = $mn;
		// $where['usr.fid_operator'] = $id;
		$this->menus_shortcut_mobile_model->set_where($where);
		// $menu_sub_list = $this->menus_shortcut_model->get_list();
		$menu_sub_list = $this->menus_shortcut_mobile_model->get_list_shortcut($id);
		$content = '';
		$content .= '<tr>';
		foreach($menu_sub_list->result_array() as $row)
		{
			$content .= '<td></td>';
			$content .= '<td></td>';
			$content .= '<td>
							<div class="uniformjs">
								<label>
									<input type="checkbox" name="cb_id_menu_shortcut_'.$row['id_app_menu_shortcut'].'" id="id_menu_shortcut_'.$row['id_app_menu_shortcut'].'" '.($row['fid_operator']?'checked="checked"':'').'>'.$row['title'].'
									<input type="hidden" name="t_id_menu_shortcut_'.$row['id_app_menu_shortcut'].'"  value="'.$row['id_app_menu_shortcut'].'"/>
								</label>
							</div>
						</td>';
			$content .= '<td>
							<div class="row-fluid">                            
								<div class="span12">
									<div>
										<div class="uniformjs">
											<label>
												<input type="checkbox" name="cb_read_'.$row['id_app_menu_shortcut'].'" id="read_'.$row['id_app_menu_shortcut'].'" '.($row['read']?'checked="checked"':'').'>read
												<input type="hidden" name="t_read_'.$row['id_app_menu_shortcut'].'"  value="1"/>
												<input type="checkbox" name="cb_create_'.$row['id_app_menu_shortcut'].'" id="create_'.$row['id_app_menu_shortcut'].'" '.($row['create']?'checked="checked"':'').'>Create
												<input type="hidden" name="t_create_'.$row['id_app_menu_shortcut'].'"  value="1"/>
												<input type="checkbox" name="cb_update_'.$row['id_app_menu_shortcut'].'" id="update_'.$row['id_app_menu_shortcut'].'" '.($row['update']?'checked="checked"':'').'>update
												<input type="hidden" name="t_update_'.$row['id_app_menu_shortcut'].'"  value="1"/>
												<input type="checkbox" name="cb_delete_'.$row['id_app_menu_shortcut'].'" id="delete_'.$row['id_app_menu_shortcut'].'" '.($row['delete']?'checked="checked"':'').'>Delete
												<input type="hidden" name="t_delete_'.$row['id_app_menu_shortcut'].'"  value="1"/>
											</label>
										</div>
									</div>
								</div>
							</div>
						</td>';
			$content .= $this->_load_menu_sub($id);
		}
		$content .= '</tr>';
		return $content;
	}
	
	
	function save()
	{
		$id_operator = decode($this->input->post('t_id_ms_operator'));
		// $app_menu = $this->menus_priv_mobile_model->get($id_operator);
		// $shortcut_menu = $this->menus_shortcut_priv_mobile_model->get($id_operator);
		$this->db->trans_start();
		$saved ='';
		$menu = $this->menus_mobile_model->get_list_menu($id_operator);
		$menu_shortcut = $this->menus_shortcut_mobile_model->get_list_shortcut($id_operator);
		// $menu = $this->menus_priv_model->get_list();
		$error = '';
		foreach($menu->result() as $row)
		{
			$is_check_menu = $this->input->post('cb_id_menu_'.$row->id_app_menu);
			$id_menu = $this->input->post('t_id_menu_'.$row->id_app_menu);
			//
			$data_menu = array();
			$data_menu['fid_operator'] = $id_operator;			
			$data_menu['fid_app_menu'] = $row->id_app_menu;			
			
			if ($is_check_menu)
			{
				$pv = $this->menus_priv_mobile_model->get($data_menu);
				if (!$pv['id_privilege'])
				{
					$data_menu['id_privilege'] = 0;			
					$saved = $this->menus_priv_mobile_model->save($data_menu);
				}	
			}
			else
			{
				//hapus dari table
				$this->menus_priv_mobile_model->delete($data_menu);
			}
		}
		//update other
		
		//end update
		foreach($menu_shortcut->result() as $srt)
		{
			// echo($srt->id_privilege_shortcut);
			// exit;
			$is_check_shortcut = $this->input->post('cb_id_menu_shortcut_'.$srt->id_app_menu_shortcut);
			$is_check_read = $this->input->post('cb_read_'.$srt->id_app_menu_shortcut);
			$is_check_create = $this->input->post('cb_create_'.$srt->id_app_menu_shortcut);
			$is_check_update = $this->input->post('cb_update_'.$srt->id_app_menu_shortcut);
			$is_check_delete = $this->input->post('cb_delete_'.$srt->id_app_menu_shortcut);
			//value
			$read = $this->input->post('t_read_'.$srt->id_app_menu_shortcut);
			$create = $this->input->post('t_create_'.$srt->id_app_menu_shortcut);
			$update = $this->input->post('t_update_'.$srt->id_app_menu_shortcut);
			$delete = $this->input->post('t_delete_'.$srt->id_app_menu_shortcut);
			// $id_menu = $this->input->post('t_id_menu_shortcut_'.$row->id_app_menu_shortcut);
			//
			$data_srt = array();
			$data_srt['id_privilege_shortcut'] = $srt->id_privilege_shortcut;
			$data_srt['fid_operator'] = $id_operator;			
			$data_srt['fid_app_menu'] = $srt->fid_app_menu;			
			$data_srt['fid_app_menu_shortcut'] = $srt->id_app_menu_shortcut;
			
			if ($is_check_shortcut)
			{
				if ($is_check_read)
				{
					$data_srt['read'] = $read;
				}
				if ($is_check_create)
				{
					$data_srt['create'] = $create;
				}else{
					$data_srt['create'] = 0;
				}
				if ($is_check_update)
				{
					$data_srt['update'] = $update;
				}
				if ($is_check_delete)
				{
					$data_srt['delete'] = $delete;
				}
				// echo print_r($data_srt);
				// exit;
				$pvl = $this->menus_shortcut_priv_mobile_model->get($data_srt['id_privilege_shortcut']);
				if (!$pvl['id_privilege_shortcut'])
				{
					$data_srt['id_privilege_shortcut'] = 0;			
					// echo ('hags');
					// exit;
					
				}
				$save = $this->menus_shortcut_priv_mobile_model->save($data_srt);
					
			}else
				{
					//hapus dari table
					$this->menus_shortcut_priv_mobile_model->delete($data_srt);
				}
			}
		/**/
		// echo $this->db->last_query();
		// exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() === false)
			$this->error('Data gagal diproses');
		else{
			$this->update['id_ms_operator'] = encode($id_operator);
			$this->success('Data telah diproses');
		}
		}
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
*/

