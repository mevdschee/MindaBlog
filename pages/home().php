<?php
$records = DB::select('select * from posts');
foreach ($records as &$record) {
	if (preg_match('/\r?\n---+\r?\n/', $record['posts']['content'])) {
		list($record['posts']['html'],$record['posts']['more_html']) = preg_split('/\r?\n---+\r?\n/', $record['posts']['content'], 2);
	} else {
		list($record['posts']['html'],$record['posts']['more_html']) = array($record['posts']['content'], '');
	}
	$record['posts']['html'] = Michelf\Markdown::defaultTransform($record['posts']['html']);
	$record['posts']['more_html'] = Michelf\Markdown::defaultTransform($record['posts']['more_html']);
}