<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";
include_once "../../func/func_perm.php";
include_once "../../func/func_upload.php";

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

if (isset($_POST['result']) && $_POST['result'] == "Se déconnecter") {
  header("Location: auth/logout.php");
}

$canDeco = false;

if ($perm->chkPerm(22)) {
  $id = isset($_GET['id']) ? $_GET['id'] : null;
}

if ($id == null && !empty($_SESSION['USER_ID'])) {
  $id = $_SESSION['USER_ID'];
  $canDeco = true;
}

if (!empty($data->chkUserID($id))) {
  // echo 'UTILISATEUR EXISTANT';
} else {
  echo "UTILISATEUR INCONNU";
  exit();
}

$grp = !empty($data->getPoste($id)) ? $data->getPoste($id) : 'ERROR';
$album = !empty($data->getAlbum($id, 'user')) ? $data->getAlbum($id, 'user') : "ERROR";
$infos = !empty($data->getUserById($id)) ? $data->getUserById($id) : 'ERROR';
$comps = !empty($data->getComp($id)) ? $data->getComp($id) : 'ERROR';

$postulation= $data->getPostulate($id);
// echo "<br><br><pre>";
// print_r($_POST);
// echo"</pre>";
if(isset($postulation[0])){
  //print_r("hihi");
  $step=1;
}else{
  $step=0;
}
if(isset($_POST["abandon"])){
  //print_r("lacheur");
  $data->leaveCandid($id,$_POST["id"]);
}





$desc = !empty($infos["Desc_user"]) ? htmlspecialchars_decode($infos["Desc_user"], ENT_QUOTES) : null;
echo $twig->render('profil.html.twig', ['album' => $album, 'infos' => $infos, 'comps' => $comps, 'grp' => $grp, 'desc' => $desc, 'id' => $id, 'visible1' => 'visibility: collapse', 'deco' => $canDeco, 'visiAdmin' => $_SESSION['ADMIN'], 'postulation' => $postulation, 'step' => $step]);

















// if (isset($_SESSION['USER_FNAME'])) {

//   if (isset($_POST['result']) && $_POST['result'] == "Se déconnecter") {

//     header("Location: auth/logout.php");
//   }


//   $grp = $data->getPoste($_SESSION["USER_MAIL"]);
//   $album = $data->getAlbum($data->getUserID($_SESSION["USER_MAIL"]), 'user');
//   $infos = $data->getUser($_SESSION["USER_MAIL"], 'one');
//   $comps = $data->getComp($_SESSION["USER_MAIL"]);
//   $id = $data->getUserID($_SESSION["USER_MAIL"]);
//   $data->getPostulate($id);

//   echo "<br><br><pre>";
//   $desc = htmlspecialchars_decode($infos["Desc_user"], ENT_QUOTES);
//   print_r($desc);
//   print_r($desc);
//   echo "</pre><br>";
//   echo $twig->render('profil.html.twig', ['session' => $_SESSION, 'album' => $album, 'infos' => $infos, 'comps' => $comps, 'grp' => $grp, 'desc' => $desc, 'id' => $id, 'visible1' => 'visibility: collapse']);
//   $data->getPostulate(18);
// } else {
//   echo "Error : not connected";
// }
