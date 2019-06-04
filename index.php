<?php define('ROOT',dirname(__FILE__));?>
<?php include_once 'controllers/controller.php' ?>
<?php include_once 'view/header.php'?>

<?php if (isset($errors) && is_array($errors)): ?>
    <ul class="errors">
        <?php foreach ($errors as $error): ?>
            <li> - <?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<!--Form-->

<div class="container-add-comment row">
    <div class="col"></div>
    <div class="add-comment col-8">
        <form method="post" action="index.php" enctype="multipart/form-data">
            <div class="row form-slide">
                <label class="col">Введите ваше имя</label>
                <input class="col" type="text" name="userName" value="<?php echo $option['userName']?>" required>
                <div class="col"></div>
            </div>
            <div class="row form-slide">
                <label class="col">Введите ваш email</label>
                <input class="col" type="email" name="e_mail" value="<?php echo $option['e_mail']?>" required>
                <div class="col"></div>
            </div>
            <div class="row form-slide">
                <label class="col">Введите адрес вашей страницы</label>
                <input class="col" type="text" name="home_page" value="<?php echo $option['home_page']?>" >
                <div class="col"></div>
            </div>
            <div class="row form-slide">
                <div class="col">
                    <div class="g-recaptcha" data-sitekey="6Lepu6UUAAAAAE-YKhxU4x7JSoO57pxragHc4k7D"></div><br>
                </div>
                <div class="col"></div>
            </div>
            <div>
                <span>Файл:</span>
                <input type="file" name="image" placeholder="" value="">
            </div>
            <?php if ($_SESSION['commentId'] != 0 OR $_SESSION['commentId'] != false ): ?>
            <p>Ответ к: <?php echo Comments::getUserNameByID($_SESSION['commentId']);?> <a href="index.php?commentId=delete"><i class="fas fa-window-close"></i></a></p>
           <?php endif; ?>
            <hr>
            <span class="btn btn-outline-dark btn-i" onclick="document.getElementById('textarea1').value += '<i></i>'">i</span>
            <span class="btn btn-outline-dark" onclick="document.getElementById('textarea1').value += '<code></code>'">code</span>
            <span class="btn btn-outline-dark" onclick="document.getElementById('textarea1').value += '<strong></strong>'">strong</span>
            <span class="btn btn-outline-dark" onclick="document.getElementById('textarea1').value += '<a href=&quot&quot title=&quot&quot></a>'">a</span>
            <textarea id="textarea1" class="textarea" name="message" value="" required><?php echo $option['text']?></textarea><br>
            <input type="submit" value="submit" name="submit">
            <span class="btn btn-outline-dark btn-show" >Показать сообщение</span>
            <p class="visible1 form-message"></p>
        </form>
    </div>
    <div class="col"></div>
</div>


    <!--Sort-->
<div class="comments">

        <div class="full-comment row" >
            <div class="col"></div>
            <div class="comment col-8">
                <div class="comment-head row">
                    <div class="col"> <a href="index.php?sort=name">Имя</a></div>
                    <div class="col"> <a href="index.php?sort=e_mail">Имаил</a></div>
                    <div class="col"> <a href="index.php?sort=c_date">Дата</a></div>
                </div>
            </div>
            <div class="col"></div>
        </div>
</div>

    <!--Comments-->
<div class="comments">

    <?php foreach ($allComments as $comment): ?>
    <div class="full-comment row" >
        <div class="col"></div>
        <div class="comment col-8">
            <div class="comment-head row">
                <p class="col"><?php echo $comment['name'];?></p>
                <p class="col"><?php echo $comment['e_mail'];?></p>
                <p class="col"><?php echo $comment['c_date'];?>
                </p>
            </div>
            <div class="comment-text" >
                <p><?php echo $comment['text'];?></p>
                <?php if (is_file('upload/images/'.$comment['id'].'.'.$comment['img_type'])): ?>
                    <button class="btn btn-info">Файл:</button><br>
                    <?php if ($comment['img_type'] == 'txt'): ?>
                        <pre class="media-file visible1"> <?php echo file_get_contents('upload/images/'.$comment['id'].'.'.$comment['img_type'])?></pre>
                    <?php else: ?>
                         <img class="media-file visible1" src="<?php echo 'upload/images/'.$comment['id'].'.'.$comment['img_type']; ?>" width="320" height="240" alt="lorem"><br>
                    <?php endif; ?>
                 <?php endif; ?>
                <a href="index.php?commentId=<?php echo $comment['id']?>">Ответить</a>
                <?php $rep->showReplies($comment['id'], $allReplies); ?>
            </div>
        </div>
        <div class="col"></div>
    </div>
    <?php endforeach; ?>

    <!--Navigation-->

    <div class="comments">

        <div class="full-comment row" >
            <div class="col"></div>
            <div class="comment col-8">
                <div class="comment-head row">
                    <a href="index.php?page=prev" class="col">Предыдущая страница</a>
                    <p class="col">Текущая страница:<?php echo ' '.(($_SESSION['page']/ Comments::$SHOW_COMMENTS_BY_DEFAULT)+1);?></p>
                    <a href="index.php?page=next" class="col">Следующая страница</a>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

<?php include_once 'view/footer.php'?>