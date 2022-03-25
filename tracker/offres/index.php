<?php
include_once "../../func/func_session.php";
include_once "../../func/func_bdd.php";
include_once "../../func/func_search.php";
include_once "../../func/func_perm.php";

if (isset($_POST['main-rb'])) {
    echo "<code><pre><br><br><br>";
    print_r($searchEngine->search($_POST['main-rb']));
    echo "<br></pre></code>";
}


require_once('../../vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader('../../templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('tracker_offre.html.twig', ['cartes' => 12]);

// 'cartes' => $lastoffers,'nboffres' => $nboffres,'nbstages'=>$nbstages,'nbinsc' => $nbinsc