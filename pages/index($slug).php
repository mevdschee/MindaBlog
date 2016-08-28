<?php
$data = DB::selectOne('select * from posts,users where posts.user_id = users.id and slug = ? and published is not null and published < NOW();',$slug);
if (!$data) Router::redirect('');
DB::insert('insert ignore into `unique_views` (`post_id`,`ip`,`day`,`referrer_id`,`user_agent_id`,`requests`) values (?,?,DATE(NOW()),?,?,1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;',$data['posts']['id'],$_SERVER['REMOTE_ADDR'],$_SESSION['referrer_id'],$_SESSION['user_agent_id']);
if ($pos=strpos($data['posts']['content'],'(...)')) {
	$data['posts']['content'] = substr_replace($data['posts']['content'], '', $pos, 5);
	$data['posts']['description'] = substr($data['posts']['content'],0,$pos).'...';
} else if ($pos = strpos($data['posts']['content'],' ',200)) {
	$data['posts']['description'] = substr($data['posts']['content'],0,$pos).'...';
} else {
	$data['posts']['description'] = $data['posts']['content'];
}
$data['posts']['description'] = trim(strip_tags(Michelf\Markdown::defaultTransform($data['posts']['description'])));
$title = $data['posts']['title'];
Buffer::set('content',Michelf\Markdown::defaultTransform($data['posts']['content']));
