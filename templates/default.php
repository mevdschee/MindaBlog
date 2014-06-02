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
    <div class="title">
      <div class="logo">
        <img src="img/mindaphp_logo.png" alt="logo"> MindaBlog - fast blog for the masses
      </div>
    </div>
    <div class="menu">
    <p>
      <a href="admin">Admin area</a><br/>
    </p>
  </div>
  <div class="body">
    <?php echo Buffer::get('html'); ?>
  </div>
</body>
</html>
