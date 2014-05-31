<?php
$data = DB::q1('select * from users where id=?',$id);
$posts = DB::qv('select count(*) from posts where user_id=?',$id);