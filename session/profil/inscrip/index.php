<?php
include_once "../../../func/func_session.php";
include_once '../../../func/func_login.php';
include_once "../../../func/func_mail.php";

  require_once('../../../vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('../../../templates');
  $twig = new \Twig\Environment($loader);





if (
  !empty($_POST['mail']) && !empty($_POST['pass']) && !empty($_POST['pass2'])
  && !empty($_POST['name']) && !empty($_POST['fname']) && !empty($_POST['adr_rue'])
  && !empty($_POST['adr_cp']) && !empty($_POST['adr_city'])
  && !empty($_POST['adr_pays']) && !empty($_POST['tel'])
  && isset($_POST['result']) && ($_POST['result'] == 'valide')
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

    $mailer->setMail('inscri');
    $mailer->sendMail($_POST['mail']);

    echo "<code><pre><br>";
    print_r($result);
    echo "<br></pre></code>";
  } else {
    echo "Les mots de passe ne correspondent pas";
  }
} else {

}


echo $twig->render('inscrip.html.twig', ['visible2' => 'visibility: collapse', 'docRoot' => $_SERVER['DOCUMENT_ROOT']]);
