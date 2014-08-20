<?php
$_SESSION['settings'] = Query::pairs('select `key`, `value` from settings');