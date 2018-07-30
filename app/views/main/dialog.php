<?php //$usersId = $vars['model']->getSubscriptions($_SESSION['id']); ?>
<!--<div class="container">-->
<!--    <h3>Диалоги:</h3>-->
<!--    <div class="row">-->
<!--        <div class="col-sm-12">-->
<!--            --><?php //if (empty($usersId)){ ?>
<!--            <h3>У вас нет диалогов, так как вы ни на кого не подписаны.</h3>-->
<!--            --><?php //} ?>
<!--            <ul class="list-group">-->
<!--                --><?php // foreach ($usersId as $user) { ?>
<!--                <li class="list-group-item d-flex justify-content-between align-items-center">-->
<!--                    --><?php //$userInfo = $vars['model']->userId($user['friend_id']); ?>
<!--                    <button class="btn btn-outline-light" type="submit" name="list">-->
<!--                        <a href="/dialog/--><?php //echo $userInfo['id'] ; ?><!--/">--><?php //echo $userInfo['login'];?><!--</a>-->
<!--                    </button>-->
<!--                    <span class="badge badge-primary badge-pill">14</span>-->
<!--                </li>-->
<!--            --><?php //} ?>
<!--            </ul>-->
<!--        </div>-->
<!--        <div >-->
<!--            --><?php
//            $colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
//            $user_colour = array_rand($colours);
//            ?>
<!--            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->
<!--            <script src="../../../template/default/js/chat.js" language="javascript" type="text/javascript"></script>-->
<!--            <div class="col-">-->
<!--            <div class="chat_wrapper">-->
<!--                    <h3>Общий чат</h3>-->
<!--                    <div class="message_box" id="message_box"></div>-->
<!--                    <div class="panel">-->
<!--                        <input class="form-control" type="text" name="name" id="name" placeholder="Your Name" maxlength="10" style="width:20%"  />-->
<!--                        <input class="form-control" type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:60%" />-->
<!--                        <button class="btn btn-primary" id="send-btn">Send</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Footer Start -->
<!--<div class="col-md-12 page-body margin-top-50 footer ">-->
<!--    <footer>-->
<!--        <ul class="menu-link">-->
<!--            <li><a href="/about">О проекте</a></li>-->
<!--            <li><a href="/feedback">Связаться с нами</a></li>-->
<!--        </ul>-->
<!--        <p>© Copyright 2018. All rights reserved</p>-->
<!--    </footer>-->
<!--</div>-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>chatapp</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

    <link rel="stylesheet" href="../../widgets/chat/sitepoint_codes/ratchet_chatapp/css/style.css">
</head>
<body>
<div id="wrapper">
    <div id="user-container">
        <label for="user">What's your name?</label>
        <input type="text" id="user" name="user">
        <button type="button" id="join-chat">Join Chat</button>
    </div>

    <div id="main-container" class="hidden">
        <button type="button" id="leave-room">Leave</button>
        <div id="messages">

        </div>

        <div id="msg-container">
            <input type="text" id="msg" name="msg">
            <button type="button" id="send-msg">Send</button>
        </div>
    </div>

</div>

<script id="messages-template" type="text/x-handlebars-template">
    {{#each messages}}
    <div class="msg">
        <div class="time">{{time}}</div>
        <div class="details">
            <span class="user">{{user}}</span>: <span class="text">{{text}}</span>
        </div>
    </div>
    {{/each}}
</script>

<script src="../../widgets/chat/sitepoint_codes/ratchet_chatapp/js/main.js"></script>
</body>
</html>