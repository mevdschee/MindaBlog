<?php
$data = DB::selectOne('select * from users where id=?',$id);
$postCount= DB::selectValue('select count(*) from posts where user_id=?',$id);