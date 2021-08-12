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
   

            $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values(2,:genre, :prenom, :nom,:login,:mdp, :email');
            $requete->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'email' => $_POST['email'],'mdp'=>$_POST['mdp'], 'genre' => $_POST['genre'], 'login' => $_POST['login']));


            header('Location: ForumulaireEnseignant.html');
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
            $requete->closeCursor();
        }
    }
  }
    
?>