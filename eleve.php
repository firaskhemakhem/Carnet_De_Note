<?php
session_start();
if((!empty($_POST['envoi']))){

    $hostName = "localhost";
    $dbName = "carnetdenote";
    $userName = "root";
    $password = "";
    
    try{
        $pdo = new PDO("mysql:host=$hostName;dbname=$dbName",$userName,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }

    //inscription d'un éléve
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

            ?>
            <script type="text/javascript">
                alert("Vous êtes inscrit, vous pouvez vous connecter!");
                window.location.href = "index.php"
            </script>
            <?php 

            /*?>
            <script type="text/javascript">
                alert("Vous êtes maintenant inscrit, connectez-vous!"); //matekhdemch
            </script>
            <?php */
            exit();
        }
        else {
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!");
                window.location.href = "index.php"
            </script>
            <?php 
        }

        //connexion d'un élève
    }else{

        if(!empty($_POST['nomEleve'])&&!empty($_POST['prenomEleve'])&&!empty($_POST['mdpEleve'])){

            $reponse = $pdo->prepare('SELECT nom,prenom, mdp,id_ecole,id_eleve FROM eleve WHERE nom = :nom AND mdp = :mdp AND prenom= :prenom');
            $requete = $reponse->execute(array('nom' =>$_POST['nomEleve'], 'mdp' => $_POST['mdpEleve'], 'prenom' => $_POST['prenomEleve']));
            $entree=$reponse->fetch();

            if($entree){ //s'il est existant
                // recuperation des variables de session
                $_SESSION['nomEleve']=$entree['nom'];
                $_SESSION['prenomEleve']=$entree['prenom'];
                $_SESSION['mdpEleve']=$entree['mdp'];
                $_SESSION['id_ecole']=$entree['id_ecole'];
                $_SESSION['id_eleve']=$entree['id_eleve'];
                //redirection 
                header('Location: ElevePage.php ');
                exit();
                
            }
            else{
                ?>
                <script type="text/javascript">
                    alert("Vous n'êtes pas inscrit!");
                    window.location.href = "index.php"
                </script>
                <?php 
            }
        }else{
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!");
                window.location.href = "index.php"
            </script>
            <?php 
        }
    }
  }
    
?>
