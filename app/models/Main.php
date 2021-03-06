<?php

namespace app\models;

use app\core\Model;
use app\lib\Article;
use app\lib\Comment;
use app\lib\Files;
use app\lib\Form;
use app\lib\Users;
use app\lib\Message;


class Main extends Model
{
    private $user;
    private $file;
    private $form;
    private $article;
    private $message;
    private $comment;

    public function __construct()
    {
        $this->user    = new Users;
        $this->file    = new Files;
        $this->form    = new Form;
        $this->article = new Article;
        $this->message = new Message;
        $this->comment = new Comment;
    }

    /**
     * @param $id
     * @return \app\lib\пользователь
     */
    public function userId($id)
    {
        return $this->user->userId($id);
    }

    /**
     * авторизация
     */
    public function login()
    {
        $this->user->login();
    }

    /**
     * выход из аккаунта
     */
    public function logout()
    {
        $this->user->logout();
    }

    /**
     * загрузка файла
     * */
    public function upLoadFile()
    {
        return $this->file->upLoad();
    }

    /**
     * @param $filename
     * @return mixed
     */
    public function updateAvatar($filename)
    {
        return $this->file->updateAvatar($filename);
    }

    /**
     * @return null
     */
    public function userPosts()
    {
        return $this->article->userPosts();
    }

    /**
     * @return null
     */
    public function post()
    {
        return $this->article->post();
    }

    /**
     * Регистрация
     */
    public function signUp()
    {
        $this->user->signUp();
    }

    /**
     * @return mixed
     */
    public function activeStatus()
    {
        return $this->user->getActiveStatus();
    }

    /**
     * добавить друга
     * @return null
     */
    public function addFriend()
    {
        return $this->user->addFriend();
    }

    /**
     * вывести друзей
     * @return null
     */
    public function getFriends()
    {
        return $this->user->getFriends();
    }

    /**
     * найти друга
     * @return null
     */
    public function findFriend()
    {
        return $this->user->findFriend();
    }

    /**
     * кол-во друзей
     * @return int
     */
    public function countFriends()
    {
        return $this->user->countFriends();
    }

    /**
     * изменить название блога
     * @return mixed
     */
    public function updateBlogName()
    {
        return$this->user->updateBlogName();
    }

    /**
     * @return null
     */
    public function getSubscribers()
    {
        return $this->user->getSubscribers();
    }

    /**
     * @return int
     */
    public function countSubscribers()
    {
        return count($this->user->getSubscribers());
    }

    /**
     * @param $id
     * @return null
     */
    public function Subscribers($id)
    {
        return $this->user->Subscribers($id);
    }

    /**
     * получить подписки
     * @param $data
     * @return \app\lib\
     */
    public function getSubscriptions($data)
    {
        return $this->user->getSubscriptions($data);
    }

    /**
     * прочитать сообщение
     */
    public function readMessage()
    {
         $this->message->readMessage();
    }

    /**
     * отправить сообщение
     */
    public function sendMessage()
    {
         $this->message->sendMessage();
    }

    /**
     * кому(сообщение)
     */
    public function toUserMsg()
    {
        $this->message->toUserMsg();
    }

    /**
     * от кого (смс)
     */
    public function msgForUser()
    {
         $this->message->forUser();
    }

    /**
     * @param $id
     * @return null
     */
    public function select($id)
    {
        return $this->user->select($id);
    }

    /**
     * delete post
     *
     * @param $id
     */
    public function deletePost($id)
    {
         $this->article->delPost($id);
    }

    /**
     * возвращает название блога
     *
     * @param $id
     * @return string
     */
    public function getBlogName($id)
    {
        return $this->user->getBlogName($id);
    }

    /**
     * @return array получить всех юзеров
     */
    public function allUsers()
    {
        return $this->user->getAllUsers();
    }

    /**
     * @param $mes
     */
    public function textMsg($mes)
    {
        $this->message->textMsg($mes);
    }

    /**
     * вывести диалог
     * @return mixed
     */
    public function getDialog()
    {
        return $this->message->getDialog();
    }

    /**
     *
     */
    public function restore()
    {
        $this->mail->restore();
    }

    public function addComment($postId)
    {
        $this->comment->addComment($postId);
    }

    public function getLike($post_id)
    {
         $this->article->getLike($post_id);
    }

    public function setLike()
    {
        $this->article->setLike($_GET['id']);
        echo json_encode(array('result' => 'success'));
    }

    public function getComment($post_id)
    {
        return $this->comment->userComment($post_id);
    }

    public function find($query)
    {

    }

    public function pagination($start,$limit,$order,$postId)
    {
        return $this->comment->pagination($start,$limit,$order,$postId);
    }
}