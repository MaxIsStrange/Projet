<?php
  include_once "../../func/func_session.php";
  include_once "../../func/func_bdd.php";

  require_once('../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../templates');
  $twig = new \Twig\Environment($loader);


//   if (isset($_SESSION['USER_FNAME'])) {
//     $id = $data -> getUserID($_SESSION["USER_MAIL"]);
//     $album = $data -> getAlbum($id);
//     print_r($album["Avatar_album"]);
//     echo $twig->render('profil.html.twig', ['session' => $_SESSION,'album' => $album]);
//   }
//  else {echo "not connected";}
