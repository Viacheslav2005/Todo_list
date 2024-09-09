<?php
session_start();
require_once "connect.php";
if(isset($_SESSION["message"])) {
    $mes = $_SESSION["message"];
    echo "<script>alert('$mes');</script>";
    unset($_SESSION["message"]);
}
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

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
</head>
<body>
<div class="div1">
    <div class="div_add">
        <h3>Todo list</h3>
        <div class="div-search">
            <input type="text" placeholder="Search note..." class="input-search">
            <select name="" id="">
                <option value="All">All</option>
                <option value="Complete">Complete</option>
                <option value="Incomplete">Incomplete</option>
            </select>
            <button class="btn-socket" id="theme-toggle"><img src="Image/Vector.svg" alt=""></button>
        </div>
    </div>
    <div class="div-notes">
        <?php if(mysqli_num_rows($query) == 0) { ?>
            <?php foreach ($notes as $note): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= htmlspecialchars($note['title']) ?></span>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-info edit-btn" data-id="<?= $note['id'] ?>">Edit</button>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $note['id'] ?>">Delete</button>
                        </div>
                    </li>
                <?php endforeach; ?>
        <?php } else { ?>
            <!-- <img src="Image/Detective-check-footprint 1.png" alt="" class="light-mode">  -->
            <!-- <img src="Image/Detective-check-footprint 1 dark.png" alt="" class="dark-mode">  -->
            <h3>Empty ... </h3>
        <?php } ?>
    </div>
</div>
<button type="button" class="btn-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">
  <img src="Image/Vector.png" alt="">
</button>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="CRUD/add_record.php" method="POST">
            <input type="hidden" value = "<?=$id?>" name = "id">
            <input type="text" placeholder="Тема задачи" name = "title">
            <input type="text" placeholder="Описание" name = "description">
            <input type="submit" value = "Создать">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="switch_theme.js"> 
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    const idInput = document.getElementById('id');

    // Функция для загрузки данных из базы данных
    async function loadData(id) {
        try {
            const response = await fetch(`load_data.php?id=${id}`);
            const data = await response.json();
            Object.assign(data, { id });
            fillFormWith(data);
        } catch (error) {
            console.error('Ошибка при загрузке данных:', error);
        }
    }

    // Функция для заполнения формы данными
    function fillFormWith(data) {
        idInput.value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('age').value = data.age;
    }

    // Обработчик отправки формы
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const id = formData.get('id');

        try {
            const response = await fetch('update_data.php', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                throw new Error('Ошибка сервера');
            }

            const result = await response.text();
            alert(result);

            // Очистка формы после успешного сохранения
            this.reset();
        } catch (error) {
            console.error('Ошибка при редактировании:', error);
            alert('Произошла ошибка при редактировании. Пожалуйста, попробуйте снова.');
        }
    });

    // Загрузка данных при открытии страницы
    const urlParams = new URLSearchParams(window.location.search);
    const idFromUrl = urlParams.get('id');
    if (idFromUrl) {
        loadData(idFromUrl);
    }
});
</script> -->
</body>
</html>