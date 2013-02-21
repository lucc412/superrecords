<?php defined('_JEXEC') OR die('Access Denied!');

class y_axis extends y_axis_base
{
	function y_axis(){}
	
	/**
	 * @param $colour as string. The grid are the lines inside the chart.
	 * HEX colour, e.g. '#ff0000'
	 */
	function set_grid_colour( $colour )
	{
		$tmp = 'grid-colour';
		$this->$tmp = $colour;
	}
	
}