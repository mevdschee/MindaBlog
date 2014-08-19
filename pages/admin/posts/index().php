<?php
$rows = Query::records('select posts.id,posts.title,posts.tags,posts.published,users.id,users.username from posts,users where user_id = users.id');