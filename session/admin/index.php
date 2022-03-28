<?php
  include_once "../../func/func_session.php";
  include_once "../../func/func_bdd.php";
  include_once "../../func/func_search.php";

  require_once('../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../templates');
  $twig = new \Twig\Environment($loader);

  $pilotes=$data->getUserByGroup(2);

    if(isset($_POST["user-rb"])){
      $usermail=$searchEngine -> search($_POST["user-rb"]);
      $user = $data->getUser($usermail["0"]["0"]);
      $album= $data->getAlbum($user["ID_user"]);
      $perms=$data->getPerm($user["ID_user"]);
      echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,'perm' => $perms, 'user' => $user, 'avataruser' => $album["Avatar_album"]]);
    }
    elseif(isset($_POST["user"])){

      echo "<br><br><pre>";
      print_r($_POST);

      foreach($_POST as $perm){

        print_r($perm);
      }
      echo "</pre><br>";
      echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,]);
    }else{echo $twig->render('admin_panel.html.twig', ['pilotes' => $pilotes,]);}