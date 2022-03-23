<?php

//Objet de connexion à la BDD
class ConnectBDD
{
    private string $dsn;
    private string $user;
    private string $pass;

    private PDO $bdd;

    private string $sql;

    private $res;

    public function __construct()
    {   //Récupération des informations de connexion à la BDD
        $config = parse_ini_file('guvij.ini');

        //Attribution des informations de connexion
        $this->dsn = $config['dsn'];
        $this->user = $config['username'];
        $this->pass = $config['password'];


        try {
            //Ouverture de la connexion
            $this->bdd = new PDO($this->dsn, $this->user, $this->pass);
            //Désactive l'émulation des requètes
            $this->bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            //Affichage du résultat de la connexion
            if ($this->bdd) {
                echo "<br>Connexion réussie.<br><br>";
            }
        } catch (PDOException $e) {
            //Affichage de l'erreur de connexion
            echo "Erreur : " . $e->getMessage();
            die();
        }
    }


    //Execute la requte en fonction des données entrées et des résultats attendus
    public function execQuery($input, $type)
    {
        //Préparation de la requète
        $prep = $this->bdd->prepare($this->sql);

        // echo "<pre>-----";
        // print_r($input);
        // echo "-----</pre>";

        //Execution de la requete préparée avec les données attendues
        $prep->execute($input);

        // Type donne le type de résultat de requete
        switch ($type) {

                // 0 pour un seul résultat
            case '0':
                $this->res = $prep->fetch(PDO::FETCH_LAZY);
                break;

                // 1 pour plusieurs résultats
            case '1':
                $this->res = $prep->fetchAll();
                break;

            default:
                echo "ERREUR";
                break;
        }
    }

    //Donne le résultat de la requète
    public function getResult()
    {
        return $this->res;
    }

    //Définit la requète
    public function setQuery($query)
    {
        $this->sql = $query;
    }

    //Récupère la requète
    public function getQuery()
    {
        return $this->sql;
    }
}


// Objet gérant l'application de la connexion à la BDD
class dataBDD
{
    // Déclaration d'une instance de connexion à la BDD
    private ConnectBDD $conn;

    // Déclaration d'une variable contenant le poivre de hachage
    private string $pepper;

    // Création d'une instance de connexion
    function __construct(ConnectBDD $newconn)
    {
        $this->conn = $newconn;

        $config = parse_ini_file('guvij.ini');
        $this->pepper = $config['pepper'];
    }


    //Donne le poivre utilisé pour l'encryption des mots de passe
    public function getPepper()
    {
        return $this->pepper;
    }

    // --------------------------------------

    //Récupère l'adresse selon l'ID
    public function getAdr($id)
    {
        // Définit la requète
        $this->conn->setQuery("SELECT * FROM Adresse WHERE ID_adr = :id");
        // Execute avec l'ID voulu
        $this->conn->execQuery(['id' => $id], 0);

        $result = $this->conn->getResult();

        echo "<br>----- Adresse : ----- <br><br>" . $result['Num_adr'] . " " . $result['Rue_adr'];

        if (isset($result['Comp_adr'])) {
            echo "<br>" . $result['Comp_adr'];
        }

        echo "<br>" . $result['CP_adr'] . " " . $result['Ville_adr'] . ", " . $result['Pays_adr'];
    }


    public function getRole($id)
    {

        $this->conn->setQuery("SELECT ID_Grp FROM User WHERE ID_user = :id;");
        $this->conn->execQuery(["id" => $id], 0);

        $result = $this->conn->getResult();

        if (isset($result['ID_Grp'])) {
            return $result['ID_Grp'];
        }
    }

    public function getMDP($mail_user)
    {


        $this->conn->setQuery("SELECT MDP_user FROM User WHERE Mail_user = :mail");
        $this->conn->execQuery(['mail' => $mail_user], 0);

        $result = $this->conn->getResult();

        if (isset($result['MDP_user'])) {
            return $result['MDP_user'];
        }
    }

