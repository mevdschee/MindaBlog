<?php
$error = '';
if (isset($_POST['username']))
{ if (Auth::login($_POST['username'],$_POST['password'])) {
	$rows = DB::q('select * from settings');
	$settings = array();
	array_walk($rows, function($v,$k) use (&$settings) { 
		$settings[$v['settings']['key']] = $v['settings']['value']; 
	});
	$_SESSION['settings'] = $settings;
    Router::redirect("admin");
  }
  else $error = "Username/password not valid";
}