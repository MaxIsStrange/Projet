<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";
include_once "../../func/func_search.php";
include_once "../../func/func_perm.php";

$cartes = [];

$toSearch = isset($_POST['main-rb']) ? $_POST['main-rb'] : '';


    // echo "<code><pre><br><br><br>";
    // echo "Texte de recherche entré : " . $_POST['main-rb'] . "<br>";

    // print_r($searchEngine->search($_POST['main-rb'], 'offre'));



    $offres = $searchEngine->search($_POST['main-rb'], 'offre');

    // echo "<br>";
    // echo "<br></pre></code>";



    foreach ($offres as $idOffre) {
        array_push($cartes, $data->getOffreCard($idOffre['ID_offre'], 0));
    }



$offset = 0;


// echo "<code><pre><br>";
// print_r($cartes);
// echo "<br></pre></code>";

if (empty($cartes)) {
    $msg = "Aucune offre trouvée avec cette recherche.";
} else {
    $msg = '';
}
$i = 0;
$limit = 9000;
//array_splice($cartes,$i);
require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

if (isset($_SESSION['USER_FNAME'])) {
    echo $twig->render('tracker_offre.html.twig', ['cartes' => $cartes, 'msg' => $msg, 'limit' => $limit, 'i' => $i, 'visible1' => 'visibility: collapse', 'visiAdmin' => $_SESSION['ADMIN']]);
} else {
    echo $twig->render('tracker_offre.html.twig', ['cartes' => $cartes, 'msg' => $msg, 'limit' => $limit, 'i' => $i, 'visible2' => 'visibility: collapse',  'visiAdmin' => $_SESSION['ADMIN']]);
}
// 'cartes' => $lastoffers,'nboffres' => $nboffres,'nbstages'=>$nbstages,'nbinsc' => $nbinsc