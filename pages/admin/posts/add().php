<?php
if (!empty($_POST)) {
	$_POST['posts']['slug'] = date('Y-m-').preg_replace('/--+/','-',trim(preg_replace('/[^\-a-z0-9]/','-',strtolower($_POST['posts']['title'])),'-'));
	$id = DB::insert('INSERT INTO posts (slug,title,content,user_id) VALUES (?, ?, ?, ?)',$_POST['posts']['slug'],$_POST['posts']['title'], $_POST['posts']['content'], $_SESSION['user']['id']);
	if ($id) {
		$_SESSION['flash']['success'] = 'Post saved';
		Router::redirect('admin/posts/index');
	}
	$flash['danger'] = 'Post not saved';	
} else {
	$_POST['posts'] = array('title'=>'','content'=>'');
}