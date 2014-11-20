<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Lii::app()->baseUrl; ?>/login/style.css" />
<title>登录</title>
</head>
<body>

        <form id="login" method="post" action="login">
                <h1>Log In</h1>
                <fieldset id="inputs">
                        <input id="username" name="Username" type="text" placeholder="Username" autofocus required>
                        <input id="password" name="Password" type="password" placeholder="Password" required>
                </fieldset>
                <fieldset id="actions">
                        <input type="submit" name="Submit" id="submit" value="Log in">
                        <a href="">
                                Forgot your password?
                        </a>
                        <a href="">
                                Register
                        </a>
                </fieldset>
                <a href="http://www.mycodes.net" id="back">
                        Back to article...
                </a>
        </form>
        <!-- BSA AdPacks code -->
        <script src="http://code.jquery.com/jquery-1.6.3.min.js">
        </script>
        <script>
                (function() {
                        var bsa = document.createElement('script');
                        bsa.async = true;
                        bsa.src = 'http://www.mycodes.net';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(bsa);
                })();
        </script>
        <div style="clear:both">
        </div>
        <br>
        <br>
        <div style="text-align:center">
                <br>
                <br>
        </div>
</body>

</html>