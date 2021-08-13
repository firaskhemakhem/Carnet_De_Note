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

        if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!
            $requete = $pdo->prepare('UPDATE administation SET nom = :nom, prenom = :prenom, email = :email, mdp = :mdp');
            $requete->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'email' => $_POST['email'],'mdp'=>$_POST['mdp']));
            echo" updated successfully !";
        }
        else {
            echo "vous devez remplir tous les champs!";
        }

    } 
    
?>
