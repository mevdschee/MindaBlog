<?php
$page = DB::q1('select * from pages where slug = ?',$slug);
if (!$page) Router::redirect('error/not_found');
