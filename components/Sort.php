<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.05.2019
 * Time: 16:58
 */
class Sort
{
    /*
     * sort for comments
     */

    public static function getCurrrentSort($sort){
        if ($_SESSION['actualSort'] == false OR $sort == 'id'){
            $_SESSION['actualSort'] = 'id';
        }elseif ($_SESSION['actualSort'] == $sort){
            $_SESSION['actualSort'] = $_SESSION['actualSort'].' DESC';
            header("Location: /");
        }elseif($sort == false){

        }else{
            $_SESSION['actualSort'] = $sort ;
            header("Location: /");
        }
    }

}