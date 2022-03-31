<?php
include_once "func/func_session.php";
include_once "func/func_bdd.php";
include_once "func/func_search.php";
include_once "func/func_perm.php";

require_once('vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);


$lastoffers = $data->lastOffre();
$nboffres = $data->getNbOffres();
$nbstages = $data->getNbStages();
$nbinsc = $data->getNbInsc();

// DEBUG

// if (isset($_POST['main-rb'])) {
//   echo "<code><pre><br><br><br>";
//   print_r($searchEngine->search($_POST['main-rb'], 'offre'));
//   //print_r($searchEngine->outputSearch($_POST['main-rb']));
//   //$perm->chkPerm(1) ? "Vous pouvez vous identifier" : "Vous ne pouvez pas vous identifier boloss.");
//   echo "<br></pre></code>";
// }

if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('accueil.html.twig', ['userfname' => $_SESSION['USER_FNAME'], 'cartes' => $lastoffers, 'nboffres' => $nboffres, 'nbstages' => $nbstages, 'nbinsc' => $nbinsc, 'visible1' => 'visibility: collapse', 'visiAdmin' => $visiAdmin]);
} else {

  echo $twig->render('accueil.html.twig', ['userfname' => 'utilisateur', 'cartes' => $lastoffers, 'nboffres' => $nboffres, 'nbstages' => $nbstages, 'nbinsc' => $nbinsc, 'visible2' => 'visibility: collapse', 'visiAdmin' => $visiAdmin]);
}

if (isset($_POST['main-rb'])) {
  $search = htmlspecialchars($_POST['main-rb']);
}



// function debole($data)
// {
//   $output = $data;
//   if (is_array($output))
//     $output = implode(',', $output);

//   echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
// }
