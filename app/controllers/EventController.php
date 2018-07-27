<?php
namespace app\controllers;

use app\core\Controller;


class EventController extends Controller
{
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
}