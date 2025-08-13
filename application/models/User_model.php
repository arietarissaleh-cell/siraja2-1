<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
	function loggingIn($u, $pw) { //untuk login
        $this->db->select('id_user,usergroup_id,name');
        $this->db->where('username', $u);
        $this->db->where('password', $pw);
        //$this->db->where('password', md5($pw));
        $this->db->limit(1);
        $Q = $this->db->get('user');
        if ($Q->num_rows() > 0) {
            $row = $Q->row_array();
            return $row;
        } else {
            $this->session->set_flashdata('pesan', 'Wrong username/password!');
            return array();
        }
    }

    function getUserDetail($id_user) { //untuk detail user
        $q = $this->db->query("SELECT u.id_user, u.username, u.usergroup_id, g.usergroup_name, u.name FROM user u, user_group g WHERE u.id_user=$id_user AND g.usergroup_id=u.usergroup_id");
        if ($q->num_rows()>0){
            foreach ($q->result() as $rows){
                $data[] = $rows;
            }           
        } else {
            $data = 0;
        }
        $q->free_result();
        return $data;
    }
	
	function getGroupDetail($id_usergroup) { //untuk detail user group
        $q = $this->db->query("SELECT * FROM user_group WHERE usergroup_id=$id_usergroup");
        if ($q->num_rows()>0){
            foreach ($q->result() as $rows){
                $data[] = $rows;
            }           
        } else {
            $data = 0;
        }
        $q->free_result();
        return $data;
    }

    function updateUser($id,$data=array()) { //update profil
        $this->db->where('id_user',$id);
        if($this->db->update('user',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
    }
	
	function updateUserPass($id,$data=array()) { //update profil
        $this->db->where('id_user',$id);
        if($this->db->update('user',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    function addUser($data=array()) { //tambah user baru
        if($this->db->insert('user',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
    }
	

    function deleteUser($id) { //hapus user
        if($this->db->delete('user', array('id_user' => $id))){
			$this->optimize();
			return TRUE;
		}else{
			return FALSE;
		}
    }
	
	function deleteGroup($id) { //hapus user
        if($this->db->delete('user_group', array('usergroup_id' => $id))){
			$this->optimize();
			return TRUE;
		}else{
			return FALSE;
		}
    }

    function userList($limit=0, $offset=0) { //daftar user
		$this->db->select('*, user_group.usergroup_name');
		$this->db->from('user');
		$this->db->join('user_group', 'user_group.usergroup_id = user.usergroup_id');
		$this->db->limit($limit, $offset);       
		$sql = $this->db->get();
        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $sql->free_result();
        return $data;
    }
         
    function countListUser() { //hitung user
        $q = $this->db->count_all('user');
        return $q;
    }
	
	function userGroup($limit=0, $offset=0) { //daftar grup user
		$sql = $this->db->get('user_group', $limit, $offset);
        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
           		$data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $sql->free_result();
        return $data;
    }
         
    function countUserGroup() { //hitung grup user
        $q = $this->db->count_all('user_group');
        return $q;
    } 
	
	function getUserGroup()
	{
		$q = $this->db->get('user_group');
		if($q->num_rows()>0){
            foreach ($q->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $q->free_result();
        return $data;
	}
	
	function addGroup($data=array()) { //tambah group user baru
	    if($this->checkGroup($data['usergroup_name'], 0)){
			return "taken";
		}else{
			if($this->db->insert('user_group',$data)){
				return "sukses";
			}else{
				return "gagal";
			}
		}
    }
	
	function updateGroup($id, $data=array()) { //update group user baru
        if($this->checkGroup($data['usergroup_name'], $id)){
			return "taken";
		}else{
			if($this->db->query("UPDATE user_group SET usergroup_name='".$data['usergroup_name']."' WHERE usergroup_id=$id")){
				return "sukses";
			}else{
				return "gagal";
			}
		}
    }
	
	function checkGroup($ug, $id){
		if($id){
        	$q=$this->db->get_where('user_group', array('usergroup_name'=>$ug, 'usergroup_id <>'=>$id));
		}else{
			$q=$this->db->get_where('user_group', array('usergroup_name'=>$ug));
		}
        if($q->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
	}
	
	function isUserRegistered($u)
	{
		$this->db->select('id_user');
        $this->db->where('username',$u);
        $q=$this->db->get('user');
        if($q->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
	}
	
	function checkPass($id, $pwd)
	{
        $this->db->where('password',$pwd);
        $q=$this->db->get_where('user', array('id_user'=>$id,'password'=>$pwd));
        if($q->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
	}
	
	function optimize(){
		$this->db->query('optimize table user, user_group');
	}
    
	function userListMenuDetail() { //daftar user
		
        $uid = $this->session->userdata('id_user');     
		$sql = $this->db->query('
            SELECT *
            FROM (`mst_user`)
            JOIN `sys_usergroupmenu` ON `sys_usergroupmenu`.`usergroup_id` = `mst_user`.`usergroup_id`
            JOIN `sys_submenu` ON `sys_submenu`.`menu_id` = `sys_usergroupmenu`.`menu_id`
            WHERE  `mst_user`.`id_user` = '.$uid.'
			order by sys_submenu.position asc
        ');
        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $sql->free_result();
        return $data;
    }
    
    function userListMenu() { //daftar user

        $uid = $this->session->userdata('id_user');
        /*$sql = $this->db->query('
        select DISTINCT menu_id
        FROM (`user_setmenu`)
        JOIN `sys_submenu` ON `sys_submenu`.`submenu_id` = `user_setmenu`.`submenu_id`
        JOIN `user` ON `user_setmenu`.`id_user` =`user`.`id_user` 
        WHERE  `user_setmenu`.`id_user` = '.$uid.'
        ');		
        */
        $sql = $this->db->query('
            SELECT *
            FROM (`mst_user`)
            JOIN `sys_usergroupmenu` ON `sys_usergroupmenu`.`usergroup_id` = `mst_user`.`usergroup_id`
            WHERE  `mst_user`.`id_user` = '.$uid.'
            order by `sys_usergroupmenu`.`menu_id` asc
        ');
        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $sql->free_result();
        return $data;
    }
    
    function ListMenu() { //daftar user
		   
		$sql = $this->db->query('
            select * from user_group_menu
            join user_group on user_group.usergroup_id = user_group_menu.usergroup_id
            join sys_menu on sys_menu.menu_id = user_group_menu.menu_id
        ');
        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $sql->free_result();
        return $data;
    }
    
    function SubMenu($id) { //daftar user

        $sql = $this->db->query('
        SELECT *
        FROM (`sys_submenu`)
        JOIN `sys_subinmenu` ON `sys_subinmenu`.`submenu_id` = `sys_submenu`.`submenu_id` 
        WHERE  `sys_submenu`.`submenu_id`  = '.$id.'
		ORDER BY `sys_submenu`.`position` asc
        ');		

        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $sql->free_result();
        return $data;
    }
}