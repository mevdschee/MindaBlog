<?php
$stats = Cache::get("admin_stats");
if (!$stats) {
    $stats = array();
    $stats['popular_posts_month'] = DB::selectPairs('select `slug`,count(`post_id`) as `posts.views` from `posts`,`unique_views` where `posts`.`id`=`unique_views`.`post_id` and `posts`.`published` is not null and `posts`.`published` < NOW() and `unique_views`.`day` > DATE_SUB(NOW(), INTERVAL 30 day) group by `post_id` order by `posts.views` desc limit 10');
    $stats['popular_posts_day'] = DB::selectPairs('select `slug`,count(`post_id`) as `posts.views` from `posts`,`unique_views` where `posts`.`id`=`unique_views`.`post_id` and `posts`.`published` is not null and `posts`.`published` < NOW() and `unique_views`.`day` > DATE_SUB(NOW(), INTERVAL 24 hour) group by `post_id` order by `posts.views` desc limit 10');
    $stats['visitors_per_day'] = DB::select('select `day`,count(id) as "unique_visitors.visitors",sum(requests) as "unique_visitors.views" from `unique_visitors` where `day` >= NOW() - INTERVAL 30 DAY group by `day` order by `day` desc');
    $stats['visitors_per_month'] = DB::select('select YEAR(`day`) as "unique_visitors.year",MONTH(`day`) as "unique_visitors.month",count(id) as "unique_visitors.visitors" from `unique_visitors` where `day` >= NOW() - INTERVAL 1 YEAR group by YEAR(`day`),MONTH(`day`) order by YEAR(`day`),MONTH(`day`) desc');
    $stats['subscribers_per_day'] = DB::select('select `day`,count(id) as "unique_other_views.visitors" from `unique_other_views` where `type` = \'feed\' and `day` >= NOW() - INTERVAL 30 DAY group by `day` order by `day` desc');
    $stats['subscribers_per_month'] = DB::select('select YEAR(`day`) as "unique_other_views.year",MONTH(`day`) as "unique_other_views.month",count(id) as "unique_other_views.visitors" from `unique_other_views` where `type` = \'feed\' and `day` >= NOW() - INTERVAL 1 YEAR group by YEAR(`day`),MONTH(`day`) order by YEAR(`day`),MONTH(`day`) desc');
    $stats['homepage_visitors_per_day'] = DB::select('select `day`,count(id) as "unique_other_views.visitors" from `unique_other_views` where `type` = \'home\' and `day` >= NOW() - INTERVAL 30 DAY group by `day` order by `day` desc');
    $stats['homepage_visitors_per_month'] = DB::select('select YEAR(`day`) as "unique_other_views.year",MONTH(`day`) as "unique_other_views.month",count(id) as "unique_other_views.visitors" from `unique_other_views` where `type` = \'home\' and `day` >= NOW() - INTERVAL 1 YEAR group by YEAR(`day`),MONTH(`day`) order by YEAR(`day`),MONTH(`day`) desc');
    $stats['posts'] = DB::selectPairs('select DATE(`published`) as "posts.published_date",`slug` from `posts` where `published` >= NOW() - INTERVAL 30 DAY');
    Cache::set("admin_stats",$stats,30);
}
$values = array_combine(
    array_map(function($v){return $v['unique_visitors']['day'];},$stats['visitors_per_day']),
    array_map(function($v){return $v['unique_visitors']['visitors'];},$stats['visitors_per_day'])
);
while (count($values)<30) array_push($values,0);
Buffer::set('daily_visitors_graph',Graph::verticalBar($values,300,'Unique visitors per day'));
$values = array_combine(
    array_map(function($v){return sprintf('%04d-%02d',$v['unique_visitors']['year'],$v['unique_visitors']['month']);},$stats['visitors_per_month']),
    array_map(function($v){return $v['unique_visitors']['visitors'];},$stats['visitors_per_month'])
);
while (count($values)<12) array_push($values,'');
Buffer::set('monthly_visitors_graph',Graph::verticalBar($values,300,'Unique visitors per month'));
Buffer::set('popular_posts_month_graph',Graph::horizontalBar($stats['popular_posts_month'],300,'Popular posts this month'));
Buffer::set('popular_posts_day_graph',Graph::horizontalBar($stats['popular_posts_day'],300,'Popular posts this day'));
$values = array_combine(
    array_map(function($v){return $v['unique_other_views']['day'];},$stats['subscribers_per_day']),
    array_map(function($v){return $v['unique_other_views']['visitors'];},$stats['subscribers_per_day'])
);
while (count($values)<30) array_push($values,0);
Buffer::set('daily_subscribers_graph',Graph::verticalBar($values,300,'Unique subscribers per day'));
$values = array_combine(
    array_map(function($v){return sprintf('%04d-%02d',$v['unique_other_views']['year'],$v['unique_other_views']['month']);},$stats['subscribers_per_month']),
    array_map(function($v){return $v['unique_other_views']['visitors'];},$stats['subscribers_per_month'])
);
while (count($values)<12) array_push($values,'');
Buffer::set('monthly_subscribers_graph',Graph::verticalBar($values,300,'Unique subscribers per month'));
$values = array_combine(
    array_map(function($v){return $v['unique_other_views']['day'];},$stats['homepage_visitors_per_day']),
    array_map(function($v){return $v['unique_other_views']['visitors'];},$stats['homepage_visitors_per_day'])
);
while (count($values)<30) array_push($values,0);
Buffer::set('daily_homepage_visitors_graph',Graph::verticalBar($values,300,'Unique homepage visits per day'));
$values = array_combine(
    array_map(function($v){return sprintf('%04d-%02d',$v['unique_other_views']['year'],$v['unique_other_views']['month']);},$stats['homepage_visitors_per_month']),
    array_map(function($v){return $v['unique_other_views']['visitors'];},$stats['homepage_visitors_per_month'])
);
while (count($values)<12) array_push($values,'');
Buffer::set('monthly_homepage_visitors_graph',Graph::verticalBar($values,300,'Unique homepage visits per month'));
