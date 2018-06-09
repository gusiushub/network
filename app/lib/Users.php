<?php
/**
 * Класс для работы с пользователями
 * */

namespace app\lib;

use app\core\Model;
use app\core\View;


class Users extends Model
{
    /**
     * пользователь по id
     * @param $id - пользователя
     * @return null
     */
    public function userId($id)
    {
        return $this->queryRow('SELECT * FROM users WHERE id=:id', array(':id' => $id));
    }

    /**
     * получить всех пользователей
     * @return array
     */
    public function getAllUsers()
    {
        return $this->queryRows("SELECT * FROM users ");
    }

    /**
     * регистрация пользователя
     * т.е. внесение данных в бд
     */
    public function signUp()
    {
        if ($this->checkRegisterForm()) {
            View::redirect('/');
            $this->insert('users', array(
                                                    'first_name' => $_POST['first_name'],
                                                    'last_name'  => $_POST['last_name'],
                                                    'email'      => $_POST['E-mail'],
                                                    'login'      => $_POST['login'],
                                                    'password'   => md5($_POST['password'])
            )); }
        else {
            echo 'Пользователь с e-mail '.$_POST['E-mail'].'уже существует';
        }
    }

    /**
     * проверка формы регистрации
     * */
    protected function checkRegisterForm()
    {
        $form = new Form;
        return $form->regValidate();
    }

    /**
     * @param $id
     * @return null
     */
    public function select($id)
    {
        return $this->queryRows('SELECT first_name FROM users WHERE id ='.$id);
    }

    /**
     * @param $user
     * определить сессию для пользователя
     */
    private function setUserSession($user)
    {
        $_SESSION['id']         = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['login']      = $user['login'];
        $_SESSION['active']     = 1;
        $_SESSION['authorize']  = 1;

    }

    /**
     * @return bool авторизация пользователя
     */
    public function login()
    {
        $user = $this->queryRow('SELECT * FROM users WHERE login = :login',
                                    array(':login' => htmlspecialchars($_POST['login'])));
        if(!empty($user)){
            if($user['password'] == null and $user['password']==''){
                echo 'Введите пароль';
            }elseif ($user['password'] == md5($_POST['password']) ){
                $this->setUserSession($user);
                $this->activeStatus();
                View::redirect('/user/'.$_SESSION['id']);
                return true;
            }
        }
    }

    /**
     * выход из акаунта
     */
    public function logout()
    {
        unset($_SESSION['first_name']);
        unset($_SESSION['login']);
        unset($_SESSION['avatar']);
        unset($_SESSION['authorize']);
        $_SESSION['active']=0;
        $this->activeStatus();
        unset($_SESSION['id']);
        View::redirect('/');
    }

    /**
     * статус онлайн/офлайн
     */
    protected function activeStatus()
    {
        $this->update('users', array('active' => $_SESSION['active']),
                         'id=:id', array(':id'    => $_SESSION['id']));
    }

    /**
     * добавить пользователя в друзья
     * @return null
     */
    public function addFriend()
    {
        return $this->insert('friends', array('user_id'   => $_SESSION['id'],
                                                       'friend_id' => $_GET['id']));
    }

    /**
     * @return null
     */
    public function getFriends()
    {
        return $this->queryRows('SELECT * FROM friends WHERE user_id='.htmlspecialchars($_GET['id']));
    }

    /**
     * @return null
     */
    public function findFriend()
    {
        return $this->queryRow('SELECT friend_id FROM friends WHERE friend_id='.$_GET['id'].' AND user_id='.$_SESSION['id']);
    }

    /**
     * @return mixed
     */
    public function getActiveStatus()
    {
        $status = $this->queryRow('SELECT active FROM users WHERE id=:id', array(':id' => $_GET['id']));
        return $status['active'];
    }

    /**
     * @return int число друзей
     */
    public function countFriends()
    {
        return count($this->getFriends());
    }

    /**
     * @return null
     */
    public function getSubscribers()
    {
        return $this->queryRows('SELECT * FROM friends WHERE friend_id='.$_GET['id']);
    }

    /**
     * подписки
     * @param $id
     * @return null
     */
    public function getSubscriptions($id)
    {
        return $this->queryRows('SELECT * FROM friends WHERE user_id='.$id);
    }

    /**
     * подписчика по id
     * @param $id
     * @return mixed
     */
    public function Subscribers($id)
    {
        return $this->queryRow("SELECT * FROM users WHERE id='".$id."'");
    }

    /**
     * кол-во подписчиков
     * @return int
     */
    public function countSubscribers()
    {
        return count($this->getSubscribers());
    }

    /**
     * название блога
     * @param $id
     * @return string
     */
    public function getBlogName($id)
    {
        return $this->queryRow('SELECT blog_name FROM users WHERE id=:id', array(':id'=>$id));
    }

    /**
     * @return mixed
     */
    public function updateBlogName()
    {
        return $this->update('users', array('blog_name' => htmlspecialchars($_POST['nameBlog'])), 'id=:id',
                                                                        array(':id' => $_SESSION['id']));
    }

}