<?php

/*
 * write in session next page
 */
class Pagination
{
    public static function getCurrentPage($action){
        if ($_SESSION['page'] == false){
            $_SESSION['page'] =0;
        }
        $max = Comments::countAllComments();
        $limit = Comments::$SHOW_COMMENTS_BY_DEFAULT;
        if ($action == 'next'){
            if ($_SESSION['page']+$limit < $max){
                $_SESSION['page'] = (int)$_SESSION['page'] + $limit;
            }
            header("Location: /");
        }elseif ($action == 'prev'){
            if($_SESSION['page']-$limit >= 0){
                $_SESSION['page'] = (int)$_SESSION['page'] - $limit;
            }
            header("Location: /");
        }
    }
}