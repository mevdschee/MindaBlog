<?php
if (!empty($_POST)) {
	$rows = DB::delete('DELETE FROM posts WHERE id = ?', $id);
	if ($rows) $_SESSION['flash_messages'][] = 'success: Post deleted';
	else $_SESSION['flash_messages'][] = 'danger: Post not deleted';
	Router::redirect('admin/posts/index');
}