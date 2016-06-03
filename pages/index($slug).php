<?php
$data = DB::selectOne('select * from posts,users where posts.user_id = users.id and slug = ? and published is not null and published < NOW();',$slug);
if (!$data) Router::redirect('error/not_found');
DB::insert('insert into `unique_views` (`post_id`,`ip`,`day`,`requests`) values (?,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;',$data['posts']['id'],$_SERVER['REMOTE_ADDR']);
if ($pos=strpos($data['posts']['content'],'(...)')) {
	$data['posts']['content'] = substr_replace($data['posts']['content'], '', $pos, 5);
	$data['posts']['description'] = substr($data['posts']['content'],0,$pos).'...';
} else if ($pos = strpos($data['posts']['content'],array('.',' ',','),200)) {
	$data['posts']['description'] = substr($data['posts']['content'],0,$pos).'...';
} else {
	$data['posts']['description'] = $data['posts']['content'];
}
$title = $data['posts']['title'];
Buffer::set('content',Michelf\Markdown::defaultTransform($data['posts']['content']));
