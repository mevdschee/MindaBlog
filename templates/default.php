<?php

if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}

//$popular = Cache::get("popular");
//if (!$popular) {
    $popular = DB::selectPairs('select `slug`,`title`,count(`posts_id`) as `views` from `posts`,`daily_views` where `posts`.`id`=`daily_views`.`posts_id` group by `posts_id` order by `views` desc');
//    Cache::set("popular",$popular,300);
//}

//$latest = Cache::get("latest");
//if (!$latest) {
    $latest = DB::selectPairs('select `slug`,`title` from `posts` order by `published` DESC LIMIT 10');
//    Cache::set("latest",$latest,300);
//}