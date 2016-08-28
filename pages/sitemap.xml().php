<?php
$data = DB::select('select slug, modified from posts where published is not null and published < NOW() order by published');
DB::insert('insert into `unique_other_views` (`type`,`ip`,`day`,`requests`) values (4,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;',$_SERVER['REMOTE_ADDR']);
