<?php
if (!empty($_POST)) {
	$rows = Query::update('UPDATE posts SET title = ?, content = ? WHERE id = ?',$_POST['title'], $_POST['content'], $id);
	if ($rows) $_SESSION['flash_messages'][] = 'success: Post updated';
	else $_SESSION['flash_messages'][] = 'danger: Post not updated';
	Router::redirect('admin/posts/index');
} else {
	$data = Query::one('SELECT posts.tags, posts.title, posts.intro, posts.content from posts where id = ?', $id);
}