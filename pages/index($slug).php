<?php
$data = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$data) Router::redirect('error/not_found');
DB::delete('delete from `daily_views` where `created` < DATE_SUB(NOW(), INTERVAL 7 DAY)');
DB::insert('insert into `daily_views` (`posts_id`,`created`) values (?,NOW())',$data['posts']['id']);

if (preg_match('/\r?\n---+\r?\n/', $data['posts']['content'])) {
	list($before,$after) = preg_split('/\r?\n---+\r?\n/', $data['posts']['content'], 2);
} else {
	list($before,$after) = array($data['posts']['content'], '');
}
$title = $data['posts']['title'];
Buffer::set('content',Michelf\Markdown::defaultTransform($before));
Buffer::set('more_content',Michelf\Markdown::defaultTransform($after));