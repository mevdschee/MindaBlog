<?php
$data = DB::select('select posts.id,posts.slug,posts.title,posts.word_count,posts.tags,posts.published,users.id,users.name from posts,users where posts.user_id = users.id order by published is not null,published desc');
foreach (array_keys($data) as $i) {
	$data[$i]['posts']['published_label_type'] = '';
	$data[$i]['posts']['published_label_text'] = '';
	$data[$i]['unique_views']['visitors'] = DB::selectValue('select count(unique_views.ip) as `unique_views.visitors` from unique_views where unique_views.post_id = ? group by unique_views.post_id;',$data[$i]['posts']['id']);
	if ($data[$i]['posts']['published']) {
		list($data[$i]['posts']['published_day'],$data[$i]['posts']['published_month']) = explode('-',date('d-M',strtotime($data[$i]['posts']['published'])));
		if (strcmp($data[$i]['posts']['published'],date('Y-m-d'))>0) {
			$data[$i]['posts']['published_label_type'] = 'success';
			$data[$i]['posts']['published_label_text'] = 'Scheduled';
		}
	} else {
		list($data[$i]['posts']['published_day'],$data[$i]['posts']['published_month']) = array('-','');
		$data[$i]['posts']['published_label_type'] = 'warning';
		$data[$i]['posts']['published_label_text'] = 'Draft';
	}
}
