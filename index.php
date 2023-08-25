<?php
session_start();
setcookie(session_name(), session_id(), time() + 86400);
require("inc/config.php");
$is_https = "//";
$sid = $_SESSION['logged'];
$sql_select2 = "SELECT * FROM users WHERE hash = '$sid'";
$result2 = mysqli_query($link, $sql_select2);
$row = mysqli_fetch_array($result2);
if ($row) {
  $user_id = $row['id'];
  $balance = $row['balance'];
  $ava = $row['ava'];
  $login = $row['login'];
}
$select = "SELECT * FROM tovars";
$all_tovars = mysqli_query($link, $select);
$pur = "SELECT * FROM purchases WHERE user_id = '$user_id'";
$all_purchases = mysqli_query($link, $pur);
$data = date("d.m.Y");

?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= $sitename ?>.<?= $sitedomen ?> &raquo; Магазин скриптов</title>
  <meta property="og:image" content="/img/logoog.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/toastr.css">
  <link rel="stylesheet" href="/css/cards.css">
  <script src="https://kit.fontawesome.com/6cce539f85.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="//ulogin.ru/js/ulogin.js"></script>
  <script src="../js/jquery-latest.min.js"></script>
  <script type="text/javascript" src="https://vk.com/js/api/openapi.js?167"></script>
  <script src="https://unpkg.com/@vkontakte/superappkit@1.57.0/dist/index-umd.js"></script>
  <link href="/img/favicon.ico" type="image/x-icon" rel="shortcut icon">
  <style>
    tr {
      white-space: nowrap;
    }

    @media (max-width:1575.98px) {
      .table-responsive-sm {
        /*display: block;*/
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar
      }

      .dropdown-item:focus {
        background: #fff;
        color: #000;
      }

      .dropdown-item:hover {
        background: #edebeb;
        color: #000;
      }
  </style>
  <script>
    $(window).on('load', function() {
      $preloader = $('.preloader'),
        $preloader.fadeIn(200).delay(250).fadeOut(700);
    });
  </script>
</head>

<body>

  <div class="preloader">
    <!-- <span style=""><img style="animation: blink 3.5s;width:120px; height:120px" src="/img/logo.png"></span>-->
    <div class="spinner-border float-right" style="width:60px; height:60px" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div style="width:100%; background: #fff; " class="sticky-top full-nav">
    <nav class="navbar navbar-expand-lg container navbar-light bg-light">


      <a class="navbar-brand" href="#">
        <?= $sitename ?> </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse " id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">

            <a class="nav-link" href="#">Главная</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#contact">Контакты</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#garant">Гарантии</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= $reviews ?>" target="_blank">Отзывы</a>
          </li>
          <?php
          if (!$_SESSION['logged']) { ?>
            <li class="nav-item">
              <a href="https://oauth.vk.com/authorize?client_id=<?= $client_id; ?>&redirect_uri=<?= $domen; ?>/auth.php&response_type=code" class="nav-link">Авторизоваться</a>
            <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link palka" style="display:inline-block;cursor:pointer;">|</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $login ?></a>
              <div class="dropdown-menu" style="border:none">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#purchases">Мои покупки</a>
                <a class="dropdown-item" href="<?= $support_link ?>" target="_blank">Тех. поддержка</a>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" style="display:inline-block; cursor:pointer;">Баланс: <span id="balance"><?= $balance ?></span> <i class="fa fa-rub"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="display:inline-block;cursor:pointer;" data-toggle="modal" data-target="#deposit">Пополнить</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="display:inline-block;cursor:pointer;" data-toggle="modal" data-target="#promokod">Промокод</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/logout.php" style="cursor:pointer;">Выйти</a>
            </li>
          <?php } ?>
        </ul>
      </div>

    </nav>
  </div>
  <!-- NAVBAR END -->

  <div class="container wrapper" style="min-height:376px;">
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active show">
        <div class="container">
          <div class="row d-flex justify-content-center">

            <?php
            while ($row = mysqli_fetch_array($all_tovars)) {

              $id = $row['id'];
              $name = $row['name'];
              $desc = $row['sm_desc'];
              $cost = $row['cost'];
              $views = $row['views'];
              $img = $row['img'];
              $date_t = $row['date'];
              echo '<div class="HomeCard game-box col-sm-12 text-center" style="margin:10px">
<div class="card-name">' . $cost . ' руб.</div>
<div class="HomeCard-Image" style="background-image: url(' . $img . ');"></div>
<div class="HomeCard-Icon"><img alt="' . $name . ' icon" src="/img/logo1.png" style="width:50px; height:50px"></div>
<h4 class="HomeCard-Title">' . $name . '</h4><p class="HomeCard-Text">' . $desc . '</p>
<button class="Btn HomeCard-Button Btn_blue" onclick="view(' . $id . ')" data-toggle="modal" data-target="#open_it">Подробнее</button></div>';
            }
            ?>


          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid footer-bg" style="margin-top:82px;">
    <div class="container">
      <footer>

        <div class="row col-sm-12">
          <div class="col-sm-5 foo-left-box">
            <a class="navbar-brand" href="#">
              <?= $sitename ?>
            </a>
            <div class="nav-logo"><span class="footer-ava-text">&copy; 2023-2024 <?= $sitename ?>.<?= $sitedomen ?></span>Все права защищены.<br>
              <a href="https://www.free-kassa.ru/"><img src="https://www.free-kassa.ru/img/fk_btn/14.png"></a>
            </div>
          </div>
        </div>
    </div>

    </footer>
  </div>
  <!-- VK Widget -->
  <div id="vk_community_messages"></div>
  <script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", <?= $group_id ?>, {
      tooltipButtonText: "Есть вопрос?"
    });
  </script>

  <?php require "blocks/add.php" ?>
  <?php require "blocks/purchases.php" ?>
  <?php require "blocks/garant.php" ?>
  <?php require "blocks/contact.php" ?>
  <?php require "blocks/deposit.php" ?>
  <?php require "blocks/promokod.php" ?>

  <script src="../js/script.js"></script>
  <style>
    .ccs161 {
      display: none;
    }
  </style>
  <script src="../js/toastr.js"></script>
</body>

</html>