<?php
if (!isset($_SESSION['user'])) Router::redirect('admin/login'); 
$menu = array(
	'admin2/posts'=>array('title'=>'Posts'),
	'admin2/users'=>array('title'=>'Users'),
	'admin2/settings'=>array('title'=>'Settings'),
);
array_walk($menu, function(&$item,$url) { 
	$item['active'] = substr(Router::getUrl(),0,strlen($url))==$url?'active':''; 
});

if (isset($_SESSION['flash'])) {
	$flash = $_SESSION['flash'];
	unset($_SESSION['flash']);
} else {
	$flash = array();
}