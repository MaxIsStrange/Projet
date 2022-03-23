<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);


if (isset($_SESSION['USER_FNAME'])) {

  $album = $data->getAlbum($data->getUserID($_SESSION["USER_MAIL"]));
  echo $twig->render('profil.html.twig', ['session' => $_SESSION, 'album' => $album]);
} else {
  echo "not connected";
}
