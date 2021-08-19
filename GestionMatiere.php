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
    
    if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&& !empty($_POST['coefficient'])){

        // Ajout de la matiere
        if((strcmp($_POST['manipuler'],"Ajouter")==0)){

        // Affectetaion de l'id_Ecole
        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole'];


        // Creaction de la matiere
        $requete = $pdo->prepare('Insert into matiere (id_ecole, niveau, libelle, coefficient) Values('."\"".$idEcole."\"".',:niveau, :libelle, :coefficient )');
        $requete->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient'] ));

        }
        // Modification d'une Matiere 
        if((strcmp($_POST['manipuler'],"Modifier")==0)){

            if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&& !empty($_POST['coefficient'])){

                $reponse = $pdo->prepare('SELECT id_matiere FROM matiere WHERE niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient ');
                $reponse->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient'] ));
                $entree=$reponse->fetch();
                $idMatiere=$entree['id_matiere'];
                
                if((strcmp($_POST['ModifMatiere'],"Enregistrer")==0)){
                    if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&& !empty($_POST['coefficient'])){
                        $reponse = $pdo->prepare('UPDATE matiere SET niveau= :niveau, libelle= :libelle, coefficient= :coefficient WHERE id_matiere = '."\"".$idMatiere."\"");
                        $reponse->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient'] ));
                    }
                }
            }
        }

    /***************************************** */



    // Suppression d'une matière 
    if((strcmp($_POST['manipuler'],"Supprimer")==0)){
        $requete=$pdo->prepare('DELETE FROM matiere WHERE niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient)');
        $requete->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
        echo "enseignant supprimé !";
        }
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