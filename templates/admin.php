<?php
if (!isset($_SESSION['user'])) Router::redirect('admin/login'); 
$username = $_SESSION['user']['username'];
$menu = array(
	'admin/posts'=>array('title'=>'Posts'),
	'admin/users'=>array('title'=>'Users'),
	'admin/settings'=>array('title'=>'Settings'),
);
array_walk($menu, function(&$item,$url) { 
	$item['active'] = substr(Router::getUrl(),0,strlen($url))==$url?'active':''; 
});

if (isset($_SESSION['flash_messages'])) {
	$flashMessages = $_SESSION['flash_messages'];
	unset($_SESSION['flash_messages']);
} else {
	$flashMessages = array();
}