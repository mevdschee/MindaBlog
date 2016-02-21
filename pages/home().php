<?php
$data = DB::select('select * from posts where published is not null and published < NOW() order by published desc limit 5');
foreach (array_keys($data) as $i) {
	if (preg_match('/\(?\.\.\.+\)/', $data[$i]['posts']['content'], $matches, PREG_OFFSET_CAPTURE)) {
		$data[$i]['posts']['html'] = substr($data[$i]['posts']['content'], 0, $matches[0][1]).'...';
        $data[$i]['posts']['more_html'] = true;
	} else {
		$data[$i]['posts']['html'] = $data[$i]['posts']['content'];
        $data[$i]['posts']['more_html'] = false;
	}
	Buffer::set("content[$i]",trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['html'])));
}
$title = 'Home';
