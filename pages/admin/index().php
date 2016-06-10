<?php
$stats = Cache::get("admin_stats");
if (!$stats) {
    $stats = array();
    $stats['visitors_per_day'] = DB::select('select `day`,count(id) as "unique_visitors.visitors",sum(requests) as "unique_visitors.views" from `unique_visitors` where `day` >= NOW() - INTERVAL 30 DAY group by `day` order by `day` desc');
    $stats['visitors_per_month'] = DB::select('select YEAR(`day`) as "unique_visitors.year",MONTH(`day`) as "unique_visitors.month",count(id) as "unique_visitors.visitors" from `unique_visitors` where `day` >= NOW() - INTERVAL 1 YEAR group by YEAR(`day`),MONTH(`day`) order by YEAR(`day`),MONTH(`day`) desc');
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
Buffer::set('monthly_visitors_graph',Graph::horizontalBar($values,300,'Unique visitors per month'));