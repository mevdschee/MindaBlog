<?php
if (!empty($_POST)) {
	$slug = preg_replace('/--+/','-',trim(preg_replace('/[^\-a-z0-9]/','-',strtolower($_POST['title'])),'-'));
	$rows = DB::update('UPDATE posts SET slug = ?, title = ?, content = ? WHERE id = ?', $slug, $_POST['title'], $_POST['content'], $id);
	if ($rows) $_SESSION['flash_messages'][] = 'success: Post updated';
	else $_SESSION['flash_messages'][] = 'danger: Post not updated';
	Router::redirect('admin/posts/index');
} else {
	$data = DB::selectOne('SELECT posts.tags, posts.title, posts.intro, posts.content from posts where id = ?', $id);
}