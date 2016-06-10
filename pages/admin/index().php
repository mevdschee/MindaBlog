<?php
$stats = Cache::get("admin_stats");
if (!$stats) {
    $stats = array();
    $stats['visitors'] = DB::select('select `day`,count(id) as "unique_visitors.visitors",sum(`requests`) as "unique_visitors.views" from `unique_visitors` where `day` >= NOW() - INTERVAL 90 DAY group by `day` order by `day` desc');
    $stats['posts'] = DB::selectPairs('select DATE(`published`) as "posts.published_date",`slug` from `posts` where `published` >= NOW() - INTERVAL 90 DAY');
    Cache::set("admin_stats",$stats,30);
}
$values = array_combine(
    array_map(function($v){return $v['unique_visitors']['day'];},$stats['visitors']),
    array_map(function($v){return $v['unique_visitors']['visitors'];},$stats['visitors'])
);
Buffer::set('vertical_bar_graph',Graph::verticalBar($values,300,'Unique visitors per day'));