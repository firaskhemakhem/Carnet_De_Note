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
     /************************************* */
    
     if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&& !empty($_POST['nb'])){

        // Ajout de la classe
        if((strcmp($_POST['manipuler'],"Ajouter")==0)){

        // Affectetaion de l'id_Ecole
        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole'];


        // Creaction de la classe
        $requete = $pdo->prepare('Insert into classe (id_ecole, niveau, nom, nb) Values('."\"".$idEcole."\"".',:niveau, :nom, :nb )');
        $requete->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb'] ));

        }
        // Modification d'une classe
        if((strcmp($_POST['manipuler'],"Modifier")==0)){

            if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&& !empty($_POST['nb'])){

                $reponse = $pdo->prepare('SELECT id_classe FROM classe WHERE niveau= :niveau AND nom= :nom AND nb= :nb ');
                $reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb'] ));
                $entree=$reponse->fetch();
                $idClasse=$entree['id_classe'];
                
                if((strcmp($_POST['ModifClasse'],"Enregistrer")==0)){
                    if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&& !empty($_POST['nb'])){
                        $reponse = $pdo->prepare('UPDATE classe SET niveau= :niveau, nom= :nom, nb= :nb WHERE id_classe = '."\"".$idClasse."\"");
                        $reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb'] ));
                    }
                }
            }
        }

    /***************************************** */


    // suppression d'une classe
    if((strcmp($_POST['manipuler'],"Supprimer")==0)){
        $requete=$pdo->prepare('DELETE FROM classe WHERE niveau= :niveau AND nom= :nom AND nb= :nb)');
        $requete->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
        echo "enseignant supprimé !";
            }
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