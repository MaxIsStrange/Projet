<?php
include_once "func/func_session.php";
include_once "func/func_bdd.php";

include_once "func/func_perm.php";


  require_once('vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
$lastoffers = $data->lastOffre();

// if (isset($perm)) {
// echo "<code><pre><br><br><br>";
//   print_r($_SESSION);
  
//   //$perm->chkPerm(1) ? "Vous pouvez vous identifier" : "Vous ne pouvez pas vous identifier boloss.");
// echo "<br></pre></code>";
// }

if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('accueil.html.twig', ['userfname' => $_SESSION['USER_FNAME'], 'cartes' => $lastoffers]);
} else {
  
  echo $twig->render('accueil.html.twig', ['userfname' => 'utilisateur', 'cartes' => $lastoffers]);
}



// function debole($data)
// {
//   $output = $data;
//   if (is_array($output))
//     $output = implode(',', $output);

//   echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
// }
