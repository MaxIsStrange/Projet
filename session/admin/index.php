<?php
  include_once "../../func/func_session.php";
  include_once "../../func/func_bdd.php";
  include_once "../../func/func_search.php";

if (empty($visiAdmin)) {
  header("Location: ../../");
}

  require_once('../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../templates');
  $twig = new \Twig\Environment($loader);

  $pilotes=$data->getUserByGroup(2);
    if(isset($_POST["perm-rb"])){
      $usermail=$searchEngine -> search($_POST["perm-rb"],'user');
      $user = $data->getUser($usermail["0"]["0"],'one');
      $album= $data->getAlbum($user["ID_user"],'user');
      $perms=$data->getPerm($user["ID_user"]);
      $group=$data->getGroupID($user["ID_user"]);
  echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes, 'perm' => $perms, 'user' => $user, 'avataruser' => $album["Avatar_album"], 'group' => $group, 'session' => $_SESSION, 'visiAdmin' => $visiAdmin]);
} elseif (isset($_POST["user"])) {
      $iduser = $_POST["user"];
      array_pop($_POST);
      foreach($_POST as $perm){
        $data->setPerm($iduser,$perm);

      }

  echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes, 'session' => $_SESSION, 'visible1' => 'visibility: collapse']);
} elseif (isset($_POST["userg"]))
          {
          $data->setPermByGroup($_POST["userg"],$_POST["group"]);
          $user = $data->getUserById($_POST["userg"]);
          $album= $data->getAlbum($user["ID_user"],'user');
          $perms=$data->getPerm($user["ID_user"]);
          $group=$data->getGroupID($user["ID_user"]);
  echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes, 'perm' => $perms, 'user' => $user, 'avataruser' => $album["Avatar_album"], 'session' => $_SESSION, 'visible1' => 'visibility: collapse',  'visiAdmin' => $visiAdmin]);
        }

    elseif(isset($_POST["user-rb"])){
      $usermail=$searchEngine -> search($_POST["user-rb"],'user');

      $allMails =[];

      foreach($usermail as $mail) {
        array_push($allMails,$mail['Mail_User']);
      }

      $allData =[];

      foreach($allMails as $mails){
        array_push($allData,$data->getUser($mails,'all'));
      }

      $allAlbums = [];

      foreach($allData as $dataede){
        array_push($allAlbums,$data->getAlbum($dataede[0]['ID_user'],'user'));
      }
      $fusion=[];

      foreach($allData as $datac){
        array_push($fusion, $datac);
      }
      for ($i=0;$i <= count($allAlbums);$i++){
        if (!empty($allAlbums["$i"])){
          array_push($fusion["$i"]["0"],$allAlbums["$i"]["Avatar_album"]);
        }
      }

  echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes, 'session' => $_SESSION, 'cartes' => $fusion, 'visible1' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
} else {
  echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes, 'session' => $_SESSION, 'visible1' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
}
