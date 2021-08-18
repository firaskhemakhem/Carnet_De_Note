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


        if(!empty($_POST['gouvernorat'])&&!empty($_POST['delegation'])&&!empty($_POST['nomEcole'])&&!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['anneescolaire'])&&!empty($_POST['mdp'])){

            // affectation de mot de passe 
            $reponse=$pdo->query('SELECT mdp FROM code WHERE used="non"');
            $entree=$reponse->fetch();
            $mdp=$entree['mdp'];
            $mdpeleve=substr($entree['mdp'],0,strlen($entree['mdp'])-1);

            // Affectation de l'id_ecole
            $reponse = $pdo->prepare('SELECT id_ecole FROM ecole WHERE gouvernorat= :gouvernorat AND delegation= :delegation AND libelle= :nomEcole');
            $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'],'delegation' => $_POST['delegation'],'nomEcole' => $_POST['nomEcole']));
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // Ajout du nouvelle élève
            $requete = $pdo->prepare('Insert into eleve(id_ecole, prenom, nom, anneescolaire, mdp) Values('."\"".$idEcole."\"".', :prenom, :nom,:anneescolaire,'."\"".$mdpeleve."\"".')');
            $requete->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'anneescolaire' => $_POST['anneescolaire']));

            // Affirmer que ce mot de passe est utilisé 
            $entree=$pdo->query('UPDATE code SET used = "oui" WHERE mdp='."\"".$mdp."\""); 

            header('Location: index.html');

            /*?>
            <script type="text/javascript">
                alert("Vous êtes maintenant inscrit, connectez-vous!"); //matekhdemch
            </script>
            <?php */
            exit();
        }
        else {
            echo "vous devez remplir tous les champs!";
        }
    }else{

        
        if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['mdp'])){


            $reponse = $pdo->prepare('SELECT nom,prenom, mdp FROM eleve WHERE nom = :nom AND mdp = :mdp AND prenom= :prenom');
            $requete = $reponse->execute(array('nom' =>$_POST['nom'], 'mdp' => $_POST['mdp'], 'prenom' => $_POST['prenom']));
            $entree=$reponse->fetch();

            if((strcmp($entree['nom'],0) == 1)&& (strcmp($entree['mdp'],0) == 1)&&(strcmp($entree['prenom'],0) == 1)){ //s'il est existant

                header('Location: index.php '); // cette page doit etre modifier par la page eleve.html
                exit();
                
            }else{
                header('Location: index.php ');
                exit();
            }
            $reponse->closeCursor();
        }
    }
  }
    
?>
