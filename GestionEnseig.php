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
                            alert(" Enseignant déjà affecté pour cette classe et cette matiére !");
                        </script>
                        <?php
                    }else{
                    // Affectation de l'enseignant
                    $requete = $pdo->prepare('Insert into affectation(id_ecole, id_enseignant ,id_classe, id_matiere, anneescolaire) Values('."\"".$idEcole."\"".',:idEnseign, :idClasse, :idMatiere,:annee)');
                    $requete->execute(array('idEnseign' => $_POST['idEnseign'],'idClasse' => $_POST['idClasse'],'idMatiere' => $_POST['idMatiere'],'annee'=>$_POST['annee']));
    
                    ?>
                    <script type="text/javascript">
                        alert(" Affectation de l'enseignant effectuée avec succées !");
                    </script>
                    <?php
                      header('Location: Administration.php ');
                      exit();
                      $reponse->closeCursor();
                    }
            }
        }else{

            if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['genre']) && !empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){

                // Ajout de l'Enseignant
                if((strcmp($_POST['manipuler'],"Ajouter")==0)){
        
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
        
                    // Creaction de l'enseignant 
                    $requete = $pdo->prepare('Insert into enseignant(id_ecole, genre,prenom, nom, login, mdp, email) Values('."\"".$idEcole."\"".',:genre, :prenom, :nom,:login,:mdp, :email)');
                    $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login'=>$_POST['login'], 'email' => $_POST['email'] , 'mdp' => $_POST['mdp']));
                    ?>
                    <script type="text/javascript">
                        alert(" Creation du nouveau enseignant effectuée avec succées !");
                    </script>
                    <?php
                      header('Location: Administration.php ');
                      exit();
                      $reponse->closeCursor();
        
                    /*
                    // Affirmer que ce mot de passe est utilisé 
                    $entree=$pdo->query('UPDATE code SET used = "oui" WHERE mdp='."\"".$mdp."\"");  */
                }
                // Modification d'un Enseignant
                if((strcmp($_POST['manipuler'],"Modifier")==0)){
        
                    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['genre']) && !empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){
        
                        $reponse = $pdo->prepare('SELECT id_enseignant FROM enseignant WHERE nom= :nom AND prenom= :prenom AND genre= :genre AND login= :login AND email= :email AND mdp= :mdp');
                        $reponse->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
                        $entree=$reponse->fetch();
                        $idEnseignant=$entree['id_enseignant'];
                        $_SESSION['id_enseignat']=$idEnseignant;
                        header('Location: AdminModifEnseign.php ');
                        exit();
                        $reponse->closeCursor();
                        
                    }
                }
                //Suppression d'un Enseignant
        
                if((strcmp($_POST['manipuler'],"Supprimer")==0)){
        
                    // Affectetaion de l'id_Ecole
                    $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
                    $entree=$reponse->fetch();
                    $idEcole=$entree['id_ecole'];
        
                    $requete=$pdo->prepare('DELETE FROM enseignant WHERE id_ecole='."\"".$idEcole."\"".'AND genre= :genre AND prenom= :prenom AND nom= :nom AND login= :login AND mdp= :mdp AND email= :email');
                    $requete->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
                    ?>
                    <script type="text/javascript">
                        alert(" Suppression de l'enseignant est effectué avec succée !");
                    </script>
                    <?php
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


        }

}
    
?>