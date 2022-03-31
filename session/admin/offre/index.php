<?php
  include_once "../../../func/func_session.php";
  include_once "../../../func/func_bdd.php";
include_once "../../../func/func_perm.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);


if ($perm->chkPerm(9)) {
  $id = isset($_GET['id']) ? $_GET['id'] : null;
  //echo "<br><br><br>ID : $id";
} else {
  echo "ACCES INTERDIT";
  exit();
}

if (
  !empty($_POST['name']) && !empty($_POST['desc']) && !empty($_POST['titre'])
  && !empty($_POST['salary']) && !empty($_POST['prom']) && !empty($_POST['nbrPoste'])
  && !empty($_POST['duree']) && ($_POST['min'] != 'def') && !empty($_POST['adr_cp'])
  && !empty($_POST['adr_ville']) && !empty($_POST['adr_rue']) && !empty($_POST['adr_pays'])
  && !empty($_POST['min'])
) {
  $dist = !empty($_POST['dist']) ? 1 : 0;
  $adr_num = isset($_POST['adr_num']) ? htmlspecialchars($_POST['adr_num']) : null;
  $adr_comp = isset($_POST['adr_comp']) ? htmlspecialchars($_POST['adr_comp']) : null;

  $tabInfoAdr = [
    'rue' => htmlspecialchars($_POST['adr_rue']),
    'cp' => htmlspecialchars($_POST['adr_cp']),
    'city' => htmlspecialchars($_POST['adr_ville']),
    'pays' => htmlspecialchars($_POST['adr_pays']),
    'num' => $adr_num,
    'comp' => $adr_comp
  ];

  $data->addAddr($tabInfoAdr);

  $tabInfoOffre = [
    'name' => htmlspecialchars($_POST['name']),
    'desc' => htmlspecialchars($_POST['desc']),
    'titre' => htmlspecialchars($_POST['titre']),
    'salary' => htmlspecialchars($_POST['salary']),
    'nbrPoste' => htmlspecialchars($_POST['nbrPoste']),
    'prom' => htmlspecialchars($_POST['prom']),
    'duree' => htmlspecialchars($_POST['duree']),
    'dist' => $dist,
    'min' => $_POST['min'],

    'ID_ent' => $id,
    'ID_adr' => $data->chkMaxIDAdr()['ID_adr']
  ];

  $result = [
    $tabInfoAdr,
    $tabInfoOffre
  ];
  $data->addOffre($tabInfoOffre);

  header('Location: ../../../');

  // echo "<code><pre><br><br>";
  // print_r($result);
  // echo "</pre></code><br><br>";
}

echo $twig->render('add_offre.html.twig', ['visible1' => 'visibility: collapse', 'visiAdmin' => $visiAdmin]);