<?php
include_once "../../../func/func_session.php";
include '../../../func/func_login.php';

require_once('..\..\..\vendor\autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('..\..\..\templates');
  $twig = new \Twig\Environment($loader);


if (isset($_POST['mail']) && isset($_POST['pass'])) {
  if ($log->chkLogin($_POST['mail'], $_POST['pass'])) {
    header("Location: ../../../index.php");
    die();
  } else {
    echo $twig->render('connection.html.twig');

    echo $twig->render('err_connect.twig');
  }
} else {
  echo $twig->render('connection.html.twig');
}
