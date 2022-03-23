<?php
include_once "func/func_session.php";
include_once "func/func_bdd.php";

  require_once('vendor/autoload.php');
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

echo "<code><pre><br>";
print_r($data->lastOffre());
echo "<br></pre></code>";

if (isset($_SESSION['USER_FNAME'])) {
  echo $twig->render('accueil.html.twig', ['userfname' => $_SESSION['USER_FNAME']]);
} else {
  echo $twig->render('accueil.html.twig', ['userfname' => 'utilisateur']);
}

function debole($data)
{
  $output = $data;
  if (is_array($output))
    $output = implode(',', $output);

  echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
