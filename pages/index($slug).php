<?php
$data = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$data) Router::redirect('error/not_found');
if (!DB::selectOne('select id from `unique_views` where `posts_id`=? and `ip`=? and `day`=DATE(NOW())',$data['posts']['id'],$_SERVER['REMOTE_ADDR'])) {
    DB::insert('insert into `unique_views` (`posts_id`,`ip`,`day`) values (?,?,NOW())',$data['posts']['id'],$_SERVER['REMOTE_ADDR']);
}
if (preg_match('/\(?\.\.\.+\)?/', $data['posts']['content'])) {
	$data['posts']['content'] = preg_replace('/\(?\.\.\.+\)?/', '', $data['posts']['content'], 1);
}
$title = $data['posts']['title'];
Buffer::set('content',Michelf\Markdown::defaultTransform($data['posts']['content']));