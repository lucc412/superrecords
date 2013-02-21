<?php
defined('_JEXEC') or die('Restricted access');
### Copyright (c) 2006-2012 Joobi Limited. All rights reserved.
### license GNU GPLv3 , link http://www.joobi.co

 class outputReportType {

 	public static function reportType($selected){
		$values = array();
		$values[] = jnews::HTML_SelectOption( 'listing', JText::_(_JNEWS_REPORT_LISTING) );
		$values[] = jnews::HTML_SelectOption( 'graph', JText::_(_JNEWS_REPORT_GRAPH) );

		return jnews::HTML_RadioList(   $values, "rpttype", 'class="inputbox" size="1"', 'value', 'text',$selected);
	}
 }

