<?php
include_once "func_bdd.php";
include_once "func_perm.php";
include_once "func_upload.php";


// Objet gérant la connexion des utilisateurs
class login
{
    // Déclaration d'un objet de gestion des données
    private dataBDD $data;

    public function __construct($newData)
    {
        $this->data = $newData;
    }

    // Gestion de la connexion
    public function chkLogin($mail, $pass)
    {
        //On échappe les caractère html
        $mail = htmlspecialchars($mail);
        $pass = htmlspecialchars($pass);

        // Si le mot de passe est vérifié
        if ($this->verifMDP($pass, $this->data->getMDP($mail))) {

            //On démarre une session
            $this->initSession($mail);

            return true;
        } else {
            return false;
        }
    }

    // Vérification du mot de passe entré
    function verifMDP($mdpIN, $mdpHA)
    {
        // Hachage du mot de passe entré avec le poivre défini
        $mdpIN = hash_hmac("sha256", $mdpIN, $this->data->getPepper());

        //Vérification de la correspondance avec le mot de passe de la BDD
        return password_verify($mdpIN, $mdpHA);
    }

    function hashMDP($mdpIN)
    {
        $mdp_h1 = hash_hmac("sha256", $mdpIN, $this->data->getPepper());
        $mdp_h2 = password_hash($mdp_h1, PASSWORD_BCRYPT);

        return $mdp_h2;
    }

    function initSession($mail)
    {
        //Enregistrement de l'email
        $_SESSION['USER_MAIL'] = $mail;

        //On récupère l'ID correspondant à l'email
        $id = $this->data->getUserID($mail);

        //On garde l'ID de l'utilisateur pour l'insertion de fichiers
        $_SESSION['USER_ID'] = $id;

        //On récupère les informations de l'utilisateur
        $user_info = $this->data->getUser($_SESSION['USER_MAIL'], 'one');

        //On récupère le nom et prénom
        $_SESSION['USER_NAME'] = $user_info['Nom_user'];
        $_SESSION['USER_FNAME'] = $user_info['Prenom_user'];

        //On récupère le role de l'utilisateur et ses permissions
        $_SESSION['ROLE'] = $this->data->getRole($id);
        $_SESSION['PERM'] = $this->data->getPerm($id);
    }

    function inscription($mail, $tabInfo)
    {

        if (!$this->data->chkMail($mail)) {

            $adr = [
                'num' => $tabInfo['num'],
                'rue' => $tabInfo['rue'],
                'cp' => $tabInfo['cp'],
                'city' => $tabInfo['city'],
                'pays' => $tabInfo['pays'],
                'comp' => $tabInfo['comp']
            ];

            global $upload;
            $path = $upload->defaultAvatar($this->data->chkMaxIDUser()['ID_user'] + 1);

            $alb = [
                'ba' => null,
                'lo' => null,
                'av' => $path
            ];

            $this->data->addAlbum($alb);

            $this->data->addAddr($adr);

            $user = [
                'nom' => $tabInfo['name'],
                'prenom' => $tabInfo['fName'],
                'bd' => null,
                'tel' => $tabInfo['tel'],
                'mail' => $mail,
                'step' => 0,
                'pass' => $this->hashMDP($tabInfo['pass']),
                'idAdr' => $this->data->chkMaxIDAdr()['ID_adr'],
                'idGrp' => 4,
                'idAlb' => $this->data->chkMaxIDAlb()['ID_album']
            ];

            $this->data->addUser($user);

            $result = [
                $user,
                $adr,
                $alb
            ];

            return $result;
        } else {
            echo "Cette addresse mail existe déjà ! ";
        }
    }

    public function editBasic($tabInfo)
    {
        $adr = [
            'num' => $tabInfo['num'],
            'rue' => $tabInfo['rue'],
            'cp' => $tabInfo['cp'],
            'city' => $tabInfo['city'],
            'pays' => $tabInfo['pays'],
            'comp' => $tabInfo['comp'],
            'id' => $tabInfo['id_adr']
            //checked
        ];

        $this->data->editAdr($adr);

        $user = [
            //to check
            'nom' => $tabInfo['name'],
            'prenom' => $tabInfo['fName'],
            'bd' => $tabInfo['bd'],
            'tel' => $tabInfo['tel'],
            'desc' => $tabInfo['desc'],
            'id' => $tabInfo['id_user']
        ];
        //to add
        $this->data->editUser($user);

        $result = [
            $user,
            $adr
        ];

        return $result;
    }

    public function editAccount($tabInfo)
    {
        $account = [
            'mail' => $tabInfo['mail'],
            'pass' => $tabInfo['pass'],
            'id' => $tabInfo['id']
        ];

        $this->data->editCredentials($account);
    }
}





// ------------------------------------ CREATION DES OBJETS ----------------------------------
$log = new login($data);
