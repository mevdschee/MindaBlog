<?php
$rows = DB::q('select * from posts,users where user_id = users.id');