<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

$id = 18;

if (isset($_SESSION['USER_FNAME'])) {
  $grp = $data ->getPoste($_SESSION["USER_MAIL"]);
  $album = $data->getAlbum($data->getUserID($_SESSION["USER_MAIL"]),'user');
  $infos = $data->getUser($_SESSION["USER_MAIL"]);
  $comps = $data->getComp($_SESSION["USER_MAIL"]);

  $desc=htmlspecialchars_decode($infos["Desc_user"]);
  echo $twig->render('profil.html.twig', ['session' => $_SESSION, 'album' => $album, 'infos' =>$infos,'comps' => $comps,'grp' => $grp,'desc' => $desc]);
  $data->getPostulate(18);




} else {
  echo "Error : not connected";
}
