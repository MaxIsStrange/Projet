<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);


if (
  isset($_POST['name']) && isset($_POST['desc']) && isset($_POST['titre'])
  && isset($_POST['salary']) && isset($_FILES['prom']) && isset($_FILES['logo_ent'])
  && isset($_POST['prom']) && isset($_POST['nbrPoste']) && isset($_POST['duree'])
  && isset($_POST['adr_rue']) && isset($_POST['adr_cp']) && isset($_POST['adr_ville'])
  && isset($_POST['adr_pays'])
)

  echo $twig->render('add_offre.html.twig', ['visible1' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);