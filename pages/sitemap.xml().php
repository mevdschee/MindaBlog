<?php
$data = DB::select('select slug, modified from posts where published is not null and published < NOW() order by published');
DB::insert('insert into `unique_other_views` (`type`,`ip`,`day`,`referrer_id`,`user_agent_id`,`requests`) values (?,?,DATE(NOW()),?,?,1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;','sitemap',$_SERVER['REMOTE_ADDR'],$_SESSION['referrer_id'],$_SESSION['user_agent_id']);
Debugger::$enabled=false;