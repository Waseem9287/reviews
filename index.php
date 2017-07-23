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
    while ($comment = $comments->fetch()) :
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
            if (file_exists($comment["image"])) :
                ?>
                <div class="image_wrapper">
                    <a target="_blank" rel="nofollow" href="<?= $comment["image"] ?>">
                        <img width="20%" height="20%" class="review_image" src="<?= $comment["image"] ?>">
                    </a>
                </div>
                <?php
            endif;
            ?>
        </div>
        <?php
    endwhile; ?>

</div>

<div class="form">
    <h1>Оставьте свой отзыв:</h1>
    <h2 id="response"></h2>
    <form name="comment" title="Оставьте свой отзыв">
        <div class="review">

        <div class="form_user">
            <div class="review_name">
                <div>
                    <label>Name:</label>
                    <input required type="text" name="user_name" class="form_name">
                </div>
            </div>
        </div>

        <div class="review_description">
            <div>
                <label>Title:</label>
                <input required name="review_tittle" class="form_description">
            </div>
        </div>

        <div class="form_content">
            <div>
            <label>Content: <br></label>
            <span id="areaLetters">500</span>
            <textarea data-countchar="" data-countchar-limit="15" required name="review_content" maxlength="500" ></textarea>

            </div>
        </div>

        <div class="file_upload">
            <button type="button">Выбрать</button>
            <div>Вы можете прекрепить картинку</div>
            <input name="image" class="form_image" type="file">
        </div>

        <div class="form_captcha">
            <div data-theme="dark" class="g-recaptcha" data-sitekey="6LdwGCoUAAAAAOseGy7rz2CAASY9wUAdQkSIO1sW">
            </div>
        </div>
        <div class="form_submit">
            <button type="submit">Отправить</button>
        </div>

        </div>
    </form>

</div>
<script src="js/main.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>
