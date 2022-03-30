<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

$id = 16;

if (isset($_SESSION['USER_FNAME'])) {
  $grp = $data ->getPoste($_SESSION["USER_MAIL"]);
  $album = $data->getAlbum($data->getUserID($_SESSION["USER_MAIL"]),'user');
  $infos = $data->getUser($_SESSION["USER_MAIL"],'one');
  $comps = $data->getComp($_SESSION["USER_MAIL"]);
  $id = $data->getUserID($_SESSION["USER_MAIL"]);
  $data->getPostulate($id);

  echo "<br><br><pre>";
  $desc=$infos["Desc_user"];
  print_r($desc);
  $desc=htmlspecialchars_decode($desc);
  print_r($desc);
  echo "</pre><br>";
  echo $twig->render('profil.html.twig', ['session' => $_SESSION, 'album' => $album, 'infos' => $infos, 'comps' => $comps, 'grp' => $grp, 'desc' => $desc, 'id' => $id]);
  $data->getPostulate(18);




} else {
  echo "Error : not connected";
}
