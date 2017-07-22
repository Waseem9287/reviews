<?php
require_once "db_init.php";
?>
<html lang="Ruru">
<head>
    <meta charset="UTF-8">
    <title>Reviews</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/fonts.css">
</head>
<body>

<div class="header">
    <div class="logo">Lorem Ipsum</div>
</div>


<div class="content">
    <?php
    $comments = $db->query('SELECT * FROM comments');
    while ($comment = $comments->fetch()) {
        ?>
        <div class="review">
            <div class="review_user">
                <span class="review_id">№<?= $comment["id"] ?></span>
                Name: <span class="review_name"><?= $comment["user_name"] ?></span>
                <span class="review_date"> <?= date("Y-m-d H:i:s", $comment["datetime"]); ?></span>
            </div>

            <div class="review_description">Tittle: <span class="review_tittle"><?= $comment["description"] ?></span></div>
            <div class="review_content"><p> <?= $comment["content"] ?></p></div>
            <?php
            if (file_exists($comment["image"])) {
                ?>
                <div class="image_wrapper">
                    <a target="_blank" rel="nofollow" href="<?= $comment["image"] ?>">
                        <img width="20%" height="20%" class="review_image" src="<?= $comment["image"] ?>">
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } ?>

</div>

<div class="form">
    <h1>Оставьте свой отзыв:</h1>
    <form name="comment" title="Оставьте свой отзыв">

        <div>
            <label>Enter your name:</label>
            <input required type="text" name="user_name" class="form_name">
        </div>

        <div>
            <label>Enter description your review:</label>
            <input required name="review_tittle" class="form_description">
        </div>

        <div>
            <label>Enter content your review:</label>
            <textarea required name="review_content" maxlength="500" class=""></textarea> <br>
        </div>

        <div>
            <label>Enter image:</label>
            <input name="image" type="file" class=""> <br>
        </div>

        <div>
            <button value="Go!">Отправить!</button>
        </div>

    </form>
</div>



<div class=" footer">


</div>

<div id="answer"></div>
</body>
<script src="js/main.js"></script>
</html>
