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
DB::insert('insert into `unique_other_views` (`type`,`ip`,`day`,`requests`) values (?,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;','archive',$_SERVER['REMOTE_ADDR']);
$title = $_SESSION['settings']['title'].' archive';