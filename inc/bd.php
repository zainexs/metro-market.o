<?php
error_reporting(0);
$link = mysqli_connect("localhost", "root", "root", "magaz")
    or die("Ошибка " . mysqli_error($link));
    mysqli_set_charset($link, "utf8");
?>