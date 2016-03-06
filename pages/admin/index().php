<?php

$stats = Cache::get("admin_stats");
if (!$stats) {
    $stats = array();
    $stats['popular_posts'] = DB::selectPairs('select `slug`,`title`,count(`post_id`) as `views` from `posts`,`unique_views` where `posts`.`id`=`unique_views`.`post_id` and `posts`.`published` is not null and `posts`.`published` < NOW() group by `post_id` order by `views` desc limit 10');
    $stats['latest_posts'] = DB::selectPairs('select `slug`,`title` from `posts` where `posts`.`published` is not null and `posts`.`published` < NOW() order by `published` desc limit 10');
    $stats['visitors_day'] = DB::selectValue('select count(id) from `unique_visitors` where `day` = ?',date('Y-m-d'));
    $stats['visitors_month'] = DB::selectValue('select count(id) from `unique_visitors` where `day` >= ?',date('Y-m-01'));
    Cache::set("admin_stats",$stats,30);
}
