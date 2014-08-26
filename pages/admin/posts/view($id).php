<?php
$data = DB::selectOne('SELECT * from posts,users where user_id = users.id and posts.id = ?', $id);