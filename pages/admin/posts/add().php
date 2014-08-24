<?php
if (!empty($_POST)) {
	$id = DB::insert('INSERT INTO posts (title,content,user_id) VALUES (?, ?, ?)',$_POST['title'], $_POST['content'], $_SESSION['user']['id']);
	if ($id) $_SESSION['flash']['success'] = 'Post saved';
	else $_SESSION['flash']['danger'] = 'Post not saved';
	Router::redirect('admin/posts/index');
}