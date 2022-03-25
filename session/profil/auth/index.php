<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_session.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_login.php";

require_once('../../../vendor/autoload.php');

  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');

  $twig = new \Twig\Environment($loader);

if (isset($_POST['mail']) && isset($_POST['pass'])) {
  if ($log->chkLogin($_POST['mail'], $_POST['pass'])) {
    header("Location: ../../../index.php");
    exit();
  } else {
    echo $twig->render('connection.html.twig');

    echo $twig->render('err_connect.twig');
  }
} else {
  echo $twig->render('connection.html.twig');
}
