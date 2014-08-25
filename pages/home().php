<?php
$data = DB::select('select * from posts where published is not null and published < NOW() order by published desc');
foreach (array_keys($data) as $i) {
	if (preg_match('/\r?\n---+\r?\n/', $data[$i]['posts']['content'])) {
		list($data[$i]['posts']['html'],$data[$i]['posts']['more_html']) = preg_split('/\r?\n---+\r?\n/', $data[$i]['posts']['content'], 2);
	} else {
		list($data[$i]['posts']['html'],$data[$i]['posts']['more_html']) = array($data[$i]['posts']['content'], '');
	}
	$data[$i]['posts']['html'] = trim(Michelf\Markdown::defaultTransform($data[$i]['posts']['html']));
	$data[$i]['posts']['more_html'] = $data[$i]['posts']['more_html']?true:false;
}