    public function addUser($user)
    {

        //Gérer la duplication d'adresses mail 


        $this->conn->setQuery("INSERT INTO User (Nom_user,Prenom_user,BD_user,Tel_user,Mail_user,Step,MDP_user,ID_adr,ID_Grp)
   VALUES (:nom,:prenom,:bd,:tel,:mail,:step,:pass,:idAdr,:idGrp);");

        $this->conn->execQuery([
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'bd' => $user['bd'],
            'tel' => $user['tel'],
            'mail' => $user['mail'],
            'step' => $user['step'],
            'pass' => $user['pass'],
            'idAdr' => $user['idAdr'],
            'idGrp' => $user['idGrp']
        ], 0);

        return;
    }

    public function getUserID($mail_user)
    {


        $this->conn->setQuery("SELECT ID_user FROM User WHERE Mail_user = :mail");
        $this->conn->execQuery(['mail' => $mail_user], 0);

        $result = $this->conn->getResult();

        if (isset($result['ID_user'])) {

            return $result['ID_user'];
        }
    }

    public function getAlbum($id)
    {
        // Select Avatar_album,Banniere_album,Logo_album,CV_album,LM_album,CS_album,FV_album FROM Album 
        // INNER JOIN User ON User.ID_album=Album.ID_album WHERE ID_user=1;

        $this->conn->setQuery("Select Avatar_album,Banniere_album,Logo_album,CV_album,LM_album,CS_album,FV_album FROM Album 
        INNER JOIN User ON User.ID_album=Album.ID_album WHERE ID_user= :id ;");

        $this->conn->execQuery(['id' => $id], 0);

        $result = $this->conn->getResult();

        return $result;
    }




    public function getUser($mail)
    {

        $id = self::getUserID($mail);

        $this->conn->setQuery("SELECT * FROM User WHERE ID_user = :id");

        $this->conn->execQuery(['id' => $id], 0);

        $result = $this->conn->getResult();

        // echo "<br><br><pre>";
        // print_r($result);
        // echo "</pre><br>";

        return $result;
    }

    public function getPerm($id)
    {

        // SELECT ID_perm FROM User INNER JOIN A_acces ON User.ID_Grp = A_acces.ID_Grp WHERE ID_user = (20);


        $this->conn->setQuery("SELECT ID_perm FROM User INNER JOIN A_acces ON User.ID_Grp = A_acces.ID_Grp WHERE ID_user = :id");

        $this->conn->execQuery(['id' => $id], 1);

        $result = $this->conn->getResult();

        // foreach ($result as $row) {
        //     echo "<br>oui<br><pre>";
        //     print_r($row);
        //     echo "</pre><br>";
        // }



        return $result;
    }


    function chkName($input)
    {
        $this->conn->setQuery("SELECT Nom_user,Prenom_user FROM User WHERE Nom_user = :inputN OR Prenom_User = :inputP");
        $this->conn->execQuery(['inputN' => $input, 'inputP' => $input], 1);

        $result = $this->conn->getResult();

        return $result;
    }

    function chkMail($input)
    {
        $this->conn->setQuery('SELECT (mail_user) from User Where mail_user = :mail;');
        $this->conn->execQuery(['mail' => $input], 0);

        $result = $this->conn->getResult();

        return $result;
    }

    function liveChkName($input)
    {
        $this->conn->setQuery("SELECT Nom_user,Prenom_user FROM User WHERE Nom_user LIKE :inputN OR Prenom_User LIKE :inputP");
        $this->conn->execQuery(['inputN' => "$input" . '%', 'inputP' => "$input" . '%'], 1);

        $result = $this->conn->getResult();

        return $result;
    }
}


















// ------------------------------------ CREATION DES OBJETS ----------------------------------
$conn = new ConnectBDD();
$data = new dataBDD($conn);
