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

    if((strcmp($_POST['envoi'],"Connexion")==0)){
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
                    window.location.href = "../index.php"
                </script>
                <?php 
            }
        }else{
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!");
                window.location.href = "../index.php"
            </script>
            <?php 
        }
    }
}
    
?>