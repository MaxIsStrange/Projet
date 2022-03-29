<?php
  include_once "../../func/func_session.php";
  include_once "../../func/func_bdd.php";
  include_once "../../func/func_search.php";

  require_once('../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../templates');
  $twig = new \Twig\Environment($loader);

  $pilotes=$data->getUserByGroup(2);
  //print_r($_SESSION);


    if(isset($_POST["user-rb"])){
  $usermail = $searchEngine->search($_POST["user-rb"], 'user');

      $user = $data->getUser($usermail["0"]["0"]);
  $album = $data->getAlbum($user["ID_user"], 'user');
  $perms = $data->getPerm($user["ID_user"]);
  $group = $data->getGroupID($user["ID_user"]);

      echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,'perm' => $perms, 'user' => $user, 'avataruser' => $album["Avatar_album"],'group' => $group,'session' => $_SESSION]);
} elseif (isset($_POST["user"])) {
      $iduser = $_POST["user"];
      array_pop($_POST);
      foreach($_POST as $perm){
        $data->setPerm($iduser,$perm);
      }

      echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,'session' => $_SESSION]);
} elseif (isset($_POST["userg"]))
          {
          $data->setPermByGroup($_POST["userg"],$_POST["group"]);
          $user = $data->getUserById($_POST["userg"]);
          $album= $data->getAlbum($user["ID_user"],'user');
          $perms=$data->getPerm($user["ID_user"]);
          $group=$data->getGroupID($user["ID_user"]);
          echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,'perm' => $perms, 'user' => $user, 'avataruser' => $album["Avatar_album"],'session' => $_SESSION]);
} else {
  echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,]);
}