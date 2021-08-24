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

            //Affectation d'un enseignant
            if((strcmp($_POST['manipuler'],"Affecter")==0)){
    
                if(!empty($_POST['idEnseign'])&&!empty($_POST['idClasse'])&& !empty($_POST['idMatiere']) && !empty($_POST['annee'])){
    
                    // Recuperation de l'id_Ecole
                    $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
                    $entree=$reponse->fetch();
                    $idEcole=$entree['id_ecole'];
        
                    //verification 
                    $request=$pdo->prepare('SELECT id_enseignant FROM affectation WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe= :classe AND id_matiere= :matiere AND anneescolaire= :annee');
                    $request->execute(array('classe' => $_POST['idClasse'],'matiere' => $_POST['idMatiere'],'annee'=>$_POST['annee']));
                    $entree=$request->fetch();
                    if($entree){
                        ?>
                        <script type="text/javascript">
                            alert("Enseignant déjà affecté pour cette classe et cette matiére!");
                            window.location.href = "Administration.php"
                        </script>
                        <?php 
                    }else{
                    // Affectation de l'enseignant
                    $requete = $pdo->prepare('Insert into affectation(id_ecole, id_enseignant ,id_classe, id_matiere, anneescolaire) Values('."\"".$idEcole."\"".',:idEnseign, :idClasse, :idMatiere,:annee)');
                    $requete->execute(array('idEnseign' => $_POST['idEnseign'],'idClasse' => $_POST['idClasse'],'idMatiere' => $_POST['idMatiere'],'annee'=>$_POST['annee']));
    
                    ?>
                    <script type="text/javascript">
                     alert("Affectation de l'enseignant est effectuée avec succées!");
                      window.location.href = "Administration.php"
                   </script>
                   <?php 
                    }
            }else {
                ?>
                <script type="text/javascript">
                    alert("Vous devez remplir tout les champs!");
                    window.location.href = "Administration.php"
                </script>
                <?php 
             } 
               
            //Gestion des enseignant (Ajout, suppression, modification)
        }else{
            if((!empty($_POST['manipuler']))){

                if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['genre']) && !empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){

                    // Ajout de l'Enseignant
                    if((strcmp($_POST['manipuler'],"Ajouter")==0)){
            
                        // Affectetaion de l'id_Ecole
                        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
                        $entree=$reponse->fetch();
                        $idEcole=$entree['id_ecole'];

                        $request=$pdo->prepare('SELECT id_enseignant FROM enseignant WHERE genre= :genre AND prenom= :prenom AND nom= :nom AND login= :login AND mdp= :mdp AND email= :email');
                        $request->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
                        $retour=$request->fetch();
                        if($retour){
                            ?>
                            <script type="text/javascript">
                                alert("Enseignant déjà existant!");
                                window.location.href = "Administration.php"
                            </script>
                            <?php 
                        }else{
                            // Creaction de l'enseignant 
                            $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values('."\"".$idEcole."\"".',:genre, :prenom, :nom,:login,:mdp, :email)');
                            $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login'=>$_POST['login'], 'email' => $_POST['email'] , 'mdp' => $_POST['mdp']));
                            ?>
                            <script type="text/javascript">
                                alert("Creation d'un enseignant effectuée avec succées!");
                                window.location.href = "Administration.php"
                            </script>
                            <?php 
                        }
                    }
                    // Modification d'un Enseignant
                    if((strcmp($_POST['manipuler'],"Modifier")==0)){
            
                        if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['genre']) && !empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){

                            $reponse = $pdo->prepare('SELECT id_enseignant FROM enseignant WHERE nom= :nom AND prenom= :prenom AND genre= :genre AND login= :login AND email= :email AND mdp= :mdp');
                            $reponse->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
                            $entree=$reponse->fetch();
                            if($entree){
                                $idEnseignant=$entree['id_enseignant'];
                                $_SESSION['id_enseignat']=$idEnseignant;
                                header('Location: AdminModifEnseign.php ');
                                exit();
                                $reponse->closeCursor();
                            }else{
                                ?>
                                <script type="text/javascript">
                                    alert("L'enseignant n'existe pas!");
                                    window.location.href = "Administration.php"
                                </script>
                                <?php 
                            }
                            
                        }
                    }
                    //Suppression d'un Enseignant
                    if((strcmp($_POST['manipuler'],"Supprimer")==0)){
            
                        // Affectetaion de l'id_Ecole
                        $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
                        $entree=$reponse->fetch();
                        $idEcole=$entree['id_ecole'];

                        $request=$pdo->prepare('SELECT id_enseignant FROM enseignant WHERE genre= :genre AND prenom= :prenom AND nom= :nom AND login= :login AND mdp= :mdp AND email= :email');
                        $request->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
                        $retour=$request->fetch();
                        if($retour){
                            $requete=$pdo->prepare('DELETE FROM enseignant WHERE id_ecole='."\"".$idEcole."\"".'AND genre= :genre AND prenom= :prenom AND nom= :nom AND login= :login AND mdp= :mdp AND email= :email');
                            $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
                            ?>
                            <script type="text/javascript">
                                alert("Suppression de l'enseignant effectuée avec succées!");
                                window.location.href = "Administration.php"
                            </script>
                            <?php 
                        }else{
                            ?>
                            <script type="text/javascript">
                                alert("L'enseignant n'existe pas!");
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
        
     

        }

}
    
?>