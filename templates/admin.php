<?php 
if (!isset($_SESSION['user'])) Router::redirect('admin/login'); 
$username = $_SESSION['user']['username'];
$menu = array(
	'admin/index'=>array('title'=>'Dashboard'),
	'admin/posts'=>array('title'=>'Posts'),
	'admin/users'=>array('title'=>'Users'),
	'admin/settings'=>array('title'=>'Settings'),
);
array_walk($menu, function(&$item,$url) { 
	$item['active'] = substr(Router::getUrl(),0,strlen($url))==$url?'active':''; 
});
?>
<!DOCTYPE html>
<html>
  <head>
    <base href="<?php echo Router::getBaseUrl(); ?>">
    <title>MindaBlog Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <script src="js/bootstrap.min.js"></script>
        
    <!-- Markdown -->
    <script src="js/markdown.js"></script>
        
    <!-- Bootstrap Markdown -->
    <link href="css/bootstrap-markdown.min.css" rel="stylesheet" media="screen">
    <script src="js/bootstrap-markdown.js"></script>
    
  </head>
  <body>
  <nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=""><?php e($_SESSION['settings']['title']); ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<?php foreach ($menu as $url => $item): ?>
          <li class="<?php echo $item['active']; ?>">
		    <a href="<?php echo $url; ?>"><?php echo $item['title']; ?></a>
		  </li>
		<?php endforeach; ?>  
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username; ?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="admin/users/profile">Profile</a></li>
            <li class="divider"></li>
            <li><a href="admin/logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  </nav>

  <div class="container">

    <div class="row">
      <div class="col-md-12">
         <?php echo Router::getContent(); ?>
      </div>
    </div>

  </div>
</body>
</html>
