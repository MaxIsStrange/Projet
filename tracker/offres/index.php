<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";
include_once "../../func/func_search.php";
include_once "../../func/func_perm.php";

if (isset($_POST['main-rb'])) {
    echo "<code><pre><br><br><br>";
    echo "Texte de recherche entré : " . $_POST['main-rb'] . "<br>";

    print_r($searchEngine->search($_POST['main-rb'], 'offre'));



    $offres = $searchEngine->search($_POST['main-rb'], 'offre');

    echo "<br>";
    echo "<br></pre></code>";
}

$cartes = [];
$offset = 0;

foreach ($offres as $idOffre) {
    array_push($cartes, $data->getOffreCard($idOffre['ID_offre'],0));
}
echo "<code><pre><br>";
print_r($cartes);
echo "<br></pre></code>";

if (empty($cartes)) {
    $msg = "Aucune offre trouvée avec cette recherche.";
} else {
    $msg = '';
}
$i = 0;
$limit=2-1;
//array_splice($cartes,$i);
require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('tracker_offre.html.twig', ['cartes' => $cartes, 'msg' => $msg,'limit' => $limit, 'i' => $i]);

// 'cartes' => $lastoffers,'nboffres' => $nboffres,'nbstages'=>$nbstages,'nbinsc' => $nbinsc