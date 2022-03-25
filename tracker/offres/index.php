<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_session.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_bdd.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_search.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/func/func_perm.php";

if (isset($_POST['main-rb'])) {
    echo "<code><pre><br><br><br>";
    echo "Texte de recherche entré : " . $_POST['main-rb'] . "<br>";
    
    print_r($searchEngine->search($_POST['main-rb']));



    $offres = $searchEngine->search($_POST['main-rb']);

    echo "<br>";
    echo "<br></pre></code>";
}

$cartes = [];

foreach ($offres as $idOffre) {
    array_push($cartes, $data->getOffreCard($idOffre['ID_offre']));
}
echo "<code><pre><br>";
print_r($cartes);
echo "<br></pre></code>";

if (empty($cartes)) {
    $msg = "Aucune offre trouvée avec cette recherche.";
} else {
    $msg = '';
}

require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('tracker_offre.html.twig', ['cartes' => $cartes, 'msg' => $msg]);

// 'cartes' => $lastoffers,'nboffres' => $nboffres,'nbstages'=>$nbstages,'nbinsc' => $nbinsc