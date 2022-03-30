<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo "ERREUR";
  $id = 1;
}

$offre = $data->getOffre($id);



if (!empty($offre)) {
  // echo "HAHAHAHA";
  // echo "<br><br><code><pre>";
  // print_r($offre);
  // echo "</pre></code>";
} else {
  echo $twig->render('erreur_page.html.twig', ['bc' => '../../../src/img/bck_error.jpg']);
  die();
}

  echo $twig->render('detail_offre.html.twig',['result' => $offre]);

if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('detail_offre.html.twig', ['result' => $offre, 'visible1' => 'visibility: collapse']);
} else {
  echo $twig->render('detail_offre.html.twig', ['result' => $offre, 'visible2' => 'visibility: collapse']);
}