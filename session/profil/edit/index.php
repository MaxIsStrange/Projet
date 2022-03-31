<?php
include_once "../../../func/func_bdd.php";
include_once "../../../func/func_session.php";
include_once "../../../func/func_login.php";
include_once "../../../func/func_upload.php";
include_once "../../../func/func_mail.php";


echo "<code><pre><br><br><br>";
$idRes = isset($_GET['id']) ? $_GET['id'] : null;

if ($idRes == null) {
  echo "ERREUR";
  exit();
}

$user = $data->getUserById($idRes);
$adr = $data->getAdrByUser($idRes);
$alb = $data->getAlbum($idRes, 'user');
$desc = !empty($user['Desc_user']) ? htmlspecialchars_decode($user['Desc_user'], ENT_QUOTES) : null;
$comp = !empty($adr['Comp_adr']) ? htmlspecialchars_decode($adr['Comp_adr'], ENT_QUOTES) : null;

// echo "<br><br><pre>";
// print_r($alb);
// echo "</pre><br>";

//Modification des informations
if (
  isset($_POST['result']) && $_POST['result'] == "basic_edit" &&

  isset($_POST['name']) && isset($_POST['fname']) && isset($_POST['adr_rue'])
  && isset($_POST['adr_cp']) && isset($_POST['adr_city'])
  && isset($_POST['adr_pays']) && isset($_POST['tel'])
) {
  $adr_num = isset($_POST['adr_num']) ? htmlspecialchars($_POST['adr_num']) : null;
  $adr_comp = isset($_POST['adr_comp']) ? htmlspecialchars($_POST['adr_comp']) : null;
  $user_desc = isset($_POST['desc']) ? htmlspecialchars($_POST['desc']) : null;
  $user_bd = isset($_POST['bd']) ? htmlspecialchars($_POST['bd']) : null;

  $tabInfo = [
    'id_user' => $idRes,
    'name' => htmlspecialchars($_POST['name']),
    'fName' => htmlspecialchars($_POST['fname']),

    'bd' => $user_bd,

    'rue' => htmlspecialchars($_POST['adr_rue']),
    'cp' => htmlspecialchars($_POST['adr_cp']),
    'city' => htmlspecialchars($_POST['adr_city']),
    'pays' => htmlspecialchars($_POST['adr_pays']),
    'id_adr' => $adr['ID_adr'],

    'tel' => htmlspecialchars($_POST['tel']),

    'num' => $adr_num,
    'comp' => $adr_comp,

    'desc' => $user_desc
  ];

  $log->editBasic($tabInfo);

  if (!empty($_FILES['file_cv']['name'])) {
    $upload->setOrigin('file_cv');
    $path = $upload->uploadFile('CV', $idRes);

    $album = [
      'cv' => $path,
      'id' => $alb['ID_album']
    ];


    $data->editAlb($album, 'cv');
  }

  if (!empty($_FILES['file_lm']['name'])) {
    $upload->setOrigin('file_lm');
    $path = $upload->uploadFile('Motiv', $idRes);

    $album = [
      'lm' => $path,
      'id' => $alb['ID_album']
    ];



    $data->editAlb($album, 'lm');
  }

  if (!empty($_FILES['file_fv']['name'])) {
    $upload->setOrigin('file_fv');
    $path = $upload->uploadFile('Fiche', $idRes);

    $album = [
      'fv' => $path,
      'id' => $alb['ID_album']
    ];


    $data->editAlb($album, 'fv');
  }




  $mailer->setMail('modif');
  $mailer->sendMail($user['Mail_user']);

  header("Location: ../");

} elseif (
  isset($_POST['result']) && $_POST['result'] == "account_edit"
  && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2']) // && isset($_POST['old_pass'])
) {


  if (
    $_POST['pass'] === $_POST['pass2'] && $log->verifMDP($_POST['old_pass'], $user['MDP_user'])
  ) {
    $tabInfo = [
      'mail' => htmlspecialchars($_POST['mail']),
      'pass' => $log->hashMDP($_POST['pass']),
      'id' => $idRes
    ];

    $log->editAccount($tabInfo);
  }

  header("Location: ../");

} elseif (
  isset($_POST['result']) && $_POST['result'] == 'img'
  && $_FILES['img_pp']
) {
  $upload->setOrigin('img_pp');
  $pathURL = $upload->uploadFile("Avatar", $idRes);



  $tabInfo = [
    'av' => $pathURL,
    'id' => $alb['ID_album']
  ];

  $data->editAlb(
    $tabInfo,
    'user'
  );

  header("Location: ../");
}

if (
  isset($_POST['delAccount']) && $_POST['delAccount'] === "Supprimer le compte"
  && (!empty($_POST['del_pass'])) && $log->verifMDP($_POST['del_pass'], $user['MDP_user'])
) {
  $data->deleteUser($idRes);
}

//print_r($_FILES);
echo "</pre></code>";




  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

echo $twig->render('edit.html.twig', ['user' => $user, 'adr' => $adr, 'alb' => $alb, 'desc' => $desc, 'visible1' => 'visibility: collapse', 'visiAdmin' => $visiAdmin]);
