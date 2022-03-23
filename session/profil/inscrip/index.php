<?php
include_once "../../../func/func_session.php";
include '../../../func/func_login.php';

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);

  echo $twig->render('inscrip.html.twig', ['userfname' => 'Fabien']);

if (
  isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2'])
  && isset($_POST['name']) && isset($_POST['fname']) && isset($_POST['adr_rue'])
  && isset($_POST['adr_cp']) && isset($_POST['adr_city'])
  && isset($_POST['adr_pays']) && isset($_POST['tel'])
) {
  //Si les mots de passe correspondent
  if ($_POST['pass'] === $_POST['pass2']) {

    $adr_num = isset($_POST['adr_num']) ? htmlspecialchars($_POST['adr_num']) : null;
    $adr_comp = isset($_POST['adr_comp']) ? htmlspecialchars($_POST['adr_comp']) : null;

    $tabInfo = [
      'mail' => htmlspecialchars($_POST['mail']),
      'pass' => htmlspecialchars($_POST['pass']),
      'name' => htmlspecialchars($_POST['name']),
      'fName' => htmlspecialchars($_POST['fname']),

      'rue' => htmlspecialchars($_POST['adr_rue']),
      'cp' => htmlspecialchars($_POST['adr_cp']),
      'city' => htmlspecialchars($_POST['adr_city']),
      'pays' => htmlspecialchars($_POST['adr_pays']),

      'tel' => htmlspecialchars($_POST['tel']),

      'num' => $adr_num,
      'comp' => $adr_comp
    ];

    $result = $log->inscription($tabInfo['mail'], $tabInfo);

    echo "<code><pre><br>";
    print_r($result);
    echo "<br></pre></code>";
  } else {
    echo "Les mots de passe ne correpsondent pas";
  }
}

echo "----------------------------------------------<br>";
echo "----------------------------------------------<br>";
echo "----------------------------------------------";