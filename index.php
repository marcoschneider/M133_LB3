<?php

error_reporting(E_ALL & ~E_NOTICE);

//starts Session
session_start();

//import configs and import lib
require 'res/lib/router/Route.php';
require 'res/config.inc.php';
require LIBRARY_PATH.'/functions.php';

$conn = Config::getDb();

//Manages redirect to login page if not logged in.
if(!$_SESSION['loggedin']) {
  redirect("public/pages/login.php");
  die();
}

//SESSION configurations
$uid = $_SESSION['kernel']['userdata']["id"];
$groupname = $_SESSION['kernel']['userdata']['group_name'];
$groupID = $_SESSION['kernel']['userdata']['group_id'];
$username = $_SESSION['kernel']['userdata']['username'];

?>


<!DOCTYPE html>
<html>
  <head>
    <?php header('Content-type: text/html; charset=utf-8');
    Config::styles();
    ?>
    <link rel="icon" type="image/png" sizes="32x32" href="public/assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="public/assets/img/favicon-16x16.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html" lang="de"/>
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="node_modules/ckeditor/ckeditor.js"></script>
    <title>Todo Web App</title>
  </head>
	<body>
    <header>
      <div class="container-fluid">
        <div class="row">
          <div class="col valign-wrapper">
            <a class="button-default" href="?pages=logout"><i class="fas fa-sign-out-alt fa-2x"></i></a>
          </div>
          <div class="col brand-logo">
            <a href="?pages=support-links ">
              <img class="logo" src="public/assets/img/vectorpaint.svg"/>
            </a>
          </div>
          <div class="col valign-wrapper flex-end">
            <a class="button-default white-text right" href="?pages=userdata" ><i class="fas fa-user"></i><?= $username?></a>
          </div>
        </div>
        <div class="row">
          <nav class="menu">
            <?php
            $links = array(
              'Favorite Links' => 'support-links',
              'Aufgabenübersicht' => 'todo-overview',
              'Gruppenübersicht' => '?pages=group-overview',
              'Gruppen Log'  => '?pages=group-log'
            );

            $navigation =  createMenu($links);
            echo $navigation;
            ?>
            <div class="clearer"></div>
          </nav>
        </div>
      </div>
    </header>
    <div class="tooltip-wrapper">
      <div class="tooltip valign-wrapper">
        <a class="tap-target" href="create-todo"><i class="tap-target-done-overview fas fa-plus-circle fa-5x" aria-hidden="true"></i></a>
      </div>
      <div class="tooltip valign-wrapper">
        <a class="tap-target" href="?pages=done-overview"><i class="tap-target-create-todo fas fa-check-circle fa-5x" aria-hidden="true"></i></a>
      </div>
    </div>
    <div class="container-wrapper">
      <?php

        Route::add('/todo-overview',function() use ($conn, $uid){
          include('public/pages/todoOverview.php');
        },'get');

        Route::add('/support-links',function() use ($conn, $uid){
          include('public/pages/supportLinks.php');
        },'get');

        Route::add('/support-links/add',function() use ($conn, $uid){
          include('public/includes/linkValidation.php');
        },'post');

        Route::add('/support-links/delete',function() use ($conn, $uid){
          include('public/includes/linkValidation.php');
        },'post');

        Route::add('/create-todo',function() use ($conn, $uid){
          include('public/pages/createTodo.php');
        },'get');

        Route::add('/create-todo',function() use ($conn, $uid){
          include('public/pages/createTodo.php');
        },'post');

        Route::run('/');

        if (isset($_GET['pages'])){
          switch ($_GET['pages']){
            case 'create-todo':
              include 'public/pages/createTodo.php';
              break;
            case 'delete-todo':
              include 'public/pages/deleteTodo.php';
              break;
            /*case 'todo-overview':
              include 'public/pages/todoOverview.php';
              break;*/
            case 'todo-details':
              include 'public/pages/todoDetails.php';
              break;
            case 'edit-todo':
              include 'public/pages/editTodo.php';
              break;
            case 'userdata':
              include 'public/pages/user.php';
              break;
            case 'group-overview':
              include 'public/pages/groupOverview.php';
              break;
            case 'done-todo':
              include 'public/pages/doneTodo.php';
              break;
            case 'done-overview':
              include 'public/pages/doneOverview.php';
              break;
            case 'update-todo':
              include 'public/pages/updateTodo.php';
              break;
            case 'game':
              include 'public/pages/game.php';
              break;
            case 'group-log':
              include 'public/pages/groupLogs.php';
              break;
            case 'logout':
              session_unset();
              session_destroy();
              redirect("public/pages/login.php");
              break;
            default:
              include 'public/pages/notFound.php';
              break;
          }

        }

      ?>
    </div>
    <footer class="footer col-12 valign-wrapper center">
      <div class="col-12">
        <p>Resize the browser window to see how the content respond to the resizing.</p>
        <br>
        <p>&copy Copyright Viaduct Web Support</p>
      </div>
    </footer>
    <?php
      Config::scripts();
    ?>
	</body>
</html>