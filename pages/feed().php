<?php
if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}
$data = DB::select('select * from posts,users where posts.user_id = users.id and published is not null and published < NOW() order by published desc limit 10');
DB::insert('insert into `unique_other_views` (`type`,`ip`,`day`,`requests`) values (?,?,DATE(NOW()),1) ON DUPLICATE KEY UPDATE `requests`=`requests`+1;','feed',$_SERVER['REMOTE_ADDR']);
foreach (array_keys($data) as $i) {
  if ($pos=strpos($data[$i]['posts']['content'],'(...)')) {
    $data[$i]['posts']['intro'] = substr($data[$i]['posts']['content'], 0, $pos).'...';
  	$data[$i]['posts']['content'] = substr_replace($data[$i]['posts']['content'], '', $pos, 5);
  }
  Buffer::set("intro[$i]",trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['intro'])));
	Buffer::set("content[$i]",trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['content'])));
}
