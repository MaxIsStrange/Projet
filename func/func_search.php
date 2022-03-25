<?php
include_once 'func_bdd.php';

class Recherche
{
    private dataBDD $data;

    private array $dico = [];

    public function __construct($newData)
    {
        $this->data = $newData;
        $this->setDico();
    }

    public function setDico()
    {
        $path = "func/dico.json";
        $dicoBrut = file_get_contents($path);

        $dicoNet = json_decode($dicoBrut, true);

        foreach ($dicoNet as $mot) {

            array_push($this->dico, $mot);
        }
    }

    public function search($input)
    {
        $tabInput = explode(" ", $input);

        $result = [];

        foreach ($tabInput as $mot) {

            if (!in_array($mot, $this->dico)) {

                if (preg_match("/'/i", $mot)) {

                    $pos = preg_match("/'/i", $mot, $a, PREG_OFFSET_CAPTURE) + 1;
                    $mot = substr($mot, $pos);
                }

                //Faire un join pour chopper les tags aussi

                $dataEnt = $this->data->searchEnt($mot);
                foreach ($dataEnt as $ent) {
                    array_push($result, $ent);
                }

                $dataOffre = $this->data->searchOffre($mot);
                foreach ($dataOffre as $offre) {
                    array_push($result, $offre);
                }
            }
        }
        return $result;
    }
}

$searchEngine = new Recherche($data);
