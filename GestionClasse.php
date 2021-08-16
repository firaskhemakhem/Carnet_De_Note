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

    // suppression d'une classe
    if((strcmp($_POST['manipuler'],"Supprimer")==0)){
        $requete=$pdo->prepare('DELETE FROM classe WHERE niveau= :niveau AND nom= :nom AND nb= :nb)');
        $requete->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
    }

        /*if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&&!empty($_POST['nb'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!

            $requete = $pdo->prepare('Insert into classe(id_ecole,niveau,nom,nb) Values(3,:niveau,:nom,:nb)');
            $requete->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
            echo" insert successfully !";
        }
        else {
            echo "vous devez remplir tous les champs!";
        }*/

    } 
    
?>