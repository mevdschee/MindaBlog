<?php

$stats = Cache::get("admin_stats");
if (!$stats) {
    $stats = array();
    $stats['visitors'] = DB::select('select `day`,count(id) as "unique_visitors.visitors",sum(`requests`) as "unique_visitors.views" from `unique_visitors` where `day` >= NOW() - INTERVAL 30 DAY group by `day`');
    Cache::set("admin_stats",$stats,30);
}
