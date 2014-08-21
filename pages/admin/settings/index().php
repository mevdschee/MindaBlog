<?php
$_SESSION['settings'] = DB::selectPairs('select `key`, `value` from settings');