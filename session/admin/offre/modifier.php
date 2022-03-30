<?php
  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

echo $twig->render('edit_offre.html.twig', ['visible1' => 'visibility: collapse']);