<?php
session_start();
require("../inc/config.php");
$select = "SELECT * FROM tovars";
$all_tovars = mysqli_query($link, $select);
if (!$_SESSION['admin_auth']) {
  header('Location: /admin/auth.php');
}
$sql_select1 = "SELECT COUNT(*) FROM purchases";
$result1 = mysqli_query($link, $sql_select1);
$row = mysqli_fetch_array($result1);
if ($row) {
  $kupilo = $row['COUNT(*)'];
}
$sql_select1 = "SELECT SUM(suma) FROM payments";
$result1 = mysqli_query($link, $sql_select1);
$row = mysqli_fetch_array($result1);
if ($row) {
  $profit = $row['SUM(suma)'];
}
$sql_select1 = "SELECT COUNT(*) FROM users";
$result1 = mysqli_query($link, $sql_select1);
$row = mysqli_fetch_array($result1);
if ($row) {
  $users = $row['COUNT(*)'];
}
if ($profit == '') {
  $profit = 0;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= $sitename ?>.<?= $sitedomen ?> &raquo; Админ-панель</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/toastr.css">
  <script src="https://kit.fontawesome.com/6cce539f85.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="../js/jquery-latest.min.js"></script>
</head>

<body>
  <style>
    tr {
      white-space: nowrap;
    }

    @media (max-width:1075.98px) {
      .table-responsive-sm {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar
      }

      .table-responsive-sm>.table-bordered {
        border: 0
      }
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
      <!--   <span style=""><img style="animation: blink 3.5s;width:120px; height:120px" src="/img/logo.png"></span>-->
      <div class="spinner-border float-right" style="width:60px; height:60px" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="#">
        <img src="/img/logo1.png" width="30" height="30" class="d-inline-block align-top" alt="" title="Котик">
        <?= $sitename ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Редактирование товаров</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#stat">Статистика</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/">На главную</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#promo" data-toggle="modal" data-target="#promo">Генерация промокодов</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/admin/admin_logout.php">Выйти</a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- NAVBAR END -->

    <div class="container wrapper">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active show">
          <div class="container">
            <div class="row">
              <!-- Админ - панель -->
              <div style="width:100%; margin-bottom:10px">
                <h5 style=" float:left; display:inline-block; padding-top:3px">Товары</h5><button class="btn btn-primary" style="float:right; display:inline-block;" data-toggle="modal" data-target="#add_prod">Добавить</button>
              </div>
              <table class="table-responsive-sm table table-striped- table-bordered table-hover table-checkable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Цена (RUB)</th>
                    <th scope="col">Просмотров</th>
                    <th scope="col">Покупок</th>
                    <th scope="col">Действия</th>
                  </tr>
                </thead>
                <tbody id="tovars">
                  <?php
                  while ($row = mysqli_fetch_array($all_tovars)) {

                    $id = $row['id'];
                    $name = $row['name'];
                    $desc = $row['sm_desc'];
                    $cost = $row['cost'];
                    $views = $row['views'];
                    $sql_select1 = "SELECT COUNT(*) FROM purchases WHERE tovar_id = '$id'";
                    $result1 = mysqli_query($link, $sql_select1);
                    $row = mysqli_fetch_array($result1);
                    if ($row) {
                      $kupili = $row['COUNT(*)'];
                    }
                    echo '<tr id="product' . $id . '">
      <th scope="row">' . $id . '</th>
      <td>' . $name . '</td>
      <td style="white-space: nowrap;">' . $desc . '</td>
      <td>' . $cost . '</td>
      <td>' . $views . '</td>
      <td>' . $kupili . '</td>
      
      <td><button data-id="' . $id . '" onclick="del(this)" class="btn btn-danger " style="display:inline-block; width:49%;float:left;"><i class="fa fa-times"></i></button>
      <button data-edit="' . $id . '" onclick="edit(this)" class="btn btn-primary " style="display:inline-block; width:49%;float:right;" data-toggle="modal" data-target="#edit"><i class="fa fa-edit"></i></button>
      </td>
    </tr>';
                  }
                  ?>

                </tbody>
              </table>
              <!-- КОНЕЦ -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal "ADD" -->
    <div class="modal fade" id="add_prod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Добавление товара</h5>
            <button type="button" class="close" data-dismiss="modal" id="close_add" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="tovar_name">Название товара</label>
              <input type="text" class="form-control" id="tovar_name" placeholder="Название">
            </div>
            <div class="form-group">
              <label for="tovar_desc">Описание</label>
              <input type="text" class="form-control" id="tovar_desc" placeholder="Описание">
            </div>
            <div class="form-group">
              <label for="tovar_cost">Цена</label>
              <input type="text" class="form-control" id="tovar_cost" placeholder="Цена">
            </div>
            <div class="form-group">
              <label for="tovar_img">Ссылка на первый скрин</label>
              <input type="text" class="form-control" id="tovar_img" placeholder="Ссылка">
            </div>
            <div class="form-group">
              <label for="tovar_img">Ссылка на второй скрин</label>
              <input type="text" class="form-control" id="tovar_img2" placeholder="Ссылка">
            </div>
            <div class="form-group">
              <label for="tovar_img">Ссылка на третий скрин</label>
              <input type="text" class="form-control" id="tovar_img3" placeholder="Ссылка">
            </div>
            <div class="form-group">
              <label for="tovar_full">Товар (после оплаты)</label>
              <input type="text" class="form-control" id="tovar_full" placeholder="Товар">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary" onclick="add()">Добавить</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal "EDIT" -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Редактирование товара</h5>
            <button type="button" class="close" data-dismiss="modal" id="close_add" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="tovar_name">Название товара</label>
              <input type="text" class="form-control" id="edit_name" placeholder="Название">
            </div>
            <div class="form-group">
              <label for="tovar_desc">Цена</label>
              <input type="text" class="form-control" id="edit_cost" placeholder="Описание">
            </div>
            <div class="form-group">
              <label for="tovar_desc">Описание</label>
              <input type="text" class="form-control" id="edit_desc" placeholder="Описание">
            </div>
            <div class="form-group">
              <label for="tovar_full">Товар (после оплаты)</label>
              <input type="text" class="form-control" id="edit_full" placeholder="Товар">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary" id="save_btn" data-save="" onclick="save_edit()">Сохранить</button>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL "PROMOKOD" -->
    <div class="modal fade" id="promo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Сгенерировать промокод</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/action.php" method="post" class="form-group">
              <input type="submit" value="Сгенерировать новый промокод">
            </form>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal "STAT" -->
    <div class="modal fade" id="stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Статистика сайта</h5>
            <button type="button" class="close" data-dismiss="modal" id="close_add" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table-responsive-sm table table-striped- table-bordered table-hover table-checkable">
              <thead>
                <tr style="text-align:center;">
                  <center>
                    <th scope="col">Покупок всего</th>
                    <th scope="col">Пополнено</th>
                    <th scope="col">Пользователей</th>
                  </center>

                </tr>
              </thead>
              <tbody id="stat">
                <tr>

                  <td><?= $kupilo ?></td>
                  <td><?= $profit ?></td>
                  <td><?= $users ?></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    <script src="../js/script.js"></script>
    <script src="../js/toastr.js"></script>
    <?php require "promokod.php" ?>
  </body>

</html>