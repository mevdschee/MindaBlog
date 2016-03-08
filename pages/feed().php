<?php
if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = DB::selectPairs('select `key`,`value` from settings');
}
$data = DB::select('select * from posts,users where posts.user_id = users.id and published is not null and published < NOW() order by published desc limit 10',$limit);
foreach (array_keys($data) as $i) {
  if ($pos=strpos($data[$i]['posts']['content'],'(...)')) {
  	$data[$i]['posts']['content'] = substr_replace($data[$i]['posts']['content'], '', $pos, 5);
  }
	Buffer::set("content[$i]",trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['content'])));
}
