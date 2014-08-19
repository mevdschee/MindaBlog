<?php
$rows = Query::records('select * from settings');
$settings = array();
array_walk($rows, function($v,$k) use (&$settings) { 
	$settings[$v['settings']['key']] = $v['settings']['value']; 
});
$_SESSION['settings'] = $settings;