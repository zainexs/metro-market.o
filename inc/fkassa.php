<?php
include('config.php');
$merchant_id = $fk_id;
$merchant_secret = $fk_secret_1;
 if(isset($_POST['MERCHANT_ORDER_ID'])){
 function getIP() {
    if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
  }
  if (!in_array(getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) die("hacking attempt!");
  getIP();

  $sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

  if ($sign != $_REQUEST['SIGN']) die('wrong sign');

$label = $_POST['intid'];
$idmoney = $_POST['MERCHANT_ORDER_ID'];
$data = date('d-m-Y H:i:s');
$yandex = '';
$suma = $_POST['AMOUNT'];
		if (is_numeric($idmoney))
		{
		$sql_select = "SELECT * FROM users WHERE id='$idmoney'";
$result = mysqli_query($link,$sql_select);
$row = mysqli_fetch_array($result);
if($row)
{	
$balance = $row['balance'];
}


$balancenew = $row['balance'] + $suma;
$update_sql1 = "Update users set balance='$balancenew' WHERE id='$idmoney'";
    mysqli_query($link,$update_sql1);
			$insert_sql1 = "
			INSERT INTO `payments` (`user_id`, `suma`, `data`, `qiwi`, `transaction`) 
			VALUES ('{$idmoney}', '{$suma}', '{$data}', '{$yandex}', '{$label}')
			";
mysqli_query($link,$insert_sql1);
} 

    die('YES');
}
?>