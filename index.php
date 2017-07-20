<?php
require_once "db_init.php";
?>
<html lang="Ruru">
<head>
    <meta charset="UTF-8">
    <title>Reviews</title>
</head>
<body>

<div class="header">
    <div class="nav-wrapper">
        <div class="nav-menu">
            <ul>
                <li><a href="#site">Site</a></li>
                <li><a href="#history">About Site</a></li>
                <li><a href="#reviews">Reviews</a></li>
            </ul>
        </div>
    </div>
    <div class="logo">Lorem Ipsum</div>
</div>

<div id="site" class="content">


</div>


<div class="footer">


</div>









<div class="reviews">
<?php

$comments = $db->query('SELECT * FROM comments');
while ($comment = $comments->fetch())
{?>

    <div>
        <span>№<?= $comment["id"] ?></span>
        <span><?= $comment["user_name"] ?></span>
    </div>

    <div>
        <span><?= date("Y-m-d H:i:s", $comment["datetime"]); ?></span>
    </div>

    <div><?= $comment["name"] ?></div>
    <div><?= $comment["description"] ?></div>
    <?php
    if (file_exists($comment["image"]))
    {
        ?>
        <img src="<?= $comment["image"] ?>">
        <?php
    }
        ?>
<?php
} ?>

</div>

<form name="comment" title="Оставьте свой отзыв">

    <div>
        <label>Enter your name:</label>
        <input required type="text" name="user_name" class=""><br>
    </div>

    <div>
        <label>Enter description your review:</label>
        <input required name="review_tittle" class=""><br>
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
        <button  value="Go!"> asdasd as</button>
    </div>

</form>

<div id="answer"></div>
</body>
<script src="js/main.js"></script>
</html>
