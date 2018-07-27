<?php


namespace app\models;


use app\core\Model;

class Event extends Model
{
    public function getLike($post_id)
    {
        return $this->queryRows('SELECT likes FROM posts WHERE id=:post_id', array('post_id' => $post_id));
    }

    public function setLike($post_id)
    {
        $likes = $this->getLike($post_id);
        $like = (int)$likes[0]['likes']+1;
        $this->update('posts', array('likes'=>$like),'id=:post_id', array(':post_id' => $post_id));
    }

    public function scroll()
    {

    }
}