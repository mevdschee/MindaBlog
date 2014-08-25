<?php
if (!empty($_POST)) {
	if (!preg_match('/^[a-z0-9-]+$/', $_POST['posts']['slug'])) $errors['posts[slug]']='Only letters, numbers and the minus character are allowed';
	if (!$_POST['posts']['published']) $_POST['posts']['published'] = null;
	if (DB::selectValue('SELECT slug FROM posts where slug = ? and id != ?', $_POST['posts']['slug'], $id)) $errors['posts[slug]']='Already taken';
	if (!isset($errors)) {
		$rowsAffected = DB::update('UPDATE posts SET published = ?, slug = ?, title = ?, content = ?, word_count = ? WHERE id = ?', $_POST['posts']['published'], $_POST['posts']['slug'], $_POST['posts']['title'], $_POST['posts']['content'], str_word_count($_POST['posts']['content']), $id);
		if ($rowsAffected!==false) {
			Router::redirect('admin/posts/index');
		}
	}
	$flash['danger'] = 'Post not saved'; 
} else {
	$_POST = DB::selectOne('SELECT * from posts where id = ?', $id);
}