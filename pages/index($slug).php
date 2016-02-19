<?php
$data = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$data) Router::redirect('error/not_found');

if (preg_match('/\r?\n---+\r?\n/', $data['posts']['content'])) {
	list($before,$after) = preg_split('/\r?\n---+\r?\n/', $data['posts']['content'], 2);
} else {
	list($before,$after) = array($data['posts']['content'], '');
}
$title = $data['posts']['title'];
Buffer::set('content',Michelf\Markdown::defaultTransform($before));
Buffer::set('more_content',Michelf\Markdown::defaultTransform($after));