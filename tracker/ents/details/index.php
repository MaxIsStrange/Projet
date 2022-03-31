<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";
include_once "../../../func/func_perm.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

//echo "<br><br><br>";

if ($perm->chkPerm(7)) {
  $id = isset($_GET['id']) ? $_GET['id'] : null;
  //echo "<br><br><br>ID : $id";
} else {
  $id = null;
}

if ($id == null) {
  echo "ERREUR : PAGE INTROUVABLE";
  exit();
}

if (!empty($data->chkEntID($id))) {
  // echo 'UTILISATEUR EXISTANT';
} else {
  echo "ENTREPRISE INCONNUE";
  exit();
}

$result = !empty($data->getEnt($id)) ? $data->getEnt($id) : "ERROR";
$album = !empty($data->getAlbum($id, 'ent')) ? $data->getAlbum($id, 'ent') : "ERROR";
$idAdr = !empty($data->getAdrIdByEnt($id)) ? $data->getAdrIdByEnt($id) : "ERROR";
$adr = !empty($data->getAdr($idAdr['ID_adr'])) ? $data->getAdr($idAdr['ID_adr']) : "ERROR";
$rue = !empty($adr["Rue_adr"]) ? htmlspecialchars_decode($adr["Rue_adr"], ENT_QUOTES) : null;



if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('detail_ent.html.twig', ['id' => $id, 'result' => $result, 'album' => $album, 'adr' => $adr, 'visible1' => 'visibility: collapse', 'visiAdmin' => $_SESSION['ADMIN']]);
} else {
  echo $twig->render('detail_ent.html.twig', ['id' => $id, 'result' => $result, 'album' => $album, 'adr' => $adr, 'visible2' => 'visibility: collapse', 'visiAdmin' => $_SESSION['ADMIN']]);
}