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

    if((strcmp($_POST['envoi'],"Connexion")==0)){

        if(!empty($_POST['nomEleve'])&&!empty($_POST['prenomEleve'])&&!empty($_POST['mdpEleve'])){

            $reponse = $pdo->prepare('SELECT nom,prenom, mdp,id_ecole,id_eleve FROM eleve WHERE nom = :nom AND mdp = :mdp AND prenom= :prenom');
            $requete = $reponse->execute(array('nom' =>$_POST['nomEleve'], 'mdp' => $_POST['mdpEleve'], 'prenom' => $_POST['prenomEleve']));
            $entree=$reponse->fetch();

            if($entree){ //s'il est existant
                // recuperation des variables de session
                $_SESSION['nomEleve']=$entree['nom'];
                $_SESSION['prenomEleve']=$entree['prenom'];
                $_SESSION['mdpEleve']=$entree['mdp'];
                $_SESSION['id_ecole']=$entree['id_ecole'];
                $_SESSION['id_eleve']=$entree['id_eleve'];
                //redirection 
                header('Location: ElevePage.php ');
                exit();
                
            }
            else{
                ?>
                <script type="text/javascript">
                    alert("Vous n'êtes pas inscrit!");
                    window.location.href = "../index.php"
                </script>
                <?php 
            }
        }else{
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!");
                window.location.href = "../index.php"
            </script>
            <?php 
        }
    }
}
    
?>
