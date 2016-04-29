<?php
$data = DB::select('
    select 
        title,
        slug,
        published,
        name
    from 
        posts, 
        users 
    where 
        posts.user_id = users.id and 
        published is not null and 
        published < NOW() 
    order by 
        published DESC
');