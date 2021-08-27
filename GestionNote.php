<?php
session_start();

if((!empty($_POST['ModifNote']))){

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
    if(strcmp($_POST['ModifNote'],'Enregistrer')==0){
        // recuperation de l'id_matiere
        $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole']; 
        // recuperation de l'id_eleve 
        $request=$pdo->query('SELECT * FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$_SESSION['id_classe']."\""); 
        $idEleve=$lecture['id_eleve'];
        //recuperation de l'id_matiere 
        $requestte=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"".' AND niveau='."\"".$_SESSION['niveau']."\"");
        while($notice=$requestte->fetch()){
            $NomMatiere=$notice['libelle'];
            $idMatiere=$notice['id_matiere'];
            $nameinput=$NomMatiere."|".$idEleve;
            $insNote=$pdo->query('UPDATE note SET note='."\"".$_POST[$nameinput]."\"".' WHERE id_ecole='."\"".$idEcole."\"".' AND id_eleve='."\"".$idEleve."\"".' AND id_matiere='."\"".$idMatiere."\"");
        }
        ?>
            <script type="text/javascript">
                alert("Mise a jour des notes est effectué avec succées "); 
                window.location.href = "EnseignantPage.php" ;
            </script>
        <?php
    }
    if(strcmp($_POST['ModifNote'],'Annuler')==0){
        header('Location: EnseignantPage.php');
        exit();
    }
}
?>