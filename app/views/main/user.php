<?php

use app\core\View;

$user = $vars['model']->userId(htmlspecialchars($_GET['id']));

if(isset($_POST['post'])){
    $vars['model']->post();
    View::redirect('/user/'.$_SESSION['id']);
}

if(isset($_POST['addFriend'])){
        $vars['model']->addFriend();
        View::redirect('/user/'.$_GET['id']);
}
$comment = $vars['model']->pagination(8,3,3,37);
//var_dump($vars['model']->pagination(8,3,3,37));
$model = $vars['model'];
?>
<div id="main">
    <div class="container">
        <div class="row">
            <!-- About Me (Left Sidebar) Start -->
            <div class="col-md-3">
                <div class="about-fixed">
                    <div class="my-pic">
                        <?php if($user['avatar']==''){ ?>
                        <img height="350px" src="../../../public/avatar_none.png" alt="">
                        <?php } else{ ?>
                        <img height="350px" src="../../../public/avatars/<?php echo $user['avatar'] ?>" alt="">
                        <?php } ?>
                        <a href="javascript:void(0)" class="collapsed" data-target="#menu" data-toggle="collapse"><i class="icon-menu menu"></i></a>
                        <div id="menu" class="collapse">
                            <ul class="menu-link">
                                <li><a href="about.html">About</a></li>
                                <li><a href="work.html">Work</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="my-detail">
                        <div class="white-spacing">
                            <?php if($vars['model']->activeStatus()==1) { ?>
                            <small>Online</small>
                            <?php } else { ?>
                            <small>Offline</small>
                            <?php } ?>
                            <h1><?php echo $user['first_name'].' '.$user['last_name']; ?></h1>
                            <?php if($_SESSION['id']!=$_GET['id']) { ?>
                           <form method="POST">
                               <button name="sms" class="btn btn-primary" type="submit" href="#"><a href="/dialog/<?php echo $_GET['id'];?>/">Написать</a></button>
                               <?php
                               $findFriend = $vars['model']->findFriend();
                               if($findFriend==false){ ?>
                               <input type="submit" href="#" name="addFriend" class="btn btn-primary" value="Подписаться">
                               <?php } ?>
                           </form>
                            <?php } ?>
                            <?php if($_SESSION['id']==$_GET['id']) { ?>
                            <small><a class="btn btn-outline-light" href="/edit/">Редактировать профиль</a> </small>
                            <?php } ?>
                                <br><small><a href="/subscribers/<?php echo $_GET['id']; ?>" >Подписчики</a> </small> (<?php echo $vars['model']->countSubscribers(); ?>)
                                <br><small><a href="/subscriptions/<?php echo $_GET['id']; ?>">Подписки</a> </small> (<?php echo $vars['model']->countFriends(); ?>)
                        </div>
                        <ul class="social-icon">
                            <li><a href="#" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#" target="_blank" class="github"><i class="fa fa-github"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- About Me (Left Sidebar) End -->
            <!-- Blog Post (Right Sidebar) Start -->
            <div class="col-md-9">
                <div class="col-md-12 page-body">
                    <div class="row">
                        <div class="sub-title">
                                <?php $blogName = $vars['model']->getBlogName($_GET['id']);?>
                            <ul style="float: left">
                                <h3>Основная информация:</h3><hr>
                                <li>Страна:</li>
                                <li>Город:</li>
                                <li>Дата рождения:</li>
                            </ul>

                            <a href="/dialog"><i class="icon-envelope"></i></a>
                        </div>
                        <!-- Blog Post Start -->
                        <?php if($_SESSION['id'] == $_GET['id']) { ?>
<!--                        <div class="container">-->
                        <form class="form-control" method="POST">
                            <input type="text" class="form-control" name="title" placeholder="Заголовок">
                            <p> <textarea type="text" class="form-control" name="content" placeholder="Контент"></textarea></p>
                            <p>
                                <input type="file"  name="postFile" style="float: left">
                                <input type="submit" class="btn btn-primary" name="post" style="float: right;" value="Опубликовать">
                            </p>
                        </form>
                        <?php } ?>
                        <h1 class="display-2"><?php echo $blogName['blog_name'] ;?></h1>
                        <div class="col-md-12 content-page">
                            <?php
                            $postVar = $vars['model'];
                            $vars = $vars['model']->userPosts();
                            //$likes = $var['model']->getLike($id);
                            foreach($vars as $var){
                                if($_GET['id'] == $_SESSION['id']) {
                                    if (isset($_POST['del'.$var['id']])) {
                                        $postVar->deletePost($var['id']);
                                        View::redirect('/user/' . $_SESSION['id']);
                                    }
                                } ?>
                                <input type="hidden" value="<?php echo $var['id'] ;?>" id="post_id">
                                <div class="post-title">
                                    <a href="#"><h1><?php  echo $var['title'];?></h1></a>
                                </div>
                                <div class="post-info">
                                    <span><?php echo $var['date']; ?>/ by <a href="#" target="_blank"><?php echo $user['first_name'].' '.$user['last_name'] ?></a></span>
                                    <br>
<!--                                    <br>-->
                                </div>
                                <p class="text-center" ><?php echo $var['content']; ?></p>
                                <?php if($_SESSION['id'] == $_GET['id']) { ?>
                                <form method="POST">
                                    <input name="<?php echo 'del'.$var['id']?>" class="btn-link" type="submit" value="Удалить" style="float: right;">
                                </form>
                                <?php } ?>
                                <?php $postVar->addComment($var['id']); ?>
                                <div class="like btn-link"  id="<?php echo 'like'.$var['id']; ?>">Like[<b  id="<?php echo 'likes'.$var['id']; ?>"><?php  echo $var['likes']; ?></b>]</div>

                                <link rel="stylesheet" href="http://bootstraptema.ru/plugins/2015/bootstrap3/bootstrap.min.css" />
                                <link rel="stylesheet" href="http://bootstraptema.ru/plugins/font-awesome/4-4-0/font-awesome.min.css" />

                                <style>
                                    body{background:url(/images/bg/bg-1.png)}

                                    .img-sm {
                                        width: 46px;
                                        height: 46px;
                                    }
                                    .panel {
                                        box-shadow: 0 2px 0 rgba(0,0,0,0.075);
                                        border-radius: 0;
                                        border: 0;
                                        margin-bottom: 15px;
                                    }
                                    .panel .panel-footer, .panel>:last-child {
                                        border-bottom-left-radius: 0;
                                        border-bottom-right-radius: 0;
                                    }
                                    .panel .panel-heading, .panel>:first-child {
                                        border-top-left-radius: 0;
                                        border-top-right-radius: 0;
                                    }
                                    .panel-body {
                                        padding: 25px 20px;
                                    }
                                    .media-block .media-left {
                                        display: block;
                                        float: left
                                    }
                                    .media-block .media-right {
                                        float: right
                                    }
                                    .media-block .media-body {
                                        display: block;
                                        overflow: hidden;
                                        width: auto
                                    }
                                    .middle .media-left,
                                    .middle .media-right,
                                    .middle .media-body {
                                        vertical-align: middle
                                    }
                                    .thumbnail {
                                        border-radius: 0;
                                        border-color: #e9e9e9
                                    }
                                    .tag.tag-sm, .btn-group-sm>.tag {
                                        padding: 5px 10px;
                                    }
                                    .tag:not(.label) {
                                        background-color: #fff;
                                        padding: 6px 12px;
                                        border-radius: 2px;
                                        border: 1px solid #cdd6e1;
                                        font-size: 12px;
                                        line-height: 1.42857;
                                        vertical-align: middle;
                                        -webkit-transition: all .15s;
                                        transition: all .15s;
                                    }
                                    .text-muted, a.text-muted:hover, a.text-muted:focus {
                                        color: #acacac;
                                    }
                                    .text-sm {
                                        font-size: 0.9em;
                                    }
                                    .text-5x, .text-4x, .text-5x, .text-2x, .text-lg, .text-sm, .text-xs {
                                        line-height: 1.25;
                                    }
                                    .btn-trans {
                                        background-color: transparent;
                                        border-color: transparent;
                                        color: #929292;
                                    }
                                    .btn-icon {
                                        padding-left: 9px;
                                        padding-right: 9px;
                                    }
                                    .btn-sm, .btn-group-sm>.btn, .btn-icon.btn-sm {
                                        padding: 5px 10px !important;
                                    }
                                    .mar-top {
                                        margin-top: 15px;
                                    }
                                </style>

                                <section class="container">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="panel">
                                                <form id="<?php echo 'commentButtonForm'.$var['id']; ?>" class="commentButtonForm" method="POST" action="">
                                                <div class="panel-body">
                                                    <textarea id="commentText"  class="form-control" rows="2" placeholder="Добавьте Ваш комментарий" name="commentText"></textarea>
                                                    <div class="mar-top clearfix">
                                                        <input id="<?php echo 'commentBut'.$var['id']; ?>" name="<?php echo 'commentButton_'.$var['id']; ?>" class="btn btn-sm btn-primary pull-right" type="submit">
                                                        <a class="btn btn-trans btn-icon fa fa-video-camera add-tooltip" href="#"></a>
                                                        <a class="btn btn-trans btn-icon fa fa-camera add-tooltip" href="#"></a>
                                                        <a class="btn btn-trans btn-icon fa fa-file add-tooltip" href="#"></a>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-body">
                                                <?php
                                                $commentCount = $model->getComment($var['id']);
                                                $commentCount = count($commentCount);
                                                $commentId = $var['id'];
                                                //var_dump($commentCount);
                                                if ($commentCount>3) {
                                                    for ($i = 0; $i < 3; $i++) {
                                                        $comment = $model->pagination(3, 3, 3, $commentId);
                                                        //var_dump($comment);
                                                        ?>
                                                        <div class="media-block">
                                                            <a class="media-left" href="#"><img
                                                                        class="img-circle img-sm"
                                                                        alt="Профиль пользователя"
                                                                        src="http://bootstraptema.ru/snippets/icons/2016/mia/1.png"></a>
                                                            <div class="media-body">
                                                                <div class="mar-btm">
                                                                    <a href="#"
                                                                       class="btn-link text-semibold media-heading box-inline">
                                                                        <?php $userInfo = $model->userId($comment[$i]['user_id']); ?>
                                                                        <?php echo $userInfo['login'] ?></a>
                                                                    <p class="text-muted text-sm"><i
                                                                                class="fa fa-mobile fa-lg"></i> -
                                                                        19-06-2016</p>
                                                                </div>
                                                                <p><?php
                                                                                                                                        if (!empty($comment)) {
                                                                                                                                            echo $comment[$i]['text'];
                                                                                                                                        }

                                                                    ?></p>
                                                                <div class="pad-ver">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-sm btn-default btn-hover-success"
                                                                           href="#"><i class="fa fa-thumbs-up"></i></a>
                                                                        <a class="btn btn-sm btn-default btn-hover-danger"
                                                                           href="#"><i
                                                                                    class="fa fa-thumbs-down"></i></a>
                                                                    </div>
                                                                    <a class="btn btn-sm btn-default btn-hover-primary"
                                                                       href="#">Ответить</a>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                            <!-- Конец Содержания Новостей -->
                                                        </div>


                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                </section><!-- /.container -->
<!--                                    --><?php //$comments = $postVar->getComment($var['id']);
//                                    $count = count($comments);
//                                        for ($i=0;$i<$count;$i++)
//                                        { ?>
<!--                                            <div class="container">-->
<!--                                                <div class="row align-items-start">-->
<!--                                                    <div class="col-md">-->
<!--                                                        <h4 >--><?php //echo $user['login']; ?><!--</h4>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-md">-->
<!--                                                        <img style="width: 64px"  src="--><?php //echo '../../../public/avatars/'.$user['avatar']?><!--">-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="row">-->
<!--                                                <div class="col-md-4"></div>-->
<!--                                                <div class="col-md-5">-->
<!--                                                    <div id="--><?php //echo 'comtText'.$var['id']; ?><!--">-->
<!--                                                        --><?php
//                                                        $userId = (int)$comments[$i]['user_id'];
//                                                        $user = $postVar->userId($userId);
//                                                        echo $comments[$i]['text']; ?>
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            --><?php //} ?>
                            <?php } ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Blog Post End -->
<!--                </div>-->
                <!-- Footer Start -->
                <div class="col-md-12 page-body margin-top-50 footer ">
                    <footer>
                        <ul class="menu-link">
                            <li><a href="/about">О проекте</a></li>
                            <li><a href="/feedback">Связаться с нами</a></li>
                        </ul>
                        <p>© Copyright 2018. All rights reserved</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>