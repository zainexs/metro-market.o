<?php
session_start();
require("inc/config.php");
$sid = $_SESSION['logged'];
$data = date("d.m.Y");
$type = $_POST['type'];
$error = 0;
$fa = "";
if($type == "saveTovar") {
    $id = $_POST['id'];
    $name = $_POST['new_name'];
    $cost = $_POST['new_cost'];
    $desc = $_POST['new_desc'];
    $tovar = $_POST['new_full'];
    if(!$_SESSION['admin_auth']) {
    $error = 3;
    $mess = "Авторизуйтесь как администратор";
    $fa = "fatal";     
    }
    if($error == 0) {
     $query = mysqli_query($link,"UPDATE tovars SET name = '$name' WHERE id = '$id'");
     $query1 = mysqli_query($link,"UPDATE tovars SET cost = '$cost' WHERE id = '$id'");
     $query2 = mysqli_query($link,"UPDATE tovars SET sm_desc = '$desc' WHERE id = '$id'");
     $query3 = mysqli_query($link,"UPDATE tovars SET alter_payment = '$tovar' WHERE id = '$id'");
     $fa = "success";
    }
    $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'name' => "$name",
	'cost' => "$cost",
	'tovar' => "$tovar",
	'desc' => "$desc",
	'id' => "$id_tovar"
	);
}
if($type == "editTovar") {
    $id = $_POST['id_edit'];
    if(!$_SESSION['admin_auth']) {
    $error = 3;
    $mess = "Авторизуйтесь как администратор";
    $fa = "fatal";     
    }
    if($error == 0) {
   $sql_select1 = "SELECT * FROM tovars WHERE id = '$id'";
$result1 = mysqli_query($link,$sql_select1);
$row = mysqli_fetch_array($result1);
if($row)
{
$id_tovar = $row['id']; // id товара
$cost = $row['cost'];
$tovar = $row['alter_payment'];
$name = $row['name'];
$desc = $row['sm_desc'];
}
    $fa = "success";
    }
    $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'name' => "$name",
	'cost' => "$cost",
	'tovar' => "$tovar",
	'desc' => "$desc",
	'id' => "$id_tovar"
	);
}
if($type == "deposit")
{
	
$size = $_POST['size'];
$sql_select = "SELECT * FROM users WHERE hash='$sid'";
$result = mysqli_query($link,$sql_select);
$row = mysqli_fetch_array($result);
if($row)
{	
$bala = $row['balance'];
$user_id = $row['id'];
}
 if($size < 1) {
     $error = 1;
     $mess = "Сумма пополнения от 1";
     $fa = "fatal";
 } 
  if($error == 0) {
$podpis = md5($fk_id.':'.$size.':'.$fk_secret_1.':'. $user_id);
  $fa = "success";
}
    $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'location' => "http://www.free-kassa.ru/merchant/cash.php?m=".$fk_id."&oa={$size}&o={$user_id}&s=".$podpis.""
    );
  

}

// Генерация нового промокода
$code = generate_promocode();

// Дата начала действия промокода
$start_date = date('Y-m-d');

// Дата окончания действия промокода - 1 дней с момента генерации
$end_date = date('Y-m-d', strtotime("+1 days"));

// Статус промокода
$status = 'active';

// Запись промокода в базу данных
$sql1000 = "INSERT INTO promocodes (code, start_date, end_date, status) VALUES ('$code', '$start_date', '$end_date', '$status')";
mysqli_query($link, $sql1000);

// Функция для генерации нового промокода
function generate_promocode()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < 10; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}

$code1 = $_POST['code'];

// Поиск промокода в базе данных
$sql10001 = "SELECT * FROM promocodes WHERE code = '$code1'";
$result10001 = mysqli_query($link, $sql10001);
if (mysqli_num_rows($result10001) > 0) {
    $row10001 = mysqli_fetch_assoc($result10001);

    // Если промокод активен
    if ($row10001['status'] == 'active') {
        // Обновление статуса промокода в базе данных на "used"
        $sql10001 = "UPDATE promocodes SET status = 'used' WHERE code = '$code1'";
        mysqli_query($link, $sql10001);

        // Вывод сообщения об успешном использовании промокода
        echo "Промокод успешно использован!";
    } else {
        // Вывод сообщения о том, что промокод уже использован
        echo "Этот промокод уже использован.";
    }
} else {
    // Вывод сообщения о том, что промокод не найден
    echo "Промокод не найден.";
}










