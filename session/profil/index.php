<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_session.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_bdd.php";

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);


if (isset($_SESSION['USER_FNAME'])) {
  $grp = $data ->getPoste($_SESSION["USER_MAIL"]);
  $album = $data->getAlbum($data->getUserID($_SESSION["USER_MAIL"]));
  $infos = $data->getUser($_SESSION["USER_MAIL"]);
  $comps = $data->getComp($_SESSION["USER_MAIL"]);
  echo $twig->render('profil.html.twig', ['session' => $_SESSION, 'album' => $album, 'infos' =>$infos,'comps' => $comps,'grp' => $grp]);
} else {
  echo "not connected";
}
