<?php
include_once "../../../func/func_bdd.php";
include_once "../../../func/func_session.php";
include_once "../../../func/func_login.php";
include_once "../../../func/func_upload.php";

echo "<code><pre><br><br><br>";
$idRes = isset($_GET['id']) ? $_GET['id'] : null;

$user = $data->getUserById($idRes);
$adr = $data->getAdrByUser($idRes);
$alb = $data->getAlbum($idRes, 'user');
$desc = htmlspecialchars_decode($user['Desc_user']);

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



// IMAGE
// if (isset($_POST['sub-img']) && isset($_FILES['img_pp'])) {

//   $upload->setOrigin("ban_ent");
//   $pathAva = $upload->uploadFile("Avatar", $data->getUserID());



//   $upload->setOrigin("img_pp");

//   $result = $upload->uploadFile('Avatar', $_SESSION['USER_ID']);

//   switch ($result) {
//     case '1':
//       echo "ERREUR : Fichier trop grand";
//       break;

//     case '2':
//       echo "ERREUR : Extension incorrecte";
//       break;

//     case '3':
//       echo "ERREUR : Fichier déjà existant";

//       break;

//     default:
//       $pathRel = "../../../docs/avatar/" . $result;
//       $pathURL = "https://hsbay.space/cesi/stagetracker/docs/" . $result;

//       move_uploaded_file($_FILES["img_pp"]["tmp_name"],  $pathRel);

//       echo "<img src='" . $result . "'>";
//       echo "<br>URL : $pathURL";
//       echo "<br>RELATIF : $pathRel";
//       break;
//   }
// }
//    1 : Fichier trop grand
//    2 : Extension incorrecte
//    3 : Fichier existant
//    4 : OK


// echo "<br></pre></code>";







  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

echo $twig->render('edit.html.twig', ['user' => $user, 'adr' => $adr, 'alb' => $alb, 'desc' => $desc]);
