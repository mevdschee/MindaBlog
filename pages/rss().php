<?php
if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}
$limit = 10;
require 'pages/home().php';
