<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);
  $offre= $data -> getOffre(1);

  echo $twig->render('detail_offre.html.twig',['result' => $offre]);