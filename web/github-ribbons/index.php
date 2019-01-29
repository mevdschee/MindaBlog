<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>GitHub Ribbons - TQdev.com</title>
  <meta name="description" content="Fork me on GitHub ribbons in SVG format for retina displays - TQdev.com">
<style>
body {font-family: sans-serif; }
h1 { font-size: 40px;}
.single-column { max-width: 50em; margin: 0 auto;}
</style>

  </head>

  <body>
    <div class="single-column">
      <article>
        <h1>GitHub Ribbons</h1>
        <p>Fork me on GitHub ribbons (<a href="https://github.blog/2008-12-19-github-ribbons/">source</a>) in SVG format for retina displays.</p>
        <?php $colors = array('red_aa0000', 'green_007200', 'darkblue_121621', 'orange_ff7600', 'gray_6d6d6d', 'white_ffffff');?>
        <?php $corners = array('left', 'right');?>
        <?php $style = 'background-color: #eee;border:none;margin:5px;padding:10px;width:300px;height:129px;resize:none;';?>
        <?php foreach ($corners as $corner): ?>
          <?php foreach ($colors as $color): ?>
          <?php $filename = "forkme_${corner}_${color}.svg";?>
          <?php $html = '<a href="https://github.com/you"><img src="' . $filename . '" style="position:absolute;top:0;' . $corner . ':0;" alt="Fork me on GitHub"></a>';?>
            <img src="/github-ribbons/<?php echo $filename; ?>" />
            <textarea style="<?php echo $style; ?>"><?php echo $html; ?></textarea><br/>
          <?php endforeach;?>
        <?php endforeach;?>
        <p>You may download <a href="github-ribbons.zip">github-ribbons.zip</a> containing this HTML page and all the SVG files.</p>
      </article>
    </div>
  </body>
</html>