<?php
session_start();
require("inc/config.php");

$client_id = "$client_id"; // ID приложения
$client_secret = "$client_secret"; // Защищённый ключ
$redirect_uri = "$domen/auth.php"; // Адрес сайта
$url = 'http://oauth.vk.com/authorize';

if (isset($_GET['code'])) {
    $result = true;
    $params = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri
    ];

    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

    if (isset($token['access_token'])) {
        $params = [
            'uids' => $token['user_id'],
            'fields' => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $token['access_token'],
            'v' => '5.101'];

        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['id'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
    }
// инфа о пользователе

    $vk_id_s = $userInfo['id'];
    $name = $userInfo['first_name'];
    $last_name = $userInfo['last_name'];
    $login = "$name $last_name";
    $photo = $userInfo['photo_big'];
    $vk_id = "http://vk.com/id$vk_id_s";
// получили инфу о пользователе, пользователь имеется в бд
$sql_select2 = "SELECT COUNT(*) FROM users WHERE hash='$vk_id'";
$result2 = mysqli_query($link,$sql_select2);
$row = mysqli_fetch_array($result2);
if($row)
{	
$logc = $row['COUNT(*)'];
}
if($logc == 0) {
        if($vk_id != '') {
            $_SESSION['login'] = 1;
			$insert_sql1 = mysqli_query($link,"INSERT INTO `users` (`id`, `login`, `ava`, `balance`, `hash`) VALUES (NULL, '$login', '$photo', '0', '$vk_id');");
			$_SESSION['logged'] = $vk_id;
			header('Location: /');
    
        }
        }
       if($logc == 1) {
         if($vk_id != '') {
         $selecter = "SELECT * FROM users WHERE hash = '$vk_id'";
         $result3 = mysqli_query($link,$selecter);
         $row1 = mysqli_fetch_array($result3);
		 if($row1)
		{	
		$hashlog = $row1['hash'];
         
		}
      $_SESSION['logged'] = $hashlog;
      header('Location: /');
       }

}
}
