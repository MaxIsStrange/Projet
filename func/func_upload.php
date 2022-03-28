<?php
include_once "func_bdd.php";

class Upload
{
    private dataBDD $data;
    private $name;

    public function __construct($newbdd)
    {
        $this->data = $newbdd;
    }

    public function uploadFile()
    {
        //print_r($_FILES[$this->name]);

        $extAvatar = strtolower(pathinfo($_FILES[$this->name]['name'], PATHINFO_EXTENSION));

        $nameAvatar = "avatar" . $_SESSION['USER_ID'] . "user." . $extAvatar;

        if ($_FILES[$this->name]['size'] >= 5000000) {
            return '1'; //Fichier trop lourd
        } elseif ($extAvatar != "png" && $extAvatar != "jpg" && $extAvatar != "jpeg") {
            return '2'; //Extension incorrecte
        } elseif (file_exists($nameAvatar)) {
            $this->deleteAvatar($nameAvatar);
            return '3'; //Fichier existant
        } else {
            return $nameAvatar; // Is ok
        }
    }

    public function deleteAvatar($file)
    {
        unlink($file);
    }

    public function setOrigin($origin)
    {
        $this->name = $origin;
    }
}

// --------------------------------------------------------

$upload = new Upload($data);
