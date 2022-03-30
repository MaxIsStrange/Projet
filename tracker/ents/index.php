<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";
include_once "../../func/func_search.php";
include_once "../../func/func_perm.php";

  require_once('../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../templates');
  $twig = new \Twig\Environment($loader);

if (isset($_POST['ent-rb'])) {
  $ents = $searchEngine->search($_POST['ent-rb'], 'ent');
}

$cartes = [];

foreach ($ents as $ent) {
  //FAIRE CARTES ENTREPRISES
  array_push($cartes, $data->)
}

  echo $twig->render('tracker_ent.html.twig');
