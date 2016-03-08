<?php
if (!empty($_POST)) {
	if (!isset($_POST['posts']['slug'])) $_POST['posts']['slug'] = date('Y-').preg_replace('/--+/','-',trim(preg_replace('/[^\-a-z0-9]/','-',strtolower($_POST['posts']['title'])),'-'));
	if (!preg_match('/^[a-z0-9-]+$/', $_POST['posts']['slug'])) $errors['posts[slug]']='Only letters, numbers and the minus character are allowed';
	if (DB::selectValue('SELECT slug FROM posts where slug = ?', $_POST['posts']['slug'])) $errors['posts[slug]']='Already taken';
	if (!isset($errors)) {
		$id = DB::insert('INSERT INTO posts (slug,title,content,word_count,modified,user_id) VALUES (?, ?, ?, ?, NOW(), ?)', $_POST['posts']['slug'], $_POST['posts']['title'], $_POST['posts']['content'], str_word_count($_POST['posts']['content']), $_SESSION['user']['id']);
		if ($id) {
			Router::redirect('admin/posts/index');
		}
	}
	$flash['danger'] = 'Post not saved';
} else {
	$_POST['posts'] = array('title'=>'','content'=>'');
}
