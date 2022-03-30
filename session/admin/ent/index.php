<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";
include_once "../../../func/func_upload.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);




if (
  isset($_POST['name']) && isset($_POST['desc']) && isset($_POST['mail'])
  && isset($_POST['tel']) && isset($_FILES['ban_ent']) && isset($_FILES['logo_ent'])
  && isset($_POST['verif']) && isset($_POST['nbr_conf']) && isset($_POST['adr_rue'])
  && isset($_POST['adr_cp']) && isset($_POST['adr_ville'])
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
    'comp' => $adr_comp
  ];

  $data->addAddr($tabInfoAdr);

  $upload->setOrigin("ban_ent");
  $pathBan = $upload->uploadFile("Banniere",  $data->chkMaxIDEnt()['ID_ent'] + 1);
  $upload->setOrigin("logo_ent");
  $pathLogo = $upload->uploadFile("Logo",  $data->chkMaxIDEnt()['ID_ent'] + 1);

  $tabInfoAlb = [
    'av' => null,
    'ba' => $pathBan,
    'lo' => $pathLogo
  ];

  $data->addAlbum($tabInfoAlb);

  $tabInfoEnt = [
    'name' => htmlspecialchars($_POST['name']),
    'desc' => htmlspecialchars($_POST['desc']),
    'mail' => htmlspecialchars($_POST['mail']),
    'tel' => htmlspecialchars($_POST['tel']),
    'nbr_conf' => htmlspecialchars($_POST['nbr_conf']),

    'slogan' => $slogan,
    'nbr' => $nbr,
    'web' => $web,
    'sect' => $sect,

    'ID_alb' => $data->chkMaxIDAlb()["ID_album"]
  ];

  $data->addEnt($tabInfoEnt);

  $data->linkAdrEnt($data->chkMaxIDAdr()['ID_adr'], $data->chkMaxIDEnt()['ID_ent']);
} else {
  echo "ERREUR : Veuillez renseigner tout les champs";
}

echo $twig->render('add_ent.html.twig', ['visible1' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