if($type == "confirm") { 
$tovar = $_POST['id'];
// получаем инфу о юзере (ага да)
$sql_select2 = "SELECT * FROM users WHERE hash = '$sid'";
$result2 = mysqli_query($link,$sql_select2);
$row = mysqli_fetch_array($result2);
if($row)
{
$balance = $row['balance'];
$user_id = $row['id'];
}
// получем инфу о товаре, а иначе нахуй мы вообще сделали "магазин"?
$sql_select1 = "SELECT COUNT(*) FROM tovars WHERE id = '$tovar'";
$result1 = mysqli_query($link,$sql_select1);
$row = mysqli_fetch_array($result1);
if($row)
{
$count = $row['COUNT(*)'];
}
$sql_select1 = "SELECT * FROM tovars WHERE id = '$tovar'";
$result1 = mysqli_query($link,$sql_select1);
$row = mysqli_fetch_array($result1);
if($row)
{
$id_tovar = $row['id']; // id товара
$size = $row['cost'];
$tovar = $row['alter_payment'];
$name = $row['name'];
}
// ну теперь выявляем ошибки
    if(!$_SESSION['logged']) {
        $error = 1;
        $mess = "Необходимо авторизоваться";
        $fa = "fatal";
    }
    if($_SESSION['logged']) {
    if($balance < $size) {
        $error = 2;
        $mess = "Недостаточно средств";
        $fa = "fatal";
    }
    if($count == 0) {
        $error = 3;
        $mess = "Товар не найден !";
        $fa = "fatal";
    }
    if(!is_numeric($balance)) {
        $error = 4;
        $mess = "Что-то пошло не так..";
        $fa = "fatal";
    }
    }
    if($error == 0) {
        $newbalance = $balance - $size;
        $query = mysqli_query($link,"UPDATE users SET balance = '$newbalance' WHERE hash = '$sid'");
        $query1 = mysqli_query($link,"INSERT INTO `purchases` (`id`, `user_id`, `tovar_id`, `name`, `tovar`) VALUES (NULL, '$user_id', '$id_tovar', '$name', '$tovar');");
        $sql_select21 = "SELECT @@identity FROM purchases";
        $result21 = mysqli_query($link,$sql_select21);
        $row = mysqli_fetch_array($result21);
        if($row)
        {
        $id_pur = $row['@@identity'];
        }
        $fa = "success";
}
$result = array(
	'success' => "$fa",
	'error' => "$mess",
	'id' => "$id_pur",
	'balance' => "$newbalance",
	'tovar' => "$tovar",
	'name' => "$name"
	);
}
if($type == "delTovar") {
    $delete_id = $_POST['id_del'];
    if(!$_SESSION['admin_auth']) {
    $error = 3;
    $mess = "Авторизуйтесь как администратор";
    $fa = "fatal";     
    }
    if($error == 0) {
    $query = mysqli_query($link,"DELETE FROM `tovars` WHERE id = '$delete_id'");
    $fa = "success";
    }
    $result = array(
	'success' => "$fa",
	'error' => "$mess"
	);
}
if($type == "addTovar") {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $cost = $_POST['cost'];
    $links = $_POST['link'];
    $link2 = $_POST['link2'];
    $link3 = $_POST['link3'];
    $alter_pay = $_POST['alter_pay'];
    if($name == '' || $desc == '' || $cost == '' || $links == ''|| $alter_pay == '' || $link2 == '' || $link3 == '') {
    $error = 1;
    $mess = "Заполните все поля!";
    $fa = "fatal";   
    }
    if(!is_numeric($cost)) {
    $error = 2;
    $mess = "Заполните сумму корректно";
    $fa = "fatal";    
    }
    if(!$_SESSION['admin_auth']) {
    $error = 3;
    $mess = "Авторизуйтесь как администратор";
    $fa = "fatal";     
    }
    if($error == 0) {
        $query = mysqli_query($link,"INSERT INTO `tovars` (`id`, `sm_desc`, `cost`, `views`, `name`, `img`, `img2`, `img3`, `alter_payment`, `date`) VALUES (NULL, '{$desc}', '{$cost}', '0', '{$name}', '{$links}', '{$link2}', '{$link3}', '{$alter_pay}', '{$data}');");
         $sql_select21 = "SELECT @@identity FROM tovars";
$result21 = mysqli_query($link,$sql_select21);
$row = mysqli_fetch_array($result21);
if($row)
{
    $id = $row['@@identity'];
}
 $fa = "success";
    }
    $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'id' => $id,
	'desc' => "$desc",
	'name' => "$name",
	'cost' => "$cost"
    );

}
if($type == "selectTovar") {
$id_s = $_POST['id'];
$sql_select1 = "SELECT COUNT(*) FROM tovars WHERE id = '$id_s'";
$result1 = mysqli_query($link,$sql_select1);
$row = mysqli_fetch_array($result1);
if($row)
{
    $find = $row['COUNT(*)'];
}
if($find == 0) {
    $error = 1;
    $mess = "Товар не существует!";
    $fa = "fatal";
}
if($error == 0) {
$sql_select2 = "SELECT * FROM tovars WHERE id = '$id_s'";
$result2 = mysqli_query($link,$sql_select2);
$row = mysqli_fetch_array($result2);
if($row)
{
    $img = $row['img'];
    $img2 = $row['img2'];
    $img3 = $row['img3'];
    $desc = $row['sm_desc'];
    $name = $row['name'];
    $cost = $row['cost'];
    $views = $row['views'];
    $id = $row['id'];
}
$views_new = $views + 1;
$query = mysqli_query($link,"UPDATE tovars SET views = '$views_new' WHERE id = '$id_s'");
$fa = "success";
}
$result = array(
	'success' => "$fa",
	'error' => "$mess",
	'image' => $img,
	'image2' => "$img2",
	'image3' => "$img3",
	'desc' => "$desc",
	'name' => "$name",
	'cost' => "$cost",
	'views' => "$views_new",
	'id' => "$id"
    );
}
	/* огромное спасибо за покупку, моя страница в вк - https://vk.com/id321223555 по всем вопросам и т.д */
    echo json_encode($result);
