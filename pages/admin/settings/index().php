<?php
$_SESSION['settings'] = DB::pairs('select `key`, `value` from settings');