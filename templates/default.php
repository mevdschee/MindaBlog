<?php

if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}

DB::insert('insert into `unique_visitors` (`ip`,`day`,`requests`,`last_seen`) values (?,DATE(NOW()),1,NOW()) ON DUPLICATE KEY UPDATE `requests`=`requests`+1, `last_seen`=NOW();',$_SERVER['REMOTE_ADDR']);

$stats = Cache::get("stats");
if (!$stats) {
    $stats = array();
    $stats['popular_posts'] = DB::selectPairs('select `slug`,`title`,count(`post_id`) as `views` from `posts`,`unique_views` where `posts`.`id`=`unique_views`.`post_id` and `posts`.`published` is not null and `posts`.`published` < NOW() and `unique_views`.`day` > DATE_SUB(NOW(), INTERVAL 30 day) group by `post_id` order by `views` desc limit 10');
    $stats['latest_posts'] = DB::selectPairs('select `slug`,`title` from `posts` where `posts`.`published` is not null and `posts`.`published` < NOW() order by `published` desc limit 10');
    $stats['visitors_5_min'] = DB::selectValue('select count(id) from `unique_visitors` where `last_seen` > NOW() - INTERVAL 5 MINUTE');
    $stats['visitors_today'] = DB::selectValue('select count(id) from `unique_visitors` where `day` = ?',date('Y-m-d'));
    $stats['visitors_month'] = DB::selectValue('select count(id) from `unique_visitors` where `day` >= ?',date('Y-m-01'));
    Cache::set("stats",$stats,30);
}

Buffer::set('title_html',$_SESSION['settings']['title_html']);
Buffer::set('subtitle_html',$_SESSION['settings']['subtitle_html']);
