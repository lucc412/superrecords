<?php

defined('_JEXEC') or die('No Access Allowed');

$anujMessage = $params->get('anujMessage');

require_once dirname(__FILE__).'/helper.php';

require JModuleHelper::getLayoutPath('mod_freetrial',$params->get('Layout','default'));
