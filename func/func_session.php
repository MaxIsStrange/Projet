<?php session_start();

if (isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 1 || $_SESSION['ROLE'] == 2)) {
    $_SESSION['ADMIN'] = null;
} else {
    $_SESSION['ADMIN'] = "visibility: collapse;";
}
