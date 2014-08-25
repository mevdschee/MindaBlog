<?php
if (!empty($_POST)) {
	$rows = DB::delete('DELETE FROM posts WHERE id = ?', $id);
	if (!$rows) $_SESSION['flash']['danger'] = 'Post not deleted';
	Router::redirect('admin/posts/index');
}