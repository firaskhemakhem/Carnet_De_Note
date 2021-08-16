<?php
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
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){
        //Suppression d'une enseignant
        if((strcmp($_POST['manipuler'],"Supprimer")==0)){

            $requete=$pdo->prepare('DELETE FROM enseignant WHERE genre= :genre AND prenom= :prenom AND nom= :nom AND login= :login AND mdp= :mdp AND email= :email');
            $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
            echo "enseignant supprimé !";
        }
    }
    else {
        echo "vous devez remplir tous les champs!";
    }

        /*if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!

            $requete = $pdo->prepare('Insert into enseignant(id_ecole,genre,prenom,nom,login,mdp,email) Values(3,:genre,:prenom, :nom,:login,:mdp,:email)');
            $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
            echo" insert successfully !";
        }
        else {
            echo "vous devez remplir tous les champs!";
        }*/

} 
    
?>