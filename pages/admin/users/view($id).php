<?php
$data = Query::one('select * from users where id=?',$id);
$posts = Query::value('select count(*) from posts where user_id=?',$id);