<?php
session_start();
include_once ROOT.'/components/Db.php';
include_once ROOT.'/components/Replies.php';
include_once ROOT.'/components/Pagination.php';
include_once ROOT.'/components/Browser.php';
include_once ROOT.'/components/Sort.php';
include_once ROOT.'/components/recaptchalib.php';
include_once ROOT . '/model/Comments.php';

/*
 * pagination and sorting
 */
$sort = htmlspecialchars($_GET['sort']);
$page = htmlspecialchars($_GET['page']);
Pagination::getCurrentPage($page);
Sort::getCurrrentSort($sort);

/*
 * set and unset reply for form
 */
$commentId = htmlspecialchars($_GET['commentId']);
if ($commentId == 'delete'){
    $_SESSION['commentId'] = 0;
}elseif ($commentId != false){
    $_SESSION['commentId'] = $commentId;
}

/*
 * get all comments with replies
 */
$allComments = Comments::getAllComments();
$commentIds = [];
foreach ($allComments as $comment){
    array_push($commentIds,$comment['id']);
}
$allReplies = Comments::getCommentsRepliesByCommentId($commentIds);
$rep = new Replies();


/*
 * action - form
 */
$option['userName'] = false;
$option['e_mail'] = false;
$option['parent_id'] = false;
$option['path'] = false;
$option['home_page'] = false;
$option['text'] = false;
$option['ip'] = false;
$option['brouser'] = false;
if (isset($_POST['submit'])){
    $secret = "6Lepu6UUAAAAALCretJOuNE0qCJSg6vugXCi3MkZ";
    $response = null;
    $reCaptcha = new ReCaptcha($secret);
    $errors = false;

    /*
     * options from form
     */
    $option['userName'] = htmlspecialchars($_POST['userName']);
    $option['e_mail'] = htmlspecialchars($_POST['e_mail']);
    $option['home_page'] = htmlspecialchars($_POST['home_page']);
    $option['text'] = $_POST['message'];
    $option['ip'] = $_SERVER['REMOTE_ADDR'];
    $option['brouser'] = Browser::get_user_browser();

    /*
     * verify user data
     */
    if ($_POST["g-recaptcha-response"]) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }
    if (!($response != null && $response->success)) {
        $errors[] = 'ReCaptcha не пройдена';
    }

    if ($option['userName'] == false){
        $errors[] = 'Введите Имя';
    } elseif (strlen( $option['userName']) > 30 ){
        $errors[] = 'Слишком длинное имя';
    } elseif (!ctype_alnum($option['userName'])){
        $errors[] = 'Недопустимый символ в имени';
    }
    if (!filter_var($option['e_mail'],FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Неправильный email';
    }
    if ($option['home_page'] != false){
        if (!get_headers($option['home_page'], 1)){
            $errors[] = 'Неправильный адрес страницы';
        }
    }
    if ($option['text'] == false){
        $errors[] = 'Пустое текстовое сообщение';
    }

    /*
     * verify image and text file
     */

    $imgType = false;
    if(isset($_FILES['image'])){

        $file =$_FILES['image'];
        $getMime = explode('.', $file['name']);
        $imgType = strtolower(end($getMime));
        $types = array('jpg', 'png', 'gif','txt');

        if(!in_array($imgType, $types) AND $imgType){
            $errors[] = 'Недопустимый формат файла, используйте: jpg, png, gif, txt';
        }
        if ($imgType == 'txt' AND $imgType){
            if($_FILES["image"]["size"] > 100000){
                $errors[] = 'Слишком большой размер файла, макс размер- 100кб';
            }
        }
    }

    /*
     * supporting options for database
     */
    if($_SESSION['commentId'] == false){
        $option['parent_id'] = 0;
        $option['path'] = 0;
    }else{
        $currentComment = Comments::getCommentByID($_SESSION['commentId']);
        $option['parent_id'] = $currentComment['parent_id'];
        $option['path'] = Comments::findPath($currentComment['path']);;
        if ($option['parent_id'] == false ){
            $option['parent_id'] = $_SESSION['commentId'];
        }
    }

    /*
     * if there are no errors, then write to the database
     */
    if ($errors == false){
        $option['imgType'] = $imgType;
        $option['text'] = str_replace("\n", '<br>', $option['text']);
        $commentId = Comments::addComment($option);
        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/$commentId.$imgType");
        }

        $_SESSION['commentId'] = false;
        header("Location: /");
    }
}


?>