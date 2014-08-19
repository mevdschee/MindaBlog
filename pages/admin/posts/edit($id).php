<?php
if (isset($_POST['title'])) {
	Query::records('UPDATE posts SET title = ?, content = ? WHERE id = ?',$_POST['title'], $_POST['content'], $id);
	$_SESSION['flash_messages'][] = array('type' => 'success', 'message' => 'Post saved');
	Router::redirect('admin/posts/index');
} else {
	$data = Query::one('SELECT posts.tags, posts.title, posts.intro, posts.content from posts where id = ?', $id);
}