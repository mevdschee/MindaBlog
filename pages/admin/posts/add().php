<?php
if (!empty($_POST)) {
	if (!isset($_POST['posts']['slug'])) $_POST['posts']['slug'] = date('Y-m-').preg_replace('/--+/','-',trim(preg_replace('/[^\-a-z0-9]/','-',strtolower($_POST['posts']['title'])),'-'));
	if (!preg_match('/^[a-z0-9-]+$/', $_POST['posts']['slug'])) $errors['posts[slug]']='Only letters, numbers and the minus character are allowed';
	if (DB::selectValue('SELECT slug FROM posts where slug = ?', $_POST['posts']['slug'])) $errors['posts[slug]']='Already taken';
	if (!isset($errors)) {
		$id = DB::insert('INSERT INTO posts (slug,title,content,user_id) VALUES (?, ?, ?, ?)', $_POST['posts']['slug'], $_POST['posts']['title'], $_POST['posts']['content'], $_SESSION['user']['id']);
		if ($id) {
			Router::redirect('admin/posts/index');
		}
	}
	$flash['danger'] = 'Post not saved';	
} else {
	$_POST['posts'] = array('title'=>'','content'=>'');
}