<?php
/*
 * show all replies for comments
 */


class Replies
{
    var $resllt = '';
    var $i =0;
    /*
     * get and sort all replies
     */
    public function showReplies($id, $allReplies){
        $this->resllt = '';
        $currentReplies = false;

        for ($i =0 ; $i< count($allReplies); $i++){
            if ($allReplies[$i]['parent_id'] == $id){
                $currentReplies[$i]['path'] = explode ('.' ,$allReplies[$i]['path']);
                $currentReplies[$i]['parent_id'] = $allReplies[$i]['parent_id'];
                $currentReplies[$i]['name'] = $allReplies[$i]['name'];
                $currentReplies[$i]['text'] = $allReplies[$i]['text'];
                $currentReplies[$i]['c_date'] = $allReplies[$i]['c_date'];
                $currentReplies[$i]['path2'] = $allReplies[$i]['path'];
                $currentReplies[$i]['e_mail'] = $allReplies[$i]['e_mail'];
                $currentReplies[$i]['id'] = $allReplies[$i]['id'];
                $currentReplies[$i]['img_type'] = $allReplies[$i]['img_type'];
            }
        }

        if ($currentReplies != false){
            foreach($currentReplies as $element) {
                if(!empty($element)){
                    $currentReplies2[] = $element;
                }
            }
            $this->addReply($currentReplies2, $this->i);
        }

        return $currentReplies2;
    }

    /*
     * return html file with all replies
     */

    public function addReply($currentReplies, $i){
        for (; $i<count($currentReplies); $i++){
        $this->resllt = $this->resllt. '<div class="comment-text col-12">'.
                        '<div class="comment-head row">'.
                            '<p class="col">'.$currentReplies[$i]['name'].'</p>'.
                            '<p class="col">'.$currentReplies[$i]['e_mail'].'</p>'.
                                '<p class="col">'.$currentReplies[$i]['c_date'].'</p>'.
                                    '</div>'.
                                        '<p>'.$currentReplies[$i]['text'].'</p>';
        if (is_file('upload/images/'.$currentReplies[$i]['id'].'.'.$currentReplies[$i]['img_type'])){
            $this->resllt = $this->resllt.'<button class="btn btn-info">Файл:</button><br>';
            if ($currentReplies[$i]['img_type'] == 'txt'){
                $this->resllt = $this->resllt.'<pre class="media-file visible1">'.file_get_contents('upload/images/'.$currentReplies[$i]['id'].'.'.$currentReplies[$i]['img_type']).'</pre>';

            }else{
                $this->resllt = $this->resllt.'<img class="media-file visible1" src="upload/images/'.$currentReplies[$i]['id'].'.'.$currentReplies[$i]['img_type'].'" width="320" height="240" alt="lorem"><br>';
            }

        }

            $this->resllt = $this->resllt . '<a href="../index.php?commentId='.$currentReplies[$i]['id'].'">Ответить</a>';

            if (count($currentReplies[$i+1]['path']) == false){
                $this->resllt = $this->resllt.'</div>';
            }
            if (count($currentReplies[$i+1]['path']) > count($currentReplies[$i]['path'])){

            } elseif (count($currentReplies[$i+1]['path']) == count($currentReplies[$i]['path'])){
                $this->resllt = $this->resllt.'</div>';

            }elseif (count($currentReplies[$i+1]['path']) < count($currentReplies[$i]['path']) and count($currentReplies[$i+1]['path']) !=0){
                $j = count($currentReplies[$i]['path']) - count($currentReplies[$i+1]['path'])+1;
                for ($k=0; $k<$j;$k++){
                    $this->resllt = $this->resllt.'</div>';
                }
            }elseif (count($currentReplies[$i+1]['path']) ==0 AND count($currentReplies[$i]['path']) !=1){
                $j = count($currentReplies[$i]['path'])-1;
                for ($k=0; $k<$j;$k++){
                    $this->resllt = $this->resllt.'</div>';
                }
            }
        }
        echo $this->resllt;
    }
}