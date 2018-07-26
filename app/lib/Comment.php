<?php

namespace app\lib;

use app\core\Model;
use app\core\View;

class Comment extends Model
{
    /**
     * @param $postId
     * @return null
     */
    public function addComment($postId)
    {
        if (isset($_POST['commentButton_'.$postId])) {
            return $this->insert('comments', array('user_id'   => $_SESSION['id'],
                                                            'post_id' => $postId,
                                                            'text'    => htmlspecialchars($_POST['commentText'])));
            View::redirect('/user/'.$_GET['id']);
        }
    }

    /**
     * @param $postId
     * @return null
     */
    public function userComment($postId)
    {
        return $this->queryRows('SELECT * FROM comments WHERE post_id=:post_id
                                            ORDER BY id DESC', array('post_id' => $postId));
    }

    public function pagination($start,$limit,$order,$postId)
    {
        return $this->queryRows('select * from comments where post_id=:post_id order by '.$order.' DESC limit '.$start.' , '.$limit,array('post_id'=>$postId));
    }
}