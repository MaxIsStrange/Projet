<?php
include_once "../../../func/func_session.php";
include '../../../func/func_login.php';

require_once('../../../vendor/autoload.php');

  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');

  $twig = new \Twig\Environment($loader);

if (isset($_POST['mail']) && isset($_POST['pass'])) {
  if ($log->chkLogin($_POST['mail'], $_POST['pass'])) {
    header("Location: ../../../index.php");
    exit();
  } else {
    echo $twig->render('connection.html.twig', ['visible2' => 'visibility: collapse', 'visiAdmin' => $_SESSION['ADMIN'], 'error' => true]);

  }
} else {
  echo $twig->render('connection.html.twig', ['visible2' => 'visibility: collapse', 'visiAdmin' => $_SESSION['ADMIN']]);
}
