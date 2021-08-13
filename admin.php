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

        if(!empty($_POST['gouvernorat'])&&!empty($_POST['delegation'])&&!empty($_POST['nomEcole'])&&!empty($_POST['genre'])&&!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){


            // affectation de mot de passe 
            $reponse=$pdo->query('SELECT mdp FROM code WHERE used="non"');
            $entree=$reponse->fetch();
            $mdp=$entree['mdp'];

            $requete = $pdo->prepare('Insert into administation(id_ecole,genre,prenom,nom,email,mdp,type) Values(3,:genre,:prenom, :nom,:email,'."\"".$mdp."\"".',6)');
            $requete->execute(array('genre' => $_POST['genre'],'nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'email' => $_POST['email']));

            $entree=$pdo->query('UPDATE code SET used = "oui" WHERE mdp='."\"".$mpd."\"");

            header('Location: index.html ');
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

        
        if(!empty($_POST['email'])&&!empty($_POST['mdp'])){


            $reponse = $pdo->prepare('SELECT Email, Mdp FROM administation WHERE Email = :email AND Mdp = :mdp');
            $requete = $reponse->execute(array('email' =>$_POST['email'], 'mdp' => $_POST['mdp']));
            $entree=$reponse->fetch();

            if((strcmp($entree['Email'],0) == 1)&& (strcmp($entree['Mdp'],0) == 1)){ //s'il est existant
                header('Location: administration.html ');
                exit();
            }else{
                
                header('Location: FormulaireAdmin.html ');
                exit();
            }
            $reponse->closeCursor();
        }
    }


  }
    /*
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
    $requete = $pdo->prepare('Insert into administation(id_ecole,genre,prenom,nom,email,mdp,type) Values(3,:genre,:prenom, :nom,:email,"sdvsvsvsvsvvs",6)');
    $requete->execute(array('genre' => $_POST['genre'],'nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'email' => $_POST['email']));
    //$pdo->exec('Insert into administation(id_admin,id_ecole,genre,prenom,nom,email,mdp,type) Values(2,6,"etatique","salah","Mahmoud","exp@emp.tn","ijfoiehfezoih",5)');
    echo "Inscription validée !";
    */
?>
