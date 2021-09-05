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

    
    if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&& !empty($_POST['coefficient'])){

        // Ajout de la matiere
        if((strcmp($_POST['manipuler'],"Ajouter")==0)){

        // Affectetaion de l'id_Ecole
        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole'];

        $request=$pdo->prepare('SELECT id_matiere FROM matiere WHERE niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient');
        $request->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
        $retour=$request->fetch();
        if($retour){
            ?>
            <script type="text/javascript">
                alert("Matière déjà existante!");
                window.location.href = "Administration.php"
            </script>
            <?php 
        }else{
            // Creaction de la matiere
            $requete = $pdo->prepare('Insert into matiere (id_ecole, niveau, libelle, coefficient) Values('."\"".$idEcole."\"".',:niveau, :libelle, :coefficient )');
            $requete->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient'] ));

                ?>
                <script type="text/javascript">
                    alert("Matiére ajoutée!");
                    window.location.href = "Administration.php"
                </script>
                <?php
        }

        }
        // Modification d'une Matiere 
        if((strcmp($_POST['manipuler'],"Modifier")==0)){

            if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&& !empty($_POST['coefficient'])){

                $reponse = $pdo->prepare('SELECT id_matiere FROM matiere WHERE niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient ');
                $reponse->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient'] ));
                $entree=$reponse->fetch();
                if($entree){
                    $idMatiere=$entree['id_matiere'];
                    $_SESSION['id_matiere']=$idMatiere;
                    header('Location: AdminModifMatiere.php ');
                    exit();
                    $reponse->closeCursor();
                }else{
                    ?>
                    <script type="text/javascript">
                        alert("La matière n'existe pas!");
                        window.location.href = "Administration.php"
                    </script>
                    <?php 
                }
            }
        }

       // Suppression d'une matière 
        if((strcmp($_POST['manipuler'],"Supprimer")==0)){

        // Affectetaion de l'id_Ecole
        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
        $entree=$reponse->fetch();
        $idEcole=$entree['id_ecole'];

        $request=$pdo->prepare('SELECT id_matiere FROM matiere WHERE niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient');
        $request->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
        $retour=$request->fetch();

        if($retour){
            $requete=$pdo->prepare('DELETE FROM matiere WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND libelle= :libelle AND coefficient= :coefficient');
            $requete->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
                ?>
                <script type="text/javascript">
                    alert("Matiére supprimé!");
                    window.location.href = "Administration.php"
                </script>
                <?php 
        }
        else{
            ?>
            <script type="text/javascript">
                alert("La matiére n'existe pas!");
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