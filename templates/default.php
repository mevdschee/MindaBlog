<?php

if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}

if (!DB::selectOne('select id from `unique_visitors` where `ip`=? and `day`=DATE(NOW())',$_SERVER['REMOTE_ADDR'])) {
    DB::insert('insert into `unique_visitors` (`ip`,`day`) values (?,NOW())',$_SERVER['REMOTE_ADDR']);
}

if (!Debugger::$enabled) $stats = Cache::get("stats");
if (!$stats) { 
    $stats = array();
    $stats['popular_posts'] = DB::selectPairs('select `slug`,`title`,count(`posts_id`) as `views` from `posts`,`unique_views` where `posts`.`id`=`unique_views`.`posts_id` group by `posts_id` order by `views` desc limit 10');
    $stats['latest_posts'] = DB::selectPairs('select `slug`,`title` from `posts` order by `published` desc limit 10');
    $stats['visitors_day'] = DB::selectValue('select count(id) from `unique_visitors` where `ip`=? and `day` = ?',$_SERVER['REMOTE_ADDR'],date('Y-m-d'));
    $stats['visitors_month'] = DB::selectValue('select count(id) from `unique_visitors` where `ip`=? and `day` >= ?',$_SERVER['REMOTE_ADDR'],date('Y-m-01'));
    Cache::set("stats",$stats,300);
}