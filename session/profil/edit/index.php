<?php
include_once "../../../func/func_session.php";
include_once "../../../func/func_login.php";
include_once "../../../func/func_upload.php";


echo "<code><pre><br><br><br>";

// IMAGE
if (isset($_POST['sub-img']) && isset($_FILES['img_pp'])) {

  $upload->setOrigin("img_pp");

  $result = $upload->uploadFile('Avatar', $_SESSION['USER_ID']);

  switch ($result) {
    case '1':
      echo "ERREUR : Fichier trop grand";
      break;

    case '2':
      echo "ERREUR : Extension incorrecte";
      break;

    case '3':
      echo "ERREUR : Fichier déjà existant";

      break;

    default:
      $pathRel = "../../../docs/avatar/" . $result;
      $pathURL = "https://hsbay.space/cesi/stagetracker/docs/" . $result;

      move_uploaded_file($_FILES["img_pp"]["tmp_name"],  $pathRel);

      echo "<img src='" . $result . "'>";
      echo "<br>URL : $pathURL";
      echo "<br>RELATIF : $pathRel";
      break;
  }
}
//    1 : Fichier trop grand
//    2 : Extension incorrecte
//    3 : Fichier existant
//    4 : OK


echo "<br></pre></code>";








  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

  echo $twig->render('edit.html.twig', ['userfname' => 'Fabien']);
