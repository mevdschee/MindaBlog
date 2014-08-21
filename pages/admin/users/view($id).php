<?php
$data = DB::selectOne('select * from users where id=?',$id);
$posts = DB::selectValue('select count(*) from posts where user_id=?',$id);