<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

$id = 16;

if (isset($_SESSION['USER_FNAME'])) {

  if (isset($_POST['result']) && $_POST['result'] == "Se déconnecter") {

    header("Location: auth/logout.php");
  }


  $grp = $data ->getPoste($_SESSION["USER_MAIL"]);
  $album = $data->getAlbum($data->getUserID($_SESSION["USER_MAIL"]),'user');
  $infos = $data->getUser($_SESSION["USER_MAIL"],'one');
  $comps = $data->getComp($_SESSION["USER_MAIL"]);
  $id = $data->getUserID($_SESSION["USER_MAIL"]);
  $data->getPostulate($id);

  $desc=htmlspecialchars_decode($infos["Desc_user"],ENT_QUOTES);
  echo $twig->render('profil.html.twig', ['session' => $_SESSION, 'album' => $album, 'infos' => $infos, 'comps' => $comps, 'grp' => $grp, 'desc' => $desc, 'id' => $id]);
  $data->getPostulate(18);

 



} else {
  echo "Error : not connected";
}
