<?php
$user = $_SESSION['user'];
$users = DB::q('select * from users');
