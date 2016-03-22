<?php
if (isset($_POST['email'])) {
  $email = $_POST['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    DB::insert('insert ignore into `subscribers` (`email`,`key`) values (?,?);',$email,sha1(time().$email));
  }
}
$title = 'Subscribe';
