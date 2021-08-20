<?php
session_start();

if(!empty($_POST['ModifEleve'])){
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
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['anneescolaire']) && !empty($_POST['niveau']) &&!empty($_POST['classe']) && !empty($_POST['mdp'])){
        // Enregistrement des modifications 
        if((strcmp($_POST['ModifEleve'],"Enregistrer")==0)){
            $reponse = $pdo->prepare('UPDATE eleve SET  prenom= :prenom,nom= :nom, anneescolaire= :annee, mdp= :mdp WHERE id_eleve='."\"".$_SESSION['id_eleve']."\"");
            $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
            header('Location: EnseignantPage.php ');
            exit();
            $reponse->closeCursor();
        }
        // Annuler
        if((strcmp($_POST['ModifEleve'],"Annuler")==0)){
            header('Location: EnseignantPage.php ');
            exit();
        }
        else{
            ?>
            <script type="text/javascript">
                alert(" Vous devez remplir tout les champs !");
            </script>
            <?php
        }
    }
}
?>