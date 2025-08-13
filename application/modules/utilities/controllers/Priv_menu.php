<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Priv_menu extends MY_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model('operator_model');
		$this->load->model('menus_model');
		$this->load->model('menus_shortcut_model');
		$this->load->model('menus_shortcut_priv_model');
		$this->load->model('menus_priv_model');
	}


	public function index()
	{
		//$this->page();
		$data = array(
			'name' 	=> 	$this->session->userdata('name'),
			'content' 		=> 	'utilities/akun/main',
			'title' 		=> 	'Privasi Menu'
		);
		$this->load('tpl', $data['content'], $data);
	}

	function input($id = 0)
	{
		$id_ms_operator = $this->session->userdata('id_ms_operator');
		$id = decode($id);
		$mn = 0;

		$operator = $this->operator_model->get($id);
		$menu = $this->db->query("SELECT * FROM PUBLIC.app_menus")->result();

		$priv = $this->db->query("SELECT fid_app_menu, is_create, is_read, is_update, is_delete, is_export, is_approve
			FROM PUBLIC.ms_operator_privilege 
			WHERE fid_operator = '$id'")->result();

		$menu_user = [];
		$user_permissions = [];

		if ($priv) {
			foreach ($priv as $dt) {
				$menu_user[] = $dt->fid_app_menu;

				$permissions = [];
				if ($dt->is_create == 1) $permissions[] = 'create';
				if ($dt->is_read == 1) $permissions[] = 'read';
				if ($dt->is_update == 1) $permissions[] = 'update';
				if ($dt->is_delete == 1) $permissions[] = 'delete';
				if ($dt->is_export == 1) $permissions[] = 'export';
				if ($dt->is_approve == 1) $permissions[] = 'approve';


				$user_permissions[$dt->fid_app_menu] = $permissions;
			}
		} else {
			$menu_user[] = null;
		}

		$app_menu = '<table style="width: 100%;">';
		$app_menu .= '<thead>
		<tr>
		<th style="width:125px;"><p class="lead border-bottom">Menu</p></th>
		</thead>';
		$app_menu .= '<tbody>';
		$app_menu .= $this->_load_menu($id, $mn);
		$app_menu .= '</tr>';
		$app_menu .= '</tbody>';
		$app_menu .= '</table>';

		// Load ke view
		$data['content']			= 'utilities/priv_menu/input';
		$data['app_menu']			= $app_menu;
		$data['operator']			= $operator;
		$data['menu']				= $menu;
		$data['menu_user']			= $menu_user;
		$data['user_permissions']	= $user_permissions;
		$data['title']				= $operator['username'];

		$this->load->view($data['content'], $data);
	}




	/*
	*/
	private function _load_menu($id = 0, $mn = 0)
	{
		$content = '';
		$menu_list = array();
		$where['tbl.fid_app_menu'] = $mn;
		// $where['tbl.fid_operator'] = $id;
		$this->menus_model->set_where($where);
		// $menu_list = $this->menus_model->get_list();
		$menu_list = $this->menus_model->get_list_menu($id);
		// echo $this->db->last_query();
		$content .= '<tr>';
		foreach ($menu_list->result_array() as $row) {

			if ($row['fid_app_menu'] == 0) {
				$content .= '<td>
				<div class="uniformjs">
				<label>
				<input type="checkbox" name="cb_id_menu_' . $row['id_app_menu'] . '" id="id_menu_' . $row['id_app_menu'] . '" ' . ($row['fid_operator'] ? 'checked="checked"' : '') . '>' . $row['title'] . '
				<input type="hidden" name="t_id_menu_' . $row['id_app_menu'] . '"  value="' . $row['id_app_menu'] . '"/>
				
				</label>
				</div>
				</td>';
			} else {
				$content .= '<td></td>';
				$content .= '<td>
				<div class="uniformjs">
				<label>
				<input type="checkbox" name="cb_id_menu_' . $row['id_app_menu'] . '" id="id_menu_' . $row['id_app_menu'] . '" ' . ($row['fid_operator'] ? 'checked="checked"' : '') . '>' . $row['title'] . '
				<input type="hidden" name="t_id_menu_' . $row['id_app_menu'] . '"  value="' . $row['id_app_menu'] . '"/>
				</label>
				</div>
				</td>';
				$content .= '<td></td>';
			}
			$content .= $this->_load_menu($id, $row['id_app_menu']);
		}
		$content .= '</tr>';
		return $content;
	}

	private function _load_menu_sub($id = 0, $mn = 0)
	{

		$content = '';
		$menu_sub_list = array();
		$where['tbl.fid_app_menu'] = $mn;
		// $where['usr.fid_operator'] = $id;
		$this->menus_shortcut_model->set_where($where);
		// $menu_sub_list = $this->menus_shortcut_model->get_list();
		$menu_sub_list = $this->menus_shortcut_model->get_list_shortcut($id);
		$content = '';
		$content .= '<tr>';
		foreach ($menu_sub_list->result_array() as $row) {
			$content .= '<td></td>';
			$content .= '<td></td>';
			$content .= '<td>
			<div class="uniformjs">
			<label>
			<input type="checkbox" name="cb_id_menu_shortcut_' . $row['id_app_menu_shortcut'] . '" id="id_menu_shortcut_' . $row['id_app_menu_shortcut'] . '" ' . ($row['fid_operator'] ? 'checked="checked"' : '') . '>' . $row['title'] . '
			<input type="hidden" name="t_id_menu_shortcut_' . $row['id_app_menu_shortcut'] . '"  value="' . $row['id_app_menu_shortcut'] . '"/>
			</label>
			</div>
			</td>';
			$content .= '<td>
			<div class="row-fluid">                            
			<div class="span12">
			<div>
			<div class="uniformjs">
			<label>
			<input type="checkbox" name="cb_read_' . $row['id_app_menu_shortcut'] . '" id="read_' . $row['id_app_menu_shortcut'] . '" ' . ($row['read'] ? 'checked="checked"' : '') . '>read
			<input type="hidden" name="t_read_' . $row['id_app_menu_shortcut'] . '"  value="1"/>
			<input type="checkbox" name="cb_create_' . $row['id_app_menu_shortcut'] . '" id="create_' . $row['id_app_menu_shortcut'] . '" ' . ($row['create'] ? 'checked="checked"' : '') . '>Create
			<input type="hidden" name="t_create_' . $row['id_app_menu_shortcut'] . '"  value="1"/>
			<input type="checkbox" name="cb_update_' . $row['id_app_menu_shortcut'] . '" id="update_' . $row['id_app_menu_shortcut'] . '" ' . ($row['update'] ? 'checked="checked"' : '') . '>update
			<input type="hidden" name="t_update_' . $row['id_app_menu_shortcut'] . '"  value="1"/>
			<input type="checkbox" name="cb_delete_' . $row['id_app_menu_shortcut'] . '" id="delete_' . $row['id_app_menu_shortcut'] . '" ' . ($row['delete'] ? 'checked="checked"' : '') . '>Delete
			<input type="hidden" name="t_delete_' . $row['id_app_menu_shortcut'] . '"  value="1"/>
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

	// function save_hirarki(){
	// 	$operator = $this->input->post("t_id_ms_operator");
	// 	$fidunit = $this->input->post("t_fid_unit");
	// 	$menus = $this->input->post("menus");

	// 	$this->db->trans_start();

	// 	$this->db->query("
	// 		DELETE FROM ms_operator_privilege WHERE fid_operator = '$operator' AND fid_unit = '$fidunit';
	// 		");
	// 	for ($i=0; $i < count($menus); $i++) { 
	// 		$this->db->query("
	// 			INSERT INTO ms_operator_privilege (fid_operator, fid_unit, fid_app_menu) VALUES ('$operator', '$fidunit', $menus[$i])
	// 			");
	// 	}
	// 	$this->db->trans_complete();
	// 	if ($this->db->trans_status() === false){
	// 		$this->db->trans_rollback();
	// 		$this->error('Proses gagal');

	// 	}else{
	// 		$this->success('Data Berhasil Disimpan..');
	// 		$this->db->trans_commit();
	// 	}

	// }

	function save_hirarki()
	{
		$operator = $this->input->post("t_id_ms_operator");
		$fidunit = $this->input->post("t_fid_unit");
		$menus = $this->input->post("menus");
		$permissions = $this->input->post("permissions");

		$this->db->trans_start();

		$this->db->query("DELETE FROM ms_operator_privilege WHERE fid_operator = '$operator' AND fid_unit = '$fidunit'");

		if (!empty($menus)) {
			foreach ($menus as $menu_id) {
				// Default: semua permission 0
				$create = $read = $update = $delete = $export = $approve = 0;

				if (isset($permissions[$menu_id])) {
					$perm = $permissions[$menu_id];
					$create = in_array('create', $perm) ? 1 : 0;
					$read   = in_array('read',   $perm) ? 1 : 0;
					$update = in_array('update', $perm) ? 1 : 0;
					$delete = in_array('delete', $perm) ? 1 : 0;
					$export = in_array('export', $perm) ? 1 : 0;
					$approve = in_array('approve', $perm) ? 1 : 0;
				}

				// Simpan dengan permission
				$this->db->query("
					INSERT INTO ms_operator_privilege 
					(fid_operator, fid_unit, fid_app_menu, is_create, is_read, is_update, is_delete, is_export, is_approve)
					VALUES 
					('$operator', '$fidunit', $menu_id, $create, $read, $update, $delete, $export, $approve)
					");
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->error('Proses gagal');
		} else {
			$this->db->trans_commit();
			$this->success('Data Berhasil Disimpan..');
		}
	}



	function save()
	{
		$id_operator = decode($this->input->post('t_id_ms_operator'));
		// $app_menu = $this->menus_priv_model->get($id_operator);
		// $shortcut_menu = $this->menus_shortcut_priv_model->get($id_operator);
		$this->db->trans_start();
		$saved = '';
		$menu = $this->menus_model->get_list_menu($id_operator);
		$menu_shortcut = $this->menus_shortcut_model->get_list_shortcut($id_operator);
		// $menu = $this->menus_priv_model->get_list();
		$error = '';
		foreach ($menu->result() as $row) {
			$is_check_menu = $this->input->post('cb_id_menu_' . $row->id_app_menu);
			$id_menu = $this->input->post('t_id_menu_' . $row->id_app_menu);
			//
			$data_menu = array();
			$data_menu['fid_operator'] = $id_operator;
			$data_menu['fid_app_menu'] = $row->id_app_menu;

			if ($is_check_menu) {
				$pv = $this->menus_priv_model->get($data_menu);
				if (!$pv['id_privilege']) {
					$data_menu['id_privilege'] = 0;
					$saved = $this->menus_priv_model->save($data_menu);
				}
			} else {
				//hapus dari table
				//$this->menus_priv_model->delete($data_menu);
			}
		}
		//update other

		//end update
		// foreach($menu_shortcut->result() as $srt)
		// {
		// 	// echo($srt->id_privilege_shortcut);
		// 	// exit;
		// 	$is_check_shortcut = $this->input->post('cb_id_menu_shortcut_'.$srt->id_app_menu_shortcut);
		// 	$is_check_read = $this->input->post('cb_read_'.$srt->id_app_menu_shortcut);
		// 	$is_check_create = $this->input->post('cb_create_'.$srt->id_app_menu_shortcut);
		// 	$is_check_update = $this->input->post('cb_update_'.$srt->id_app_menu_shortcut);
		// 	$is_check_delete = $this->input->post('cb_delete_'.$srt->id_app_menu_shortcut);
		// 	//value
		// 	$read = $this->input->post('t_read_'.$srt->id_app_menu_shortcut);
		// 	$create = $this->input->post('t_create_'.$srt->id_app_menu_shortcut);
		// 	$update = $this->input->post('t_update_'.$srt->id_app_menu_shortcut);
		// 	$delete = $this->input->post('t_delete_'.$srt->id_app_menu_shortcut);
		// 	// $id_menu = $this->input->post('t_id_menu_shortcut_'.$row->id_app_menu_shortcut);
		// 	//
		// 	$data_srt = array();
		// 	$data_srt['id_privilege_shortcut'] = $srt->id_privilege_shortcut;
		// 	$data_srt['fid_operator'] = $id_operator;			
		// 	$data_srt['fid_app_menu'] = $srt->fid_app_menu;			
		// 	$data_srt['fid_app_menu_shortcut'] = $srt->id_app_menu_shortcut;

		// 	// if ($is_check_shortcut)
		// 	// {
		// 	// 	if ($is_check_read)
		// 	// 	{
		// 	// 		$data_srt['read'] = $read;
		// 	// 	}
		// 	// 	if ($is_check_create)
		// 	// 	{
		// 	// 		$data_srt['create'] = $create;
		// 	// 	}else{
		// 	// 		$data_srt['create'] = 0;
		// 	// 	}
		// 	// 	if ($is_check_update)
		// 	// 	{
		// 	// 		$data_srt['update'] = $update;
		// 	// 	}
		// 	// 	if ($is_check_delete)
		// 	// 	{
		// 	// 		$data_srt['delete'] = $delete;
		// 	// 	}
		// 	// 	// echo print_r($data_srt);
		// 	// 	// exit;
		// 	// 	$pvl = $this->menus_shortcut_priv_model->get($data_srt['id_privilege_shortcut']);
		// 	// 	if (!$pvl['id_privilege_shortcut'])
		// 	// 	{
		// 	// 		$data_srt['id_privilege_shortcut'] = 0;			
		// 	// 		// echo ('hags');
		// 	// 		// exit;

		// 	// 	}
		// 	// 	$save = $this->menus_shortcut_priv_model->save($data_srt);

		// 	// }else
		// 	// 	{
		// 	// 		//hapus dari table
		// 	// 		$this->menus_shortcut_priv_model->delete($data_srt);
		// 	// 	}
		// 	}
		/**/
		// echo $this->db->last_query();
		// exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() === false)
			$this->error('Data gagal diproses');
		else {
			$this->update['id_ms_operator'] = encode($id_operator);
			$this->success('Data telah diproses');
		}
	}
}
/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
*/
