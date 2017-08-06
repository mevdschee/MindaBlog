<?php
if (empty($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}

if (!isset($_SESSION['user'])) {

    if (empty($_SESSION['referrer_id'])) {
        if (!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER']='';
        $_SESSION['referrer_id'] = DB::insert('insert into `referrers` (`referrer`) VALUES (?) on duplicate key UPDATE `referrer`=`referrer`',$_SERVER['HTTP_REFERER']);
        if (!$_SESSION['referrer_id']) {
            $_SESSION['referrer_id'] = DB::selectValue('select `id` from `referrers` where `referrer`=?',$_SERVER['HTTP_REFERER']);
        }
        if (!$_SESSION['referrer_id']) {
            $_SESSION['referrer_id'] = 1;
        }
    }

    if (empty($_SESSION['user_agent_id'])) {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) $_SERVER['HTTP_USER_AGENT']='';
        $_SESSION['user_agent_id'] = DB::insert('insert into `user_agents` (`user_agent`) VALUES (?) on duplicate key UPDATE `user_agent`=`user_agent`',$_SERVER['HTTP_USER_AGENT']);
        if (!$_SESSION['user_agent_id']) {
            $_SESSION['user_agent_id'] = DB::selectValue('select `id` from `user_agents` where `user_agent`=?',$_SERVER['HTTP_USER_AGENT']);
        }
        if (!$_SESSION['user_agent_id']) {
            $_SESSION['user_agent_id'] = 1;
        }
    }

    DB::insert('insert into `unique_visitors` (`ip`,`day`,`referrer_id`,`user_agent_id`,`requests`,`last_seen`) values (?,DATE(NOW()),?,?,1,NOW()) ON DUPLICATE KEY UPDATE `requests`=`requests`+1, `last_seen`=NOW();',$_SERVER['REMOTE_ADDR'],$_SESSION['referrer_id'],$_SESSION['user_agent_id']);

}