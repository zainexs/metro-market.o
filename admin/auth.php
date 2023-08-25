<?php
session_start();
require("../inc/config.php");
if(isset($_POST['checkAuth'])) {
    if($_POST['login'] == $admin_log && $_POST['pass'] == $admin_pass) {
        $_SESSION['admin_auth'] = "$admin_pass";
        header('Location: /admin/');
    }
    else {
        
    }
}
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="../css/admin.css">
<style>
    input {
        background:gray;
    }
</style>
    </head>
    <body>
        <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
        <br>
        
      <h5 style="color:gray">Вход в админ-панель</h5>
    </div>

    <!-- Login Form -->
    <form action="/admin/auth.php" method="POST">
      <input type="text" id="login" class="fadeIn second" name="login" placeholder="Логин">
      <input type="password" id="password" class="fadeIn third" name="pass" placeholder="Пароль">
      <input type="submit" class="fadeIn fourth" name="checkAuth" value="Войти">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <p class="underlineHover">Powered by <a class="" href="https://vk.com/metro_marketpubg" target="_blank">metro-case</a></p>
    </div>

  </div>
</div>
    </body>
</html>
