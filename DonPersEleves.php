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

        if(!empty($_POST['prenom'])&&!empty($_POST['nom'])&&!empty($_POST['mdp'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!
            $reponse=$pdo->query('SELECT id_eleve FROM eleve WHERE nom='."\"".$_SESSION['nomEleve']."\"".' AND prenom='."\"".$_SESSION['prenomEleve']."\"".' AND mdp='."\"".$_SESSION['mdpEleve']."\"");
            $entree=$reponse->fetch();
            $idEleve=$entree['id_eleve'];
            $requete = $pdo->prepare('UPDATE eleve SET prenom = :prenom, nom = :nom, mdp = :mdp WHERE id_eleve='."\"".$idEleve."\"");
            $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'mdp'=>$_POST['mdp']));
            if($requete){
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