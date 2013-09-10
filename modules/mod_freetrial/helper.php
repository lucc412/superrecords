<?php

defined ('_JEXEC') or die ('Not Access');

$db = JFactory::getDBO();

$query = $db->getQuery(true);

$query->select ('name') -> from ('#__users');

$db->setQuery($query);

$rows= $db->loadObjectList();
