<?php session_start();

if (isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 1 || $_SESSION['ROLE'] == 2)) {
    $visiAdmin = null;
} else {
    $visiAdmin = "visibility: collapse;";
}
