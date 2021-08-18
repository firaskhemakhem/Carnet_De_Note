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
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['genre']) && !empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){

        // Ajout de l'Enseignant
        // Affectetaion de l'id_Ecole
        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole'];

        /*
        // affectation de mot de passe 
        $reponse=$pdo->query('SELECT mdp FROM code WHERE used="non"');
        $entree=$reponse->fetch();
        $mdp=$entree['mdp'];
        $mdpenseing=substr($entree['mdp'],0,strlen($entree['mdp'])-1);
        $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values('."\"".$idEcole."\"".',:genre, :prenom, :nom,:login,'."\"".$mdpenseing."\"".', :email)');
        */

        // Craction de l'enseignant 
        $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values('."\"".$idEcole."\"".',:genre, :prenom, :nom,:login,:mdp, :email)');
        $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login'=>$_POST['login'], 'email' => $_POST['email'] , 'mdp' => $_POST['mdp']));

        /*
        // Affirmer que ce mot de passe est utilisé 
        $entree=$pdo->query('UPDATE code SET used = "oui" WHERE mdp='."\"".$mdp."\"");  */

        // Modification d'un Enseignant
        

        //Suppression d'un Eenseignant
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