<?php 
session_start();

if((!empty($_POST['manipuler']))){

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

        // Creation de l'élève
        if((strcmp($_POST['manipuler'],"Ajouter")==0)){

            // Affectation de l'id_ecole
            $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // Affectation fe l'id_classe
            $reponse=$pdo->prepare('SELECT id_classe FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom');
            $entree=$reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['classe']));
            $entree=$reponse->fetch();
            $idClasse=$entree['id_classe'];

            // Creaction de l'élève
            $requete = $pdo->prepare('INSERT INTO eleve (id_ecole,id_classe,prenom,nom,anneescolaire,mdp) Values('."\"".$idEcole.','.$idClasse."\"".',:prenom, :nom,:annee,:mdp)');
            $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
            
            echo "Ajout de l'élève est effectué avec succées !";
        }
        // Suppression de l'eleve
        if((strcmp($_POST['manipuler'],"Supprimer")==0)){

            // Affectation de l'id_ecole
            $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // Affectation fe l'id_classe
            $reponse=$pdo->prepare('SELECT id_classe FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom');
            $entree=$reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['classe']));
            $entree=$reponse->fetch();
            $idClasse=$entree['id_classe'];

            // Suppression de l'élève
            $requete = $pdo->prepare('DELETE FROM eleve WHERE id_ecole='."\"".$idEcole.' AND id_classe='."\"".$idClasse."\"".' AND prenom= :prenom AND nom= :nom AND anneescolaire= :annee AND mdp= :mdp)');
            $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));

            echo "Suppression de l'élève est effectué avec succées !";
        }
        // Modification de lélève
        if((strcmp($_POST['manipuler'],"Modifier")==0)){

            // Affectation de l'id_ecole
            $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // Affectation fe l'id_classe
            $reponse=$pdo->prepare('SELECT id_classe FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom');
            $entree=$reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['classe']));
            $entree=$reponse->fetch();
            $idClasse=$entree['id_classe'];

            // recuperation de l'id_eleve
            $reponse = $pdo->prepare('SELECT id_eleve FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$idClasse."\"".' AND prenom= :prenom AND nom :nom AND anneescolaire= :annee AND mdp= :mdp)');
            $reponse->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
            $entree=$reponse->fetch();
            $idEleve=$entree['id_eleve'];
            $_SESSION['id_eleve']=$idEleve;
            header('Location: EnseignModifEleve.php ');
            exit();
            $reponse->closeCursor();
        }
    }
}

?>