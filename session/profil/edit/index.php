<?php
include_once "../../../func/func_bdd.php";
include_once "../../../func/func_session.php";
include_once "../../../func/func_login.php";
include_once "../../../func/func_upload.php";

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
//print_r($_FILES['img_pp']);

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

  print_r($log->editBasic($tabInfo));

  $message = "Bonjour,\n Votre compte StageTracker vient d'être modifié. \n Si ce n'est pas votre action, veuillez modifier tout de suite votre mot de passe et mail.";
  mail($user['Mail_user'], 'StageTracker - Modification de vos informations', $message);
  
} elseif (
  isset($_POST['result']) && $_POST['result'] == "account_edit"
  && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2']) // && isset($_POST['old_pass'])
) {


  if (
    $_POST['pass'] === $_POST['pass2'] //&& $log->verifMDP($_POST['old_pass'], $user['MDP_user'])
  ) {
    $tabInfo = [
      'mail' => htmlspecialchars($_POST['mail']),
      'pass' => $log->hashMDP($_POST['pass']),
      'id' => $idRes
    ];

    $log->editAccount($tabInfo);
  }
} elseif (
  isset($_POST['result']) && $_POST['result'] == 'img'
  && $_FILES['img_pp']
) {
  $upload->setOrigin('img_pp');
  $pathURL = $upload->uploadFile("Avatar", $idRes);


  //print_r($alb);

  $tabInfo = [
    'av' => $pathURL,
    'id' => $alb['ID_album']
  ];



  $data->editAlb(
    $tabInfo,
    'user'
  );

  
}
echo "</pre></code>";




  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

echo $twig->render('edit.html.twig', ['user' => $user, 'adr' => $adr, 'alb' => $alb, 'desc' => $desc, 'visible1' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
