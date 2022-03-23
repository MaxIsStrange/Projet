<?php
include_once "func_bdd.php";


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

            //On redirige sur l'accueil
            header("Location: ../index.php");

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

        //On récupère les informations de l'utilisateur
        $user_info = $this->data->getUser($_SESSION['USER_MAIL']);

        //On récupère le nom et prénom
        $_SESSION['USER_NAME'] = $user_info['Nom_user'];
        $_SESSION['USER_FNAME'] = $user_info['Prenom_user'];

        //On récupère le role de l'utilisateur et ses permissions
        $_SESSION['ROLE'] = $this->data->getRole($id);
        $_SESSION['PERM'] = $this->data->getPerm($id);
    }

    function inscription($mail, $tabInfo)
    {
        echo "<br><br> ############# OUAIS ! ############ <br><br>";
        if (!$this->data->chkMail($mail)) {

            $adr = [
                'num' => $tabInfo['num'],
                'rue' => $tabInfo['rue'],
                'cp' => $tabInfo['cp'],
                'city' => $tabInfo['city'],
                'pays' => $tabInfo['pays'],
                'comp' => $tabInfo['comp']
            ];

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
                'idGrp' => 4
            ];

            $this->data->addUser($user);

            $result = [
                $user,
                $adr
            ];

            return $result;
        } else {
            echo "Cette addresse mail existe déjà ! ";
        }
    }

    
}





// ------------------------------------ CREATION DES OBJETS ----------------------------------
$log = new login($data);
