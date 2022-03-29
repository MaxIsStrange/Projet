<?php
include_once "func_bdd.php";

class Upload
{
    private dataBDD $data;
    private $name;
    private $folder;
    private $type;

    public function __construct($newbdd)
    {
        $this->data = $newbdd;
    }

    public function setType($newType)
    {
        switch ($newType) {
            case 'Avatar':
                $this->folder = 'avatar';
                $this->type = "Avatar";
                break;

            case 'Banniere':
                $this->folder = 'ban';
                $this->type = "Banniere";
                break;

            case 'Convention':
                $this->folder = 'cs';
                $this->type = "ConvStage";
                break;

            case 'Fiche':
                $this->folder = 'fv';
                $this->type = "FicheValid";
                break;

            case 'CV':
                $this->folder = 'cv';
                $this->type = "CV";
                break;

            case 'Motiv':
                $this->folder = 'lm';
                $this->type = "LettreMotiv";
                break;

            case 'Logo':
                $this->folder = 'logo';
                $this->type = "Logo";
                break;

            default:
                return false;
        }
        return true;
    }

    public function uploadFile($type, $id)
    {

        if (!$this->setType($type)) {
            return '4'; //Type incorrect
        }

        $extFile = strtolower(pathinfo($_FILES[$this->name]['name'], PATHINFO_EXTENSION));

        $nameFile = $this->type . $id . "." . $extFile;

        $pathRel = "../../../docs/" . $this->folder . "/" . $nameFile;
        $pathURL = "https://hsbay.space/cesi/stagetracker/docs/" .  $this->folder . "/" . $nameFile;

        if ($_FILES[$this->name]['size'] >= 5000000) {
            echo "<br><br><br>Fichier trop lourd";
            //return '1'; //Fichier trop lourd
        } elseif ($extFile != "png" && $extFile != "jpg" && $extFile != "jpeg") {
            echo "<br><br><br>Extension non supportée";
            //return '2'; //Extension incorrecte

        } else {
            //return $nameFile; // Is ok
            if (file_exists($pathRel)) {

                echo "<br><br><br>Fichier existant, SUPPRESSION";
                $this->deleteFile($pathRel);
            }
            
            echo "<br><br>";

            move_uploaded_file($_FILES[$this->name]["tmp_name"],  $pathRel);

            echo "<img src='" . $pathRel . "' height = '100px' width='100px'>";
            echo "<br>URL : $pathURL <br>";



            return $pathURL;
        }


    }

    // public function chkUpload()
    // {
    //     $result = $this->uploadFile();

    //     switch ($this->uploadFile()) {
    //         case '1':
    //             echo "ERREUR : Fichier trop grand";
    //             break;

    //         case '2':
    //             echo "ERREUR : Extension incorrecte";
    //             break;

    //         case '3':
    //             echo "ERREUR : Fichier déjà existant";

    //             break;

    //         default:
    //             $pathRel = "../../../docs/avatar/" . $result;
    //             $pathURL = "https://hsbay.space/cesi/stagetracker/docs/" . $result;

    //             move_uploaded_file($_FILES["img_pp"]["tmp_name"],  $pathRel);

    //             echo "<img src='" . $result . "'>";
    //             echo "<br>URL : $pathURL";
    //             echo "<br>RELATIF : $pathRel";
    //             break;
    //     }
    // }

    public function deleteFile($file)
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
