<?php

if (!empty($_POST)) {
	$record = $_POST;
	if (!$record['posts']['slug']) $record['posts']['slug'] = $record['posts']['title'];
	$record['posts']['slug'] = preg_replace('/--+/','-',trim(preg_replace('/[^\-a-z0-9]/','-',strtolower($record['posts']['slug'])),'-'));	
	$rows = DB::update('UPDATE posts SET slug = ?, title = ?, content = ? WHERE id = ?', $record['posts']['slug'], $record['posts']['title'], $record['posts']['content'], $id);
	if ($rows) {
		$_SESSION['flash']['success'] = 'Post updated';
		Router::redirect('admin/posts/index');
	}
	else $flash['danger'] = 'Post not updated';
} else {
	$record = DB::selectOne('SELECT * from posts where id = ?', $id);
}