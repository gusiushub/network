<?php
namespace app\controllers;

use app\core\Controller;
use app\lib\Message;


class EventController extends Controller
{
    //public $message;

    public function __construct()
    {
        //$this->message = new Message;
    }

    public function rightscrollAction()
    {

    }

    public function leftscrollAction()
    {

    }

    public function likeAction()
    {
        $this->model->setLike($_GET['id']);
    }

    public function smsAction()
    {
        $this->model->sendMessage($_POST['message']);
    }
}