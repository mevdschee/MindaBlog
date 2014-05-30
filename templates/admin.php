<?php if (!isset($_SESSION['user'])) Router::redirect('admin/login'); ?>
<!DOCTYPE html>
<html>
  <head>
    <base href="<?php echo Router::getBaseUrl(); ?>">
    <title>MindaBlog</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico">
    <link href="css/default.css" rel="stylesheet">
  </head>
  <body>
    <div class="menu">
    <p>
      <a href="admin">Dashboard</a><br/>
      <a href="admin/users">Users</a><br/>
      <a href="admin/posts">Posts</a><br/>
      <br/>
      <a href="admin/logout">Logout</a><br/>
    </p>
  </div>
  <div class="body">
    <?php echo Router::getContent(); ?>
  </div>
</body>
</html>
