<?php
if (!empty($_POST)) {
	$slug = preg_replace('/--+/','-',trim(preg_replace('/[^\-a-z0-9]/','-',strtolower($_POST['title'])),'-'));
	$parts = preg_split('/\r?\n---+\r?\n/', $_POST['content'], 2);
	$html = Michelf\Markdown::defaultTransform($parts[0]);
	$moreHtml = '';
	if (isset($parts[1])) $moreHtml = Michelf\Markdown::defaultTransform($parts[1]);
	$rows = DB::update('UPDATE posts SET slug = ?, title = ?, content = ?, html = ?, more_html = ? WHERE id = ?', $slug, $_POST['title'], $_POST['content'], $html, $moreHtml, $id);
	if ($rows) $_SESSION['flash_messages'][] = 'success: Post updated';
	else $_SESSION['flash_messages'][] = 'danger: Post not updated';
	Router::redirect('admin/posts/index');
} else {
	$data = DB::selectOne('SELECT * from posts where id = ?', $id);
}