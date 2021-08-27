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

    //inscription d'un enseignant
    if((strcmp($_POST['envoi'],"Envoyer")==0)){

        if(!empty($_POST['gouvernorat'])&&!empty($_POST['delegation'])&&!empty($_POST['nomEcole'])&&!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['email'])&&!empty($_POST['genre'])&&!empty($_POST['login'])&&!empty($_POST['mdp'])){
            
            // Affectetaion de l'id_Ecole
            $reponse = $pdo->prepare('SELECT id_ecole FROM ecole WHERE gouvernorat= :gouvernorat AND delegation= :delegation AND libelle= :nomEcole');
            $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'],'delegation' => $_POST['delegation'],'nomEcole' => $_POST['nomEcole']));
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // affectation de mot de passe 
            $reponse=$pdo->query('SELECT mdp FROM code WHERE used="non"');
            $entree=$reponse->fetch();
            $mdp=$entree['mdp'];
            $mdpenseing=substr($entree['mdp'],0,strlen($entree['mdp'])-1);

            // Craction de l'enseignant 
            $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values('."\"".$idEcole."\"".',:genre, :prenom, :nom,:login,'."\"".$mdpenseing."\"".', :email)');
            $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login'=>$_POST['login'], 'email' => $_POST['email']));

            // Affirmer que ce mot de passe est utilisé 
            $entree=$pdo->query('UPDATE code SET used = "oui" WHERE mdp='."\"".$mdp."\""); 

            ?>
            <script type="text/javascript">
                alert("Vous êtes inscrit, vous pouvez vous connecter!");
                window.location.href = "index.php"
            </script>
            <?php 
        }
        else {
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!");
                window.location.href = "index.php"
            </script>
            <?php 
        }

        //connexion d'un enseignant:
    }else{ 

        if(!empty($_POST['loginEnseing'])&&!empty($_POST['mdpEnseing'])){

            $reponse = $pdo->prepare('SELECT id_enseignant,id_ecole,login,mdp FROM enseignant WHERE login = :login AND mdp = :mdp');
            $requete = $reponse->execute(array('login' =>$_POST['loginEnseing'], 'mdp' => $_POST['mdpEnseing']));
            $entree=$reponse->fetch();

            if($entree){ //s'il est existant
                
                $request=$pdo->query('SELECT anneescolaire FROM affectation WHERE id_ecole='."\"".$entree['id_ecole']."\"".' AND id_enseignant='."\"".$entree['id_enseignant']."\"");
                $test=$request->fetch();

                $_SESSION['loginEnseing'] = $_POST['loginEnseing'];
                $_SESSION['mdpEnseing'] = $_POST['mdpEnseing'];
                $_SESSION['id_enseignant'] = $entree['id_enseignant'];
                $_SESSION['id_ecole'] = $entree['id_ecole'];
                $_SESSION['anneescolaire'] = $test['anneescolaire'];
                header('Location: EnseignantPage.php ');
                exit();
            }else{
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