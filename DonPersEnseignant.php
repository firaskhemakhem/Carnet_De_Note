<?php
session_start();

if((!empty($_POST['envoi']))){

    $hostName = "localhost";
    $dbName = "carnetdenote";
    $userName = "root";
    $password = "";
    
    try{
        $pdo = new PDO("mysql:host=$hostName;dbname=$dbName",$userName,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }

        if(!empty($_POST['prenom'])&&!empty($_POST['nom'])&&!empty($_POST['login'])&&!empty($_POST['mdp'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!
            $requete = $pdo->prepare('UPDATE enseignant SET prenom = :prenom, nom = :nom, login = :login, mdp = :mdp WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'mdp'=>$_POST['mdp']));
            if($requete){
                $_SESSION['loginEnseing'] = $_POST['login'];
                $_SESSION['mdpEnseing'] = $_POST['mdp'] ;
                ?>
            <script type="text/javascript">
                alert("Mise à jour des données est effectué avec succée !");
            </script>
            <?php
            } 
        }
        else {
            echo "vous devez remplir tous les champs!";
        }

    } 
    
?>