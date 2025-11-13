<?php
    session_start();

    /**
     * @Class Session
     * Contains all constant providing an handy way to access session variables
     */
    class Session {
        const UserID = "userID"; /** @var string UserID Handy way to select ID variable's index for session  */
    }

    define('MYSQL_SERVEUR', 'localhost');
    define('MYSQL_UTILISATEUR', 'root');
    define('MYSQL_MOTDEPASSE', '');
    define('MYSQL_BASE', 'mdisque');
    
    /*
    $mysql = new MySQLi(MYSQL_SERVEUR,
                        MYSQL_UTILISATEUR,
                        MYSQL_MOTDEPASSE,
                        MYSQL_BASE);
    
    if ($mysql->connect_errno) {
        throw new RuntimeException('MySQL connection error');
    }
    */

    try{
        $mysql = new PDO('mysql:host=;dbname=mdisque;charset=utf8', 'root', '');
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    
    /**
     * @Function getCommands
     * Return an array with all command ordered by the client with id $userID
     */
    function getCommands(string $userID) {
        global $mysql;  // access global variable $mysql 
        $array = [];

        $statement = $mysql->prepare("SELECT command.id,products.title,command.price FROM command, products WHERE (command.UserID = :id AND command.ProductID = products.id)");
        $statement->bindParam(':id', $userID, PDO::PARAM_INT);
        $statement->execute();
        
        foreach($statement->fetchAll() as $command) {
            if (!isset($array[$command['id']])) $array[$command['id']] = [];
            array_push($array[$command['id']], ['title' => $command['title'], 'price'=> $command['price']] );
        }
        return $array; 
    }


    function login() {
        global $mysql;

        if(isset($_POST['pseudo']) && isset($_POST['pass'])){

            $req = $mysql->prepare('SELECT id, password FROM userinfos WHERE username = :pseudo');
            # $req->execute(array('pseudo' => $_POST['pseudo'])); security fail
            $req->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $req->execute();

            $resultat = $req->fetch();

            // Comparaison du pass envoyé via le formulaire avec la base
            $isPasswordCorrect = password_verify($_POST['pass'], $resultat['password']);

            if (!$resultat){
                /* EDIT ************************ */ /* before echo <span class="error"> ... </span> */
                return 'Mauvais identifiant ou mot de passe !';
                /*_ **************************** */
            } else {
                if ($isPasswordCorrect) {
                    $_SESSION[Session::UserID] = $resultat['id'];
                    header('Location: disques.php');
                } else {
                    /* EDIT ************************ */
                    return 'Mauvais identifiant ou mot de passe !';
                    /*_ **************************** */
                }
            }
        } else {
            /* EDIT ************************ */ /* before nothing */
            return false;
            /*_ **************************** */
        }
    }

    function register() {
        global $mysql;

        if( isset($_POST['pseudo']) && isset($_POST['pass']) && isset($_POST['mail']) ) {

            $req = $mysql->prepare('SELECT username, mail FROM userinfos WHERE (mail = :mail OR username = :username)');
            $req->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
            $req->bindParam(':username', $_POST['pseudo'], PDO::PARAM_STR);
            $req->execute();
            $result = $req->fetchAll();

            if (sizeof($result) == 0) {
                $req = $mysql->prepare('INSERT INTO userinfos (username, password, mail) VALUES (:username, :password,:mail)');
                $req->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
                $req->bindParam(':username', $_POST['pseudo'], PDO::PARAM_STR);
                $req->bindValue(':password', password_hash( $_POST['pass'], PASSWORD_DEFAULT), PDO::PARAM_STR);
                $req->execute();

                login(); #header('Location: disques.php');

            } else {
                return "Il y a deja un compte avec ce pseudo ou email";
            }
        }
    }

    function getDisqueID($disque) {
        global $mysql;

        $req = $mysql->prepare('SELECT id FROM Products WHERE Products.title = :title');
        $req->bindParam(':title', $disque , PDO::PARAM_STR);
        $req->execute();

        return $req->fetchAll()[0]['id'];
    }

    function registerCommand($disques) {
        global $mysql;

        $req = $mysql->prepare('INSERT INTO command(userid, productid, price) VALUES (:userid, :productid, :price)');
        $req->bindParam(':userid', $_SESSION[Session::UserID], PDO::PARAM_INT);
        $req->bindValue(':productid', getDisqueID($disques[0]), PDO::PARAM_STR);
        $req->bindValue(':price', 7.5, PDO::PARAM_STR);
        $req->execute();

        foreach ($disques as $i => $disque) {
            if ($i >= 1) {
                $req = $mysql->prepare('INSERT INTO command(id, userid, productid, price) VALUES (LAST_INSERT_ID(), :userid, :productid, :price)');
                $req->bindParam(':userid', $_SESSION[Session::UserID], PDO::PARAM_INT);
                $req->bindValue(':productid', getDisqueID($disque), PDO::PARAM_STR);
                $req->bindValue(':price', 7.5, PDO::PARAM_STR);
                $req->execute();
            }
        }
    }

    function getProducts() {
        global $mysql;
        return $mysql->query("SELECT id,title FROM products")->fetchAll();
    }
?>