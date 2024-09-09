<?php
require_once "connect.php";

$id = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM `tasks` WHERE `id` = '$id'");

if(mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        echo json_encode($row);
    }
} else {
    echo 'Записи не найдены!';
}
?>