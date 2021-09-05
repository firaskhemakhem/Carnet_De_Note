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
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
    
    if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&& !empty($_POST['nb'])){

        // Ajout de la classe

        if((strcmp($_POST['manipuler'],"Ajouter")==0)){

        // Affectetaion de l'id_Ecole
        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole'];

        $request=$pdo->prepare('SELECT id_classe FROM classe WHERE nom= :nom AND niveau= :niveau AND nb= :nb');
        $request->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
        $retour=$request->fetch();
        if($retour){
            ?>
            <script type="text/javascript">
                alert("Classe déjà existante!");
                window.location.href = "Administration.php"
            </script>
            <?php 
        }else{
            // Creaction de la classe
            $requete = $pdo->prepare('Insert into classe (id_ecole, niveau, nom, nb) Values('."\"".$idEcole."\"".',:niveau, :nom, :nb )');
            $requete->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb'] ));
            ?>
            <script type="text/javascript">
                alert("Classe ajoutée!");
                window.location.href = "Administration.php"
            </script>
            <?php 
        }

        }
        // Modification d'une classe
        if((strcmp($_POST['manipuler'],"Modifier")==0)){

            if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&& !empty($_POST['nb'])){

                $reponse = $pdo->prepare('SELECT id_classe FROM classe WHERE niveau= :niveau AND nom= :nom AND nb= :nb ');
                $reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb'] ));
                $entree=$reponse->fetch();
                if($entree){
                    $idClasse=$entree['id_classe'];
                    $_SESSION['id_classe']=$idClasse;
                    header('Location: AdminModifClasse.php ');
                    exit();
                    $reponse->closeCursor();
                }else{
                    ?>
                    <script type="text/javascript">
                        alert("La classe n'existe pas!");
                        window.location.href = "Administration.php"
                    </script>
                    <?php 
                }
            }
        }

        // suppression d'une classe
        if((strcmp($_POST['manipuler'],"Supprimer")==0)){

            // Affectetaion de l'id_Ecole
            $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];
                
            $request=$pdo->prepare('SELECT id_classe FROM classe WHERE nom= :nom AND niveau= :niveau AND nb= :nb');
            $request->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
            $retour=$request->fetch();
            if($retour){
                $requete=$pdo->prepare('DELETE FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom AND nb= :nb');
                $requete->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
                ?>
                <script type="text/javascript">
                    alert("Classe supprimé!");
                    window.location.href = "Administration.php"
                </script>
                <?php 
            }else{
                ?>
                <script type="text/javascript">
                    alert("La classe n'existe pas!");
                    window.location.href = "Administration.php"
                </script>
                <?php 
            }
        }
    }else {
        ?>
        <script type="text/javascript">
            alert("Vous devez remplir tout les champs!");
            window.location.href = "Administration.php"
        </script>
        <?php 
     } 

    }
    
?>