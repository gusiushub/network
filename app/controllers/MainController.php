<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Авторизация', $vars);
    }

    public function dialogAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Диалоги', $vars);
    }

    public function aboutAction()
    {
        $this->view->render('О нас');
    }

    public function feedbackAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Обратная связь', $vars);
    }

    public function chatAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Диалоги', $vars);
    }

    public function registerAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Регистрация', $vars);
    }

    public function userAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Профиль', $vars);
    }

    public function subscriptionsAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Подписки', $vars);
    }

    public function subscribersAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Подписчики', $vars);
    }

    public function editAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Ред. профиль', $vars);
    }

    public function logoutAction()
    {
        $this->model->logout();
    }

    public function allAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Пользователи', $vars);
    }

    public function contactAction()
    {
        $this->view->render('Контакты');
    }

    public function restoreAction()
    {
        $vars = ['model' => $this->model];
        $this->view->render('Смена пароля', $vars);
    }

    public function commentAction()
    {
//        $model = new Main;
//        $model->comment();
    }

    public function likeAction()
    {
        $this->model->setLike($_GET['id']);
    }
}
