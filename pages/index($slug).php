<?php
$record = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$record) Router::redirect('error/not_found');

if (preg_match('/\r?\n---+\r?\n/', $record['posts']['content'])) {
	list($record['posts']['html'],$record['posts']['more_html']) = preg_split('/\r?\n---+\r?\n/', $record['posts']['content'], 2);
} else {
	list($record['posts']['html'],$record['posts']['more_html']) = array($record['posts']['content'], '');
}
$record['posts']['html'] = Michelf\Markdown::defaultTransform($record['posts']['html']);
$record['posts']['more_html'] = Michelf\Markdown::defaultTransform($record['posts']['more_html']);