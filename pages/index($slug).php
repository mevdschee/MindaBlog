<?php
$data = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$data) Router::redirect('error/not_found');
DB::insert('insert into `unique_views` (`post_id`,`ip`,`day`,`requests`) values (?,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;',$data['posts']['id'],$_SERVER['REMOTE_ADDR']);
if (preg_match('/\(?\.\.\.+\)?/', $data['posts']['content'])) {
	$data['posts']['content'] = preg_replace('/\(?\.\.\.+\)?/', '', $data['posts']['content'], 1);
}
$title = $data['posts']['title'];
Buffer::set('content',Michelf\Markdown::defaultTransform($data['posts']['content']));
