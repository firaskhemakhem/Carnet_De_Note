<?php
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

    if((strcmp($_POST['envoi'],"Envoyer")==0)){

        if(!empty($_POST['gouvernorat'])&&!empty($_POST['delegation'])&&!empty($_POST['nomEcole'])&&!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['anneescolaire'])&&!empty($_POST['mdp'])){
   

            $requete = $pdo->prepare('Insert into eleve(id_ecole, prenom, nom, anneescolaire, mdp) Values(2, :prenom, :nom,:anneescolaire,:mdp)');
            $requete->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'anneescolaire' => $_POST['anneescolaire'],'mdp'=>$_POST['mdp']));


            header('Location: ForumulaireEleve.html');
            ?>
            <script type="text/javascript">
                alert("Vous êtes maintenant inscrit, connectez-vous!"); //matekhdemch
            </script>
            <?php 
            exit();
        }
        else {
            echo "vous devez remplir tous les champs!";
        }
    }else{

        
        if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['mdp'])){


            $reponse = $pdo->prepare('SELECT nom,prenom, mdp FROM eleve WHERE nom = :nom AND mdp = :mdp AND prenom= :prenom');
            $requete = $reponse->execute(array('nom' =>$_POST['nom'], 'mdp' => $_POST['mdp'], 'prenom' => $_POST['prenom']));
            $entree=$reponse->fetch();

            if((strcmp($entree['nom'],0) == 1)&& (strcmp($entree['mdp'],0) == 1)&&(strcmp($entree['prenom'],0) == 1)){ //s'il est existant
                header('Location: eleve.html ');
                exit();
            }else{
                header('Location: FormulaireEleve.html ');
                exit();
            }
            $requete->closeCursor();
        }
    }
  }
    
?>
