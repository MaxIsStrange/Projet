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
  echo "<br><br><pre>";
  print_r($adr);
  print_r($idadr["ID_adr"]);
  echo "</pre><br>";

  echo $twig->render('detail_ent.html.twig',['result' => $result, 'album' => $album,'adr' =>$adr]);