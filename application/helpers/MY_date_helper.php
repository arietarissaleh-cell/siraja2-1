<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getSQLDate'))
{
	function getSQLDate($inputDate) 
	{
		$return_value = 'NULL';
		if ($inputDate !='')
		{
			$date = null;
			if (strlen($inputDate) > 10)
			{
				list($date, $time) = explode(' ', $inputDate);
			}
			else
			{
				$date = $inputDate;
				$time = '00:00:00';
			}

			list($day, $month, $year) = preg_split("/[\/.-]/", $date);
			if (strlen($year)==2)
				list($year, $month, $day) = preg_split("/[\/.-]/", $date);
			
			$day = strlen($day)==1?'0'.$day:$day;
			$month = strlen($month)==1?'0'.$month:$month;
			$return_value = "$year$month$day";
			
		}
		return $return_value;
	}
}

if ( ! function_exists('mdate2mth'))
{
	function mdate2mth($mdate, $datestr = '%m',$str_rep='') 
	{
		if ($mdate != '' && $mdate != "0000-00-00")
		{
			$timestamp 	= strtotime($mdate);
			$datestr 	= str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));
			
			return date($datestr, $timestamp);
		}else
		{
			return $str_rep;
		}
	}
}

if ( ! function_exists('humanize_mdate'))
{
	function humanize_mdate($mdate, $datestr = '%d-%m-%Y',$str_rep='') 
	{
		if ($mdate != '' && $mdate != "0000-00-00")
		{
			$timestamp 	= strtotime($mdate);
			$datestr 	= str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));
			
			return date($datestr, $timestamp);
		}else
		{
			return $str_rep;
		}
	}
}

if ( ! function_exists('num2month'))
{
	function num2month($num=0,$type=1) 
	{
		$month[1]=array('Januari','Februari','Maret','April'
			,'Mei','Juni','Juli','Agustus','September'
			,'Oktober','November','Desember');
		$month[2]=array('Jan','Feb','Mar','Apr'
			,'Mei','Jun','Jul','Ags','Sep'
			,'Okt','Nov','Des');
		
		return $month[$type][$num-1];
	}
}

if ( ! function_exists('humanize_day'))
{
	function humanize_day($mdate) 
	{
		$day = array('Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu');
		$dt = strtotime($mdate);
		$dow = date('w',$dt);
		return $day[$dow];
	}
}
// check file poto is exist
if ( ! function_exists('int2time'))
{
	function int2time($value)
	{
		
		$hour = floor($value/60);
		$minute = $value - ($hour * 60);
		$return = (strlen($hour)==1?'0':'').$hour.':'.(strlen($minute)==1?'0':'').$minute;
		return $return;
	}
}
// check file poto is exist
if ( ! function_exists('time2int'))
{
	function time2int($value)
	{
		$return = $value;
		$time = explode(':',$return);
		$return = $time[0]*60+$time[1];
		return $return;
	}
}


/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */