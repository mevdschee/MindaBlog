<?php
$post = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$post) Router::redirect('error/not_found');
