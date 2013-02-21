<?php defined('_JEXEC') OR die('Access Denied!');

class line_style
{
	function line_style($on, $off)
	{
		$this->style	= "dash";
		$this->on		= $on;
		$this->off		= $off;
	}
}