<?php
include_once "../../../func/func_session.php";
include '../../../func/func_login.php';

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

  echo $twig->render('edit.html.twig', ['userfname' => 'Fabien']);
