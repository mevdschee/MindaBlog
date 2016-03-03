<?php
$data = DB::select('select * from posts,users where posts.user_id = users.id and published is not null and published < NOW() order by published desc limit 5');
foreach (array_keys($data) as $i) {
	if ($pos = strpos($data[$i]['posts']['content'], '(...)')) {
		$data[$i]['posts']['html'] = substr($data[$i]['posts']['content'], 0, $pos).'...';
		$data[$i]['posts']['more_html'] = true;
	} else {
		$data[$i]['posts']['html'] = $data[$i]['posts']['content'];
    $data[$i]['posts']['more_html'] = false;
	}
	Buffer::set("content[$i]",trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['html'])));
}
$title = $_SESSION['settings']['title'];
