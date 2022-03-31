<?php
include_once "../../../func/func_bdd.php";
include_once "../../../func/func_session.php";
include_once "../../../func/func_login.php";
include_once "../../../func/func_upload.php";
  require_once('../../../vendor/autoload.php');
  
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

//TEMPORAIRE

//echo "<code><pre><br><br><br>";
$idRes = isset($_GET['id']) ? $_GET['id'] : null;

if (empty($data->chkEntID($idRes)) || $idRes == null) {
  echo "ERREUR";
  exit();
}


$ent = $data->getEnt($idRes);
$adrID = $data->getAdrIdByEnt($idRes);
$adr = $data->getAdr($adrID['ID_adr']);
$alb = $data->getAlbum($idRes, 'ent');


if (
  isset($_POST['name']) && isset($_POST['desc']) && isset($_POST['mail'])
  && isset($_POST['tel'])  && isset($_POST['nbr_conf'])
  && isset($_POST['adr_rue']) && isset($_POST['adr_cp']) && isset($_POST['adr_ville'])
  && isset($_POST['adr_pays'])
) {

  $slogan = isset($_POST['slogan']) ? htmlspecialchars($_POST['slogan']) : null;
  $nbr = isset($_POST['nbr']) ? htmlspecialchars($_POST['nbr']) : null;
  $web = isset($_POST['web']) ? htmlspecialchars($_POST['web']) : null;
  $sect = isset($_POST['sect']) ? htmlspecialchars($_POST['sect']) : null;

  $adr_num = isset($_POST['adr_num']) ? htmlspecialchars($_POST['adr_num']) : null;
  $adr_comp = isset($_POST['adr_comp']) ? htmlspecialchars($_POST['adr_comp']) : null;

  $tabInfoAdr = [
    'rue' => htmlspecialchars($_POST['adr_rue']),
    'cp' => htmlspecialchars($_POST['adr_cp']),
    'city' => htmlspecialchars($_POST['adr_ville']),
    'pays' => htmlspecialchars($_POST['adr_pays']),
    'num' => $adr_num,
    'comp' => $adr_comp,

    'id' => $adrID['ID_adr']
  ];

  $data->editAdr($tabInfoAdr);

  if (!empty($_FILES['ban_ent']['name'])) {
    $upload->setOrigin("ban_ent");
    $pathBan = $upload->uploadFile("Banniere",  $idRes);
  } else {
    $pathBan = $alb['Banniere_album'];
  }

  if (!empty($_FILES['logo_ent']['name'])) {
    $upload->setOrigin("logo_ent");
    $pathLogo = $upload->uploadFile("Logo",  $idRes);
  } else {
    $pathLogo = $alb['Logo_album'];
  }
 

  
  

  $tabInfoAlb = [
    'av' => null,
    'ba' => $pathBan,
    'lo' => $pathLogo,
    'id' => $alb['ID_album']
  ];

  $data->editAlb($tabInfoAlb, 'ent');

  $tabInfoEnt = [
    'nom' => htmlspecialchars($_POST['name']),
    'desc' => htmlspecialchars($_POST['desc']),
    'mail' => htmlspecialchars($_POST['mail']),
    'tel' => htmlspecialchars($_POST['tel']),
    'conf' => htmlspecialchars($_POST['nbr_conf']),

    'slogan' => $slogan,
    'taille' => $nbr,
    'web' => $web,
    'sect' => $sect,

    'id' => $idRes
  ];

  $data->editEnt($tabInfoEnt);

  header("Location: ../../../tracker/ents/details/?id=$idRes");
  // print_r($alb);
  // echo "<br><br>";
  // // print_r($tabInfoAdr);
  // // echo "<br><br>";
  // print_r($tabInfoAlb);
  // echo "<br><br>";
  // // print_r($tabInfoEnt);
  // // echo "<br><br>";
  // print_r($_FILES);
 
}
//echo "</code></pre>";




echo $twig->render('edit_ent.html.twig', ['ent' => $ent, 'alb' => $alb, 'adr' => $adr, 'visible1' => 'visibility: collapse', 'visiAdmin' => $visiAdmin]);