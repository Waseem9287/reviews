<?php
require_once ("db_init.php");

$image = $_FILES['image'];
if ($image['size'] > 0) {
    if ($image['error'] > 0) {

        switch ($image['error']) {

            case 1 || 2:
                $image_error = "Размер файла выше допустимого!";
                break;

            case 3:
                $image_error = "Загружена только часть файла!";
                break;

            case 4:
                $image_error = "Файл не был загружен!";
                break;

            case 5:
                $image_error = "Загрузка невозможна: не задан временный каталог!";
                break;

            case 6:
                $image_error = "Загрузка невыполнена: невозможна запись на диск!";
                break;

        }
        echo $image_error;
        exit();
    }

    if (!(($image['type'] = 'image/jpeg') ||
        ($image['type'] = 'image/png') ||
        ($image['type'] = 'image/gif'))
    ) {
        echo $image_error = "Данный тип файла не поддерживается!";
        exit();
    }

    if ($image['size'] > 20000000) {
        echo $image_error = "Вы привысили максимальный объем файла!";
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

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

$user_name = clean($_POST['user_name']);
$description = clean($_POST['review_tittle']);
$content = clean($_POST['review_content']);
$date = time();

if(!empty($user_name) && !empty($description) && !empty($content)) {
    if (
        ((2 < strlen($user_name)) && (strlen($user_name) < 19))     &&
        ((4 < strlen($description)) && (strlen($description) < 51)) &&
        (strlen($content) < 500)) {
        $db_record = "INSERT INTO `comments` (`id`, `user_name`, `name`, `description`, `image`, `datetime`) VALUES (NULL, '" . $user_name . "', '" . $description . "', '" . $content . "', '" . $image_path . "', '" . $date . "');";
        $STH = $db->prepare($db_record);
        $STH->execute();
        $id = $db->query('SELECT MAX(id) FROM comments');
        $id = $id->fetch();
        echo "
        <div>
            <span>№" . $id['MAX(id)'] . "</span>
            <span>" . $user_name . "</span>
        </div>
        <div>
        <span>" . date("Y-m-d H:i:s", $date) . "</span>
        </div>
        <div>" . $description . "</div>
        <div>" . $content . "</div>";
        if (file_exists($image_path)) {
            echo " <img src=' " . $image_path . " '>";
        }
    } else {
        header("HTTP/1.0 400 bad request");
        echo "Поля заполнены некорректно!";
    }
}
else{
    header("HTTP/1.0 400 bad request");
    echo "Заполните необходимые поля!";
}


