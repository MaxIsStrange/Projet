<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

  echo $twig->render('add_offre.html.twig');