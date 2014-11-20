<?php
/* 当前为默认错误页面 */
/* 可以自定义404和500等页面，放在当前目录下，取名为error404.php 或error500.php 即可 */
?>
<h2>Error <?php echo $errorCode; ?></h2>

<div class="error">
<?php echo $message; ?>
</div>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0020)http://twurn.com/500 -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <title>We're sorry, but something went wrong</title>
  <style type="text/css">
    body { background-color: #efefef; color: #333; font-family: Georgia,Palatino,'Book Antiqua',serif;padding:0;margin:0;text-align:center;  }
    p {font-style:italic;}
    div.dialog {
      width: 490px;
      margin: 4em auto 0 auto;
    }
    img { border:none; }
  </style>
<style type="text/css"></style></head>

<body>
  <!-- This file lives in public/500.html -->
  <div class="dialog">
    <a href="<?php echo Lii::app()->homeUrl; ?>"><img src="<?php echo Lii::app()->baseUrl.'/views/error/images/';?>error.png"></a>
    <p>Oh dear, it looks like something went horribly wrong.<br>We'll be taking a look at that shortly.</p>
  </div>


</body></html>