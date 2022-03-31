<?php
  include_once "../func/func_session.php";

  require_once('../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../templates');
  $twig = new \Twig\Environment($loader);

echo $twig->render('legal.html.twig', ['visiAdmin' => $visiAdmin]);