<?php
$data = DB::select('select * from posts,users where posts.user_id = users.id and published is not null and published < NOW() order by published desc limit 10');
DB::insert('insert into `unique_views` (`type`,`post_id`,`ip`,`day`,`requests`) values (1,NULL,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;',$_SERVER['REMOTE_ADDR']);
foreach (array_keys($data) as $i) {
	if ($pos = strpos($data[$i]['posts']['content'], '(...)')) {
		$data[$i]['posts']['html'] = substr($data[$i]['posts']['content'], 0, $pos).'...';
		$data[$i]['posts']['more_html'] = true;
	} else if ($pos = strpos($data[$i]['posts']['content'],' ',200)) {
		$data[$i]['posts']['html'] = substr($data[$i]['posts']['content'], 0, $pos).'...';
		$data[$i]['posts']['more_html'] = true;
	} else {
		$data[$i]['posts']['html'] = $data[$i]['posts']['content'];
		$data[$i]['posts']['more_html'] = false;
	}
	Buffer::set("content[$i]",trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['html'])));
}
$title = $_SESSION['settings']['title'].' - '.$_SESSION['settings']['subtitle'];
