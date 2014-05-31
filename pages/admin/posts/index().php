<?php
$rows = DB::q('select posts.title,posts.tags,posts.published,users.id,users.username from posts,users where user_id = users.id');