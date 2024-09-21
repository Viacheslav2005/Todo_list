<?php
session_start();
require_once "connect.php";
if(isset($_SESSION["message"])) {
    $mes = $_SESSION["message"];
    echo "<script>alert('$mes');</script>";
    unset($_SESSION["message"]);
}

$all_notes = mysqli_query($con, "SELECT * FROM `tasks`");

$id = isset($_SESSION["id"]) ? $_SESSION["id"] : false;

$title_task = isset($_GET["search"]) ? $_GET["search"] : false;
$search = mysqli_query($con, "SELECT * FROM `tasks` WHERE `title` LIKE '%$title_task%' AND `user_id` = '$id'");
$searchs = mysqli_fetch_all($search);

$status = isset($_GET['is_complete']) ? $_GET['is_complete'] : false;
$status_query = mysqli_query($con, "SELECT * FROM `tasks` ORDER BY `is_complete` = '$status' AND `user_id` = '$id' DESC");
$status_all = mysqli_fetch_all($status_query);

$query = mysqli_query($con, "SELECT * FROM `tasks` WHERE `user_id` = '$id'");
$notes = mysqli_fetch_all($query);
?>
<?php include "header.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="personal_account.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
<div class="div1">
    <div class="div_add">
        <h3>Todo list</h3>
        <div class="div-search">
            <form action = "" class="search_form" method="GET">
                <input type="text" placeholder="Search note..." class="input-search" value = "<?=$title_task?>" name = "search">
                <button type="submit" class="btn-submit-search"><img src="Image/Loupe.svg" alt=""></button>
            </form>
            <form action="" method="GET">
                <select name="is_complete" id="">
                    <option value="0">All</option>
                    <option value="Выполненно">Complete</option>
                    <option value="Невыполненно">Incomplete</option>
                </select>
            </form>
            <button class="btn-socket" id="theme-toggle"><img src="Image/Vector.svg" alt=""></button>
        </div>
    </div>
    <div class="div-notes" id="div_notes">
        <?php if($title_task && !$status) { ?>
            <?php if(mysqli_num_rows($query) > 0) { ?>
                <?php foreach ($searchs as $note): ?>
                    <div class="note" id = "note" data-task-id='<?=$note[0]?>'>
                        <div class="div-checkbox">
                            <form action="CRUD/edit_record.php" method="POST">
                                <div class="div-checkbox">
                                    <input type="checkbox" class="checkbox" name = "task_id" id = "task_id" value="<?=$note[0]?>">
                                    <input type="text" value="<?= $note[2] ?>" name = "title" class="input_note" id = "title_note">
                                </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn-edit"><img src="Image/Edit.svg" alt=""></button>
                        </form>
                            <button class="btn-delete" id="btn-delete" data-id = "<?=$note[0]?>"><img src="Image/Delete.svg" alt=""></a></button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php } else { ?>
                <div class="note">
                    <img src="Image/Detective-check-footprint 1.png" alt="" class="light-mode"> 
                    <!-- <img src="Image/Detective-check-footprint 1 dark.png" alt="" class="dark-mode">  -->
                    <h3>Empty ... </h3>
                </div>
            <?php } ?>
        <?php } elseif(!$title_task && $status) { ?>
            <?php if(mysqli_num_rows($query) > 0) { ?>
                <?php foreach ($status_all as $note): ?>
                    <div class="note" id = "note" data-task-id='<?=$note[0]?>'>
                        <div class="div-checkbox">
                            <form action="CRUD/edit_record.php" method="POST">
                                <div class="div-checkbox">
                                    <input type="checkbox" class="checkbox" name = "task_id" id = "task_id" value="<?=$note[0]?>">
                                    <input type="text" value="<?= $note[2] ?>" name = "title" class="input_note" id = "title_note">
                                </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn-edit"><img src="Image/Edit.svg" alt=""></button>
                        </form>
                            <button class="btn-delete" id="btn-delete" data-id = "<?=$note[0]?>"><img src="Image/Delete.svg" alt=""></a></button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php } else { ?>
                <div class="note">
                    <img src="Image/Detective-check-footprint 1.png" alt="" class="light-mode"> 
                    <!-- <img src="Image/Detective-check-footprint 1 dark.png" alt="" class="dark-mode">  -->
                    <h3>Empty ... </h3>
                </div>
            <?php } ?>
        <?php } elseif(!$title_task && !$status) { ?>
            <?php if(mysqli_num_rows($query) > 0) { ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note" id = "note" data-task-id='<?=$note[0]?>'>
                        <div class="div-checkbox">
                                <div class="div-checkbox">
                                    <?php if($note[4] == "Невыполненно") { ?>
                                        <input type="checkbox" class="checkbox" name = "task_id" id = "task_id" value="<?=$note[0]?>">
                                        <input type="text" value="<?= $note[2] ?>" name = "title" class="input_note" id = "title_note" >
                                    <?php } else { ?>
                                        <input type="checkbox" class="checkbox checked" name = "task_id" id = "task_id" value="<?=$note[0]?>">
                                        <input type="text" value="<?= $note[2] ?>" name = "title" class="input_note completed" id = "title_note" readonly>
                                    <?php } ?>
                                </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn-edit"><img src="Image/Edit.svg" alt=""></button>
                            <button class="btn-delete" id="btn-delete" data-id = "<?=$note[0]?>"><img src="Image/Delete.svg" alt=""></a></button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php } else { ?>
                <div class="note">
                    <img src="Image/Detective-check-footprint 1.png" alt="" class="light-mode"> 
                    <!-- <img src="Image/Detective-check-footprint 1 dark.png" alt="" class="dark-mode">  -->
                    <h3>Empty ... </h3>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<button type="button" class="btn-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">
  <img src="Image/Vector.png" alt="">
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id = "modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="text-align: center;">Новая задача</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="CRUD/add_record.php" method="POST" class = "add_record_form">
            <input type="hidden" value = "<?=$id?>" name = "id">
            <input type="text" placeholder="Тема задачи" name = "title" class="modal_window_input">
            <input type="text" placeholder="Описание" name = "description" class="modal_window_input">
            <div class="modal_div_btn">
                <button type = "button" data-bs-dismiss="modal" id = "modal_window_btn_close">Close</button>
                <button type = "submit" class="btn-add">Создать задание</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="switch_theme.js"></script>
<script>
    
    function showEmptyMessage() {
        var emptyMessage = '<div class="div-notes">' +
            '<img src="Image/Detective-check-footprint 1.png" alt="" class="light-mode">' +
            '<h3>Empty...</h3>' +
            '</div>';
        $('#div_notes').html(emptyMessage);
    }


$(document).on('click', '.btn-delete', function () {
    var taskId = $(this).closest('.note').data('task-id');
    console.log(taskId);
    
    $.ajax({
        url: '../CRUD/delete_record.php',
        method: 'POST',
        data: { id: taskId },
        success: function (response) {
            console.log('Запрос успешен:', response);
            // Удаление задачи из DOM
            var noteElement = document.querySelector('.note[data-task-id="' + taskId + '"]');
            if (noteElement) {
                noteElement.remove();
            }
            
            // Проверка, есть ли задачи после удаления
            if ($('.note').length == 0) {
                showEmptyMessage();
            }
        },
        error: function (xhr, status, error) {
            console.error('Ошибка:', error);
        }
    });
});

$(document).on('click', '.btn-edit', function () {
    var taskId = $(this).closest('.note').data('task-id');
    var taskTitle = $(this).closest('.note').find('.input_note').val();
    console.log(taskId);
    console.log(taskTitle);
    
    $.ajax({
        url: '../CRUD/edit_record.php',
        method: 'POST',
        data: { id: taskId, title: taskTitle},
        success: function (response) {
            console.log('Запрос успешен:', response);
        },
        error: function (xhr, status, error) {
            console.error('Ошибка:', error);
        }
    });
});

// Обновленная функция для изменения статуса задачи
$(document).on('change', '.checkbox', function () {
    var taskId = $(this).closest('.note').data('task-id');
    var checkbox = this;
    var status = checkbox.checked ? "Выполненно" : "Невыполненно";
    
    $.ajax({
        url: '../CRUD/update_task_status.php',
        method: 'POST',
        data: { id: taskId, status: status },
        success: function (response) {
            console.log('Запрос успешен:', response);
            
        },
        error: function (xhr, status, error) {
            console.error('Ошибка:', error);
        }
    });
});

var taskId = $(this).closest('.note').data('task-id');
var checkbox = this;
checkbox.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
    const noteText = checkbox.nextElementSibling; // Получаем элемент <p>
        if (checkbox.checked) {
            noteText.classList.add('completed'); // Добавляем класс 'completed'
        } else {
            noteText.classList.remove('completed'); // Удаляем класс 'completed'
        }
    });
});

// const inputField = document.getElementById('title_note'); // Получение элемента input

checkbox.addEventListener('change', () => {
    if (checkbox.checked) {
        document.getElementById('title_note').readOnly = true; // Делаем input нередактируемым
    } else {
        document.getElementById('title_note').readOnly = false; // Делаем input редактируемым
    }
});
</script>
</body>
</html>