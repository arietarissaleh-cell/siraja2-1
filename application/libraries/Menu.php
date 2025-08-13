<?php

class Menu
{
	private $lang = '';

	function Menu()
	{
		$this->CI = &get_instance();
	}

	function build()
	{
		$id_ms_operator = $this->CI->session->userdata('id_ms_operator');
		$this->lang = get_language();

		// Menu Utama
		$this->CI->db->where('am.fid_app_menu', 0);
		$this->CI->db->where('am.app_type', 'utama');
		$this->CI->db->where('am.id_app_menu IN 
        (SELECT "fid_app_menu"
        FROM "ms_operator_privilege" om
        WHERE om."fid_operator" = ' . $id_ms_operator . ')');
		$this->CI->db->order_by('order_by', 'ASC');
		$menu = $this->CI->db->get('app_menus am');

		$result = '';
		$no = 0;

		foreach ($menu->result() as $mn) {
			$no++;

			// Sub Menu 1
			$this->CI->db->where('am.fid_app_menu', $mn->id_app_menu);
			$this->CI->db->where('am.app_type', 'sub_menu1');
			$this->CI->db->where('am.id_app_menu IN 
            (SELECT "fid_app_menu"
            FROM "ms_operator_privilege" om
            WHERE om."fid_operator" = ' . $id_ms_operator . ')');
			$this->CI->db->order_by('order_by', 'ASC');
			$menu_sub = $this->CI->db->get('app_menus am');

			$result .= '<li>';
			$onclick = ($mn->url ? 'onclick="loadMainContent(\'' . $mn->url . '\')"' : '');
			$result .= '<a href="javascript:void(0);" class="' . ($menu_sub->num_rows() ? 'has-arrow' : '') . '" ' . $onclick . '>';
			if ($mn->icon) {
				$result .= '<i class="' . $mn->icon . '"></i> ';
			}
			$result .= '<span>' . $mn->title . '</span>';
			$result .= '</a>';

			if ($menu_sub->num_rows() > 0) {
				$result .= '<ul>';
				foreach ($menu_sub->result() as $mn_sub) {
					// Sub Menu 2
					$this->CI->db->where('am.fid_app_menu', $mn_sub->id_app_menu);
					$this->CI->db->where('am.app_type', 'sub_menu2');
					$this->CI->db->where('am.id_app_menu IN 
                    (SELECT "fid_app_menu"
                    FROM "ms_operator_privilege" om
                    WHERE om."fid_operator" = ' . $id_ms_operator . ')');
					$this->CI->db->order_by('order_by', 'ASC');
					$menu_sub2 = $this->CI->db->get('app_menus am');

					$onclick = ($mn_sub->url ? 'onclick="loadMainContent(\'' . $mn_sub->url . '\')"' : '');
					$result .= '<li>';
					$result .= '<a href="javascript:void(0);" class="' . ($menu_sub2->num_rows() ? 'has-arrow' : '') . '" ' . $onclick . '>';
					$result .= '<span>' . $mn_sub->title . '</span>';
					$result .= '</a>';

					if ($menu_sub2->num_rows() > 0) {
						$result .= '<ul>';
						foreach ($menu_sub2->result() as $mn_sub2) {
							// Sub Menu 3
							$this->CI->db->where('am.fid_app_menu', $mn_sub2->id_app_menu);
							$this->CI->db->where('am.app_type', 'sub_menu3');
							$this->CI->db->where('am.id_app_menu IN 
                            (SELECT "fid_app_menu"
                            FROM "ms_operator_privilege" om
                            WHERE om."fid_operator" = ' . $id_ms_operator . ')');
							$this->CI->db->order_by('order_by', 'ASC');
							$menu_sub3 = $this->CI->db->get('app_menus am');

							$onclick2 = ($mn_sub2->url ? 'onclick="loadMainContent(\'' . $mn_sub2->url . '\')"' : '');
							$result .= '<li>';
							$result .= '<a href="javascript:void(0);" class="' . ($menu_sub3->num_rows() ? 'has-arrow' : '') . '" ' . $onclick2 . '>';
							$result .= '<span>' . $mn_sub2->title . '</span>';
							$result .= '</a>';

							if ($menu_sub3->num_rows() > 0) {
								$result .= '<ul>';
								foreach ($menu_sub3->result() as $mn_sub3) {
									$onclick3 = ($mn_sub3->url ? 'onclick="loadMainContent(\'' . $mn_sub3->url . '\')"' : '');
									$result .= '<li><a href="javascript:void(0);" ' . $onclick3 . '>';
									$result .= '<span>' . $mn_sub3->title . '</span>';
									$result .= '</a></li>';
								}
								$result .= '</ul>';
							}

							$result .= '</li>';
						}
						$result .= '</ul>';
					}

					$result .= '</li>';
				}
				$result .= '</ul>';
			}

			$result .= '</li>';
		}

		echo $result;
	}
}
