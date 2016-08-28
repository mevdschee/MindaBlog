<?php
$data = DB::select('select slug, modified from posts where published is not null and published < NOW() order by published');
DB::insert('insert into `unique_views` (`type`,`post_id`,`ip`,`day`,`requests`) values (4,NULL,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;',$_SERVER['REMOTE_ADDR']);
