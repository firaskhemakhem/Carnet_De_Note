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
                $_SESSION['nomEleve']=$entree['nom'];
                $_SESSION['prenomEleve']=$entree['prenom'];
                $_SESSION['mdpEleve']=$entree['mdp'];
                ?>
                <script type="text/javascript">
                    alert("Coordonnées mises à jour!"); 
                    window.location.href = "ElevePage.php"
                </script>
                <?php 
            } 
        }
        else {
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!"); 
                window.location.href = "ElevePage.php"
            </script>
            <?php 
        }

    } 
?>