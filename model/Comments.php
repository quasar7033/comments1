<?php
/*
 * model for table all_comments
 */
class Comments{
    /*
     * comments on the page
     */
    static $SHOW_COMMENTS_BY_DEFAULT =25;

    /*
     * add new comment
     */

    public static function addComment($option){
        $db = Db::getConnection();

        $sql = 'INSERT INTO all_comments (parent_id, path, name, e_mail, home_page, text, ip, brouser, img_type) VALUES (:parent_id, :path, :name, :e_mail,:home_page, :text, :ip, :brouser, :img_type)';
        $result = $db->prepare($sql);

        $result->bindParam(':parent_id',  $option['parent_id'], PDO::PARAM_STR);
        $result->bindParam(':path',  $option['path'], PDO::PARAM_STR);
        $result->bindParam(':name',  $option['userName'], PDO::PARAM_STR);
        $result->bindParam(':e_mail',  $option['e_mail'], PDO::PARAM_STR);
        $result->bindParam(':home_page',  $option['home_page'], PDO::PARAM_STR);
        $result->bindParam(':text',  $option['text'], PDO::PARAM_STR);
        $result->bindParam(':ip',  $option['ip'], PDO::PARAM_STR);
        $result->bindParam(':brouser',  $option['brouser'], PDO::PARAM_STR);
        $result->bindParam(':img_type',  $option['imgType'], PDO::PARAM_STR);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    /*
     * get all comments for single page
     */

    public static function getAllComments(){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM all_comments WHERE parent_id = 0 ORDER BY '.$_SESSION['actualSort'].' LIMIT '.self::$SHOW_COMMENTS_BY_DEFAULT.' OFFSET '.$_SESSION['page'];
        $result = $db->prepare($sql);
        $result->execute();

        $i =0;
        $allComments = array();
        while($row = $result->fetch()){
            $allComments[$i]['id'] =$row['id'];
            $allComments[$i]['name'] =$row['name'];
            $allComments[$i]['text'] =$row['text'];
            $allComments[$i]['c_date'] =$row['c_date'];
            $allComments[$i]['e_mail'] =$row['e_mail'];
            $allComments[$i]['path'] =$row['path'];
            $allComments[$i]['parent_id'] =$row['parent_id'];
            $allComments[$i]['img_type'] =$row['img_type'];
            $i++;
        }
        return $allComments;
    }

    /*
     * get all replies for comments
     */

    public static function getCommentsRepliesByCommentId($commentsIds){
        $commentsIds = implode(',',$commentsIds);
        $db = Db::getConnection();
        $sql = "SELECT * FROM all_comments WHERE parent_id IN ($commentsIds) ORDER BY path" ;
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        $replies = array();
        while ($row = $result->fetch()) {
            $replies[$i]['id'] =$row['id'];
            $replies[$i]['name'] =$row['name'];
            $replies[$i]['text'] =$row['text'];
            $replies[$i]['c_date'] =$row['c_date'];
            $replies[$i]['path'] =$row['path'];
            $replies[$i]['parent_id'] =$row['parent_id'];
            $replies[$i]['e_mail'] =$row['e_mail'];
            $replies[$i]['img_type'] =$row['img_type'];
            $i++;
        }
        return $replies;
    }

    /*
     * return amount of all comments in database
     */
    public static function countAllComments(){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM all_comments WHERE parent_id = 0';
        $result = $db->prepare($sql);
        $result->execute();

        $i =0;
        while($row = $result->fetch()){
            $i++;
        }
        return $i;

    }

    /*
     * return user name by comment id
     */

    public static function getUserNameByID($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM all_comments WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();

        $row = $result->fetch();
        return $row['name'];
    }

    /*
     * return comment by comment id
     */

    public static function getCommentByID($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM all_comments WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();

        return  $result->fetch();
    }

    /*
     * return path by comment id
     * or false if nothing found
     */

    public static function findPath($path){
        $res = '';
        $db = Db::getConnection();
        $i =0;
        $flag = true;
        while ($flag){
            $i++;
            if ($path == false){
                $res = $i;
            }else{
                $res = $path.'.'.$i;
            }
            $sql = 'SELECT * FROM all_comments WHERE path = :path';
            $result = $db->prepare($sql);
            $result->bindParam('path', $res, PDO::PARAM_STR);
            $result->execute();
            $coment = $result->fetch();
            if (!$coment){
                $flag = false;
            }
        }
        return $res;
    }
}


?>