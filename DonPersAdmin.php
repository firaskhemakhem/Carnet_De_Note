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

        if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){
                // ATTENTION : Garder la session et ne laisser modifier les données personelles que sur l'id de l'utilisateur courant !!!!!!!!
            $requete = $pdo->prepare('UPDATE administration SET nom = :nom, prenom = :prenom, email = :email, mdp = :mdp WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"" );
            $requete->execute(array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'email' => $_POST['email'],'mdp'=>$_POST['mdp']));
            if($requete){
                $_SESSION["emailAdmin"] = $_POST["email"];
                $_SESSION["mdpAdmin"] = $_POST["mdp"];
                ?>
                <script type="text/javascript">
                    alert("Mise à jour effectuée avec succées!");
                    window.location.href = "Administration.php"
                </script>
                <?php 
            }
        }
        else {
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!");
                window.location.href = "Administration.php"
            </script>
            <?php 
        }

    } 
    
?>
