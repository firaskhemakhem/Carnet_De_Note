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

        if(!empty($_POST['gouvernorat'])&&!empty($_POST['delegation'])&&!empty($_POST['nomEcole'])&&!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['email'])&&!empty($_POST['genre'])&&!empty($_POST['login'])&&!empty($_POST['mdp'])){
   
            $reponse = $pdo->prepare('SELECT id_ecole FROM ecole WHERE gouvernorat= :gouvernorat AND delegation= :delegation AND libelle= :nomEcole');
            $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'],'delegation' => $_POST['delegation'],'nomEcole' => $_POST['libelle']));
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values($idEcole,:genre, :prenom, :nom,:login,:mdp, :email)');
            $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login'=>$_POST['login'], 'mdp' => $_POST['mdp'], 'email' => $_POST['email']));


            header('Location: index.html');
            ?>
            <!--<script type="text/javascript">
                alert("Vous êtes maintenant inscrit, connectez-vous!"); //matekhdemch
            </script>-->

            <?php 
            exit();
        }
        else {
            echo "vous devez remplir tous les champs!";
        }
    }else{

        
        if(!empty($_POST['login'])&&!empty($_POST['mdp'])){


            $reponse = $pdo->prepare('SELECT login,mdp FROM enseignant WHERE login = :login AND mdp = :mdp');
            $requete = $reponse->execute(array('login' =>$_POST['login'], 'mdp' => $_POST['mdp']));
            $entree=$reponse->fetch();

            if((strcmp($entree['login'],0) == 1)&& (strcmp($entree['mdp'],0) == 1)){ //s'il est existant
                header('Location: enseignant.html ');
                exit();
            }else{
                header('Location: FormulaireEnseignant.html ');
                exit();
            }
            $reponse->closeCursor();
        }
    }
  }
    
?>