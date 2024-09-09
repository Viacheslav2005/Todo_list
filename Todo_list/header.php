<?php
session_start();
if(isset($_SESSION["message"])) {
  $mes = $_SESSION["message"];
  echo "<script>alert('$mes')</script>";
  unset($_SESSION["message"]);
}
require_once "connect.php";
$id = isset($_SESSION["id"]);
$query = mysqli_query($con, "SELECT `username` FROM `users` WHERE `id` = '$id'");
$username = mysqli_fetch_assoc($query);
?>
<ul class="nav">
  <?php if(isset($_SESSION["auth"])) { ?>
    <li class="nav-item">
      <a class="nav-link" href="personal_account.php">Личный кабинет</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="personal_account.php"><?=$id?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php">Выход</a>
    </li>
  <?php } else { ?>
    <li class="nav-item">
      <a class="nav-link" href="index.php">Регистрация</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="signin.php">Авторизация</a>
    </li>
  <?php }?>
</ul>