<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('anchor'))
{
	function anchor($uri = '', $title = '', $attributes = '')
	{
		$site_url = site_url().'/'.rtrim($uri);

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
	}
}



/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */
