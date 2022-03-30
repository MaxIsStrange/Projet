<?php
include_once 'func_bdd.php';

class Permissions
{

    private dataBDD $data;

    private $list = [];

    public function __construct($newData)
    {
        $this->data = $newData;
        $this->parPerm();
    }

    function parPerm()
    {
        if (!empty($_SESSION['PERM'])) {
        array_push($this->list, 0);
        foreach ($_SESSION['PERM'] as $perm) {
            array_push($this->list, $perm['ID_perm']);
        }
    }
    }

    function getPerm()
    {
        return $this->list;
    }

    function chkPerm($toChk)
    {
        foreach ($this->list as $perm) {
            if ($toChk === $perm) {
                return true;
            }
        }
            return false;
        
    }
}


    $perm = new Permissions($data);

