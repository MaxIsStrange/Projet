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
        foreach ($_SESSION['PERM'] as $perm) {
            array_push($this->list, $perm['ID_perm']);
        }
    }

    function getPerm()
    {
        return $this->list;
    }

    function chkPerm($toChk)
    {
        if (in_array($toChk, $this->list)) {
            return true;
        } else {
            return false;
        }
    }
}

// if (isset($_SESSION['PERM'])) {
//     $perm = new Permissions($data);
// }
