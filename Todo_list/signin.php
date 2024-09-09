<?php
session_start();
if(isset($_SESSION["message"])) {
    $mes = $_SESSION["message"];
    echo "<script>alert('$mes')</script>";
    unset($_SESSION["message"]);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Авторизация</title>
</head>
<body>
    <?php include "header.php";?>
    <div class="container">
        <form method="POST" action="DB/signin_db.php">
            <div class="div_up">
                <label>Username</label>
                <input type="text" name = "username">
            </div>
            <div class="div_up">
                <label>Password</label>
                <input type="password" name = "password">
            </div>
            <button type="submit" class="btn btn-primary">Авторизация</button>
        </form>
    </div>
</body>
</html>