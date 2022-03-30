<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

  $result=$data->getEnt(18);
  $album=$data->getAlbum(18,'ent');
  $idadr=$data->getAdrIdByEnt(18);
  $adr=$data->getAdr($idadr["ID_adr"]);


if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('detail_ent.html.twig', ['result' => $result, 'album' => $album, 'adr' => $adr, 'visible1' => 'visibility: collapse']);
} else {
  echo $twig->render('detail_ent.html.twig', ['result' => $result, 'album' => $album, 'adr' => $adr, 'visible2' => 'visibility: collapse']);
}