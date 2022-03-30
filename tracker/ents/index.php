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
} else {
  $ents = $searchEngine->search('', 'ent');
}
// echo "<code><pre><br>";
// echo "RECHERCHE : " . $_POST['ent-rb'] . "<br><br>";
// echo "RESULTAT : ";
// print_r($ents);
// echo "<br><br>";
$cartes = [];

foreach ($ents as $idEnt) {
  //FAIRE CARTES ENTREPRISES
  array_push($cartes, $data->getEntCard($idEnt['ID_ent'], 0));
}

if (empty($cartes)) {
  $msg = "Aucune entreprise trouvée avec cette recherche.";
} else {
  $msg = '';
}
$i = 0;
$limit = 99;

// print_r($cartes);
// echo "<br></pre></code>";


if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('tracker_ent.html.twig', ['cartes' => $cartes, 'msg' => $msg, 'limit' => $limit, 'i' => $i, 'visible1' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
} else {
  echo $twig->render('tracker_ent.html.twig', ['cartes' => $cartes, 'msg' => $msg, 'limit' => $limit, 'i' => $i, 'visible2' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
}
