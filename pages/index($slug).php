<?php
$post = DB::q1('select * from posts where slug = ?',$slug);
if (!$post) Router::redirect('error/not_found');
