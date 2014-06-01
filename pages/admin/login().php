<?php
$error = '';
if (isset($_POST['username']))
{ if (Auth::login($_POST['username'],$_POST['password'])) {
	include 'settings/index().php';
	Router::redirect("admin");
  }
  else $error = "Username/password not valid";
}