<?php defined('_JEXEC') OR die('Access Denied!');

class radar_axis_labels
{
	// $labels : array
	function radar_axis_labels( $labels )
	{
		$this->labels = $labels;
	}
	
	function set_colour( $colour )
	{
		$this->colour = $colour;
	}
}