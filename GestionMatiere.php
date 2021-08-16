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

    // Suppression d'une matière 
    if((strcmp($_POST['manipuler'],"Supprimer")==0)){
        $requete=$pdo->prepare('DELETE FROM matiere WHERE niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient)');
        $requete->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
        
    }

        /*if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&&!empty($_POST['coefficient'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!

            $requete = $pdo->prepare('Insert into matiere(id_ecole,niveau,libelle,coefficient) Values(3,:niveau,:libelle,:coefficient)');
            $requete->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
            echo" insert successfully !";
        }
        else {
            echo "vous devez remplir tous les champs!";
        }*/

    } 
    
?>