<?php
  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

echo $twig->render('pilote_panel.html.twig', ['visible2' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);