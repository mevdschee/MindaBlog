<?php

function vertical_bar_graph($values,$height,$title='',$description='') {
    $real_max = max($values);
    $max = pow(10,ceil(log10($real_max)));
    while ($max/2>$real_max) $max/=2;
    $html = '<div>';
    $html.= '<div style="position: relative; clear: both; text-align: center;">';
    $html.= $title.'</div>';
    for ($i=0;$i<10;$i++) {
        if ($i%2==0) {
            $html.= '<div style="position: relative; top: '.($i/10*$height).'px; width: 100%;">';
            $html.= '<div style="position: absolute; width: 100%; text-align: left; border-top: 1px solid #aaa;">';
            $html.= '&nbsp;'.((1-$i/10)*$max);
            $html.= '</div>';
            $html.= '<div style="position: absolute; width: 100%; text-align: right; border-top: 1px solid #aaa;">';
            $html.= ((1-$i/10)*$max).'&nbsp;';
            $html.= '</div>';
            $html.= '</div>';
        } else {
            $html.= '<div style="position: relative; top: '.($i/10*$height).'px; width: 100%;">';
            $html.= '<div style="position: absolute; width: 100%; text-align: left; border-top: 1px solid #ccc;">';
            $html.= '</div>';
            $html.= '</div>';
        }
    }
    $c = count($values);
    foreach ($values as $key=>$value) {
            $p = round(100*($value/$max));
            $title = is_string($key)?$key.': '.$value:$value;
            $html.= '<div style="float: right; width: '.(100/$c).'%; height: '.$height.'px;">';
            $html.= '<div style="width: 100%; height: 100%; background-color: #eee;">';
            $html.= '<a style="display: block; position: relative; margin: 0 10%; background-color: #aaa; height: '.$p.'%; top: '.(100-$p).'%" title="'.$title.'">';
            $html.= '</a>';
            $html.= '</div>';
            $html.= '</div>';
    }
    $html.= '<div style="position: relative; clear:both; border-top: 1px solid #aaa;">';
    $html.= $description.'</div>';
    $html.= '</div>';
    return $html;
}

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
Buffer::set('vertical_bar_graph',vertical_bar_graph($values,300,'Unique visitors per day'));