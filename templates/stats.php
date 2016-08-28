<?php
if (empty($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}

if (empty($_SESSION['referrer_id'])) {
    if (!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER']='';
    $_SESSION['referrer_id'] = DB::insert('insert ignore into `referrers` (`referrer`) VALUES (?) on duplicate key UPDATE `id`=`id`',$_SERVER['HTTP_REFERER']);
    if (!$_SESSION['referrer_id']) {
        $_SESSION['referrer_id'] = DB::selectValue('select `id` from `referrers` where `referrer`=?',$_SERVER['HTTP_REFERER']);
    }
    if (!$_SESSION['referrer_id']) {
        $_SESSION['referrer_id'] = 1;
    }
}

if (empty($_SESSION['user_agent_id'])) {
    if (!isset($_SERVER['HTTP_USER_AGENT'])) $_SERVER['HTTP_USER_AGENT']='';
    $_SESSION['user_agent_id'] = DB::insert('insert ignore into `user_agents` (`user_agent`) VALUES (?) on duplicate key UPDATE `id`=`id`',$_SERVER['HTTP_USER_AGENT']);
    if (!$_SESSION['user_agent_id']) {
        $_SESSION['user_agent_id'] = DB::selectValue('select `id` from `user_agents` where `user_agent`=?',$_SERVER['HTTP_USER_AGENT']);
    }
    if (!$_SESSION['user_agent_id']) {
        $_SESSION['user_agent_id'] = 1;
    }
}