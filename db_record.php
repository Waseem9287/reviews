<?php
require_once ("db_init.php");

$_FILES['image'];

$image = $_FILES['image'];
if ($image['size'] > 0) {
    if ($image['error'] > 0) {

        $image_error = displayImageError($image['error']);
        header("HTTP/1.0 400 bad request");
        echo $image_error;
        exit();
    }

    if (!(($image['type'] == 'image/jpeg') ||
        ($image['type'] == 'image/png')    ||
        ($image['type'] == 'image/gif')))
    {
        header("HTTP/1.0 400 bad request");
        echo "Данный тип файла не поддерживается!";
        exit();
    }

    if ($image['size'] > 2000000) {
        header("HTTP/1.0 400 bad request");
        echo "Вы привысили максимальный объем файла!";
        exit();
    }

    $extension = new SplFileInfo($image['name']);
    $extension = '.' . $extension->getExtension();

    do {
        $image_name = md5(microtime() . rand(0, 9999));
        $image_path = 'upload/' . $image_name . $extension;
    } while (file_exists($image_path));

    move_uploaded_file($image['tmp_name'], $image_path);
}
else {
    $image_path = NULL;
}

$captcha = $_POST['g-recaptcha-response'];
$user_name = clean($_POST['user_name']);
$description = clean($_POST['review_tittle']);
$content = clean($_POST['review_content']);
$date = time();
validateData($user_name, $description, $content, $captcha);
$db_record =
    "INSERT INTO `comments` (`user_name`, `description`, `content`, `image`, `datetime`) 
         VALUES ('{$user_name}', '{$description}', '{$content}', '{$image_path}', '{$date}');";
$STH = $db->prepare($db_record);
$STH->execute();
$id = $db->query('SELECT MAX(id) FROM comments');
$id = $id->fetch();
displayView($id['MAX(id)'], $user_name, $description, $content, $image_path, $date);

function displayImageError($error) {
    switch ($error) {
        case 1 || 2:
            return("Размер файла выше допустимого!");
            break;

        case 3:
            return("Загружена только часть файла!");
            break;

        case 4:
            return("Файл не был загружен!");
            break;

        case 5:
            return("Загрузка невозможна: не задан временный каталог!");
            break;

        case 6:
            return ("Загрузка невыполнена: невозможна запись на диск!");
            break;
    }
}

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

function validateData($user_name, $description, $content, $captcha) {

    if(!$user_name || !$description || !$content) {
        header("HTTP/1.0 400 bad request");
        echo "Заполните необходимые поля!";
        exit();
    }
    if ((2 > strlen($user_name)) && (strlen($user_name) < 19))
    {
        header("HTTP/1.0 400 bad request");
        echo "Имя заполнено некорректно!";
        exit();
    }
    if ((4 > strlen($description)) && (strlen($description) < 51))
    {
        header("HTTP/1.0 400 bad request");
        echo "Тема заполнена некорректно!";
        exit();
    }
    if (strlen($content) > 500)
    {
        header("HTTP/1.0 400 bad request");
        echo "Отзыв заполнен некорректно!";
        exit();
    }
    if (!$captcha)
    {
        header("HTTP/1.0 400 bad request");
        echo "Подтвердите что вы не робот!";
        exit();
    }
}

function displayView($id, $name, $description, $content, $image_path, $date) {
    $datetime = date("Y-m-d H:i:s", $date);
    echo "
            <div class='review'>
                <div class='review_user'>
                    <div class='review_id'>№{$id}</div>
                    Name: <div class='review_name'>{$name}</div>
                    <div class='review_date'>{$datetime}</div>
                </div>

                <div class='review_description'>Tittle: <span class='review_tittle'>{$description}</span></div>
                <div class='review_content'><p>{$content}</p></div>";
            if (file_exists($image_path)) {
                echo "
                <div class='image_wrapper'>
                    <a target='_blank' rel='nofollow' href='{$image_path}'>
                        <img width='20%' height='20%' class='review_image' src='{$image_path}'>
                    </a>
                </div> ";
            }
    echo "  </div>";
}