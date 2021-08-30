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


    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['anneescolaire']) && !empty($_POST['niveau']) &&!empty($_POST['classe']) && !empty($_POST['mdp'])){

        // Creation de l'élève
        if((strcmp($_POST['manipuler'],"Ajouter")==0)){

            // Affectation de l'id_ecole
            $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // Affectation de l'id_classe
            $reponse=$pdo->prepare('SELECT id_classe FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom');
            $entree=$reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['classe']));
            $entree=$reponse->fetch();
            if($entree){

                $idClasse=$entree['id_classe'];
                // verifier bien que cet enseignant est affectué a cette classe
                $poo= $pdo->query('SELECT id_affectation FROM affectation WHERE id_ecole='."\"".$idEcole."\"".' AND id_enseignant='."\"".$_SESSION['id_enseignant']."\"".' AND id_classe='."\"".$idClasse."\"");
                $doo=$poo->fetch();
                if($doo){
                    // verifier l'affectation de l'élève a cette classe
             
                    $request=$pdo->prepare('SELECT id_eleve FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe= '."\"".$idClasse."\"".' AND prenom= :prenom AND nom= :nom AND anneescolaire= :annee AND mdp= :mdp');
                    $request->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp' => $_POST['mdp']));
                    $test=$request->fetch();
                    if($test){
                        ?>
                        <script type="text/javascript">
                            alert("élève déjà affecté à cette classe!"); 
                            window.location.href = "EnseignantPage.php"
                        </script>
                        <?php 
                    }
                    else{

                        // Creation de l'élève
                        $requete = $pdo->prepare('INSERT INTO eleve (id_ecole,id_classe,prenom,nom,anneescolaire,mdp) Values('."\"".$idEcole."\"".','."\"".$idClasse."\"".',:prenom, :nom,:annee,:mdp)');
                        $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp' => $_POST['mdp']));
                        
                        // recuperation de l'id_eleve affecté
                        $requete = $pdo->prepare('SELECT id_eleve FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$idClasse."\"".'AND prenom= :prenom AND nom= :nom AND anneescolaire= :annee AND mdp= :mdp');
                        $requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp' => $_POST['mdp']));
                        $getid=$requete->fetch();
                        $idEleve=$getid['id_eleve'];
                        
                        // affectation de note 00.00 pour chaque matiere pour ce niveau et cette classe 
                        $requestte=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"".' AND niveau='."\"".$_POST['niveau']."\"");
                        while($notice=$requestte->fetch()){
                            
                            // recuperation de l'id_matiere
                            $idMatiere=$notice['id_matiere'];
                            
                            // affecter la note 00.00 
                            $affectNote=$pdo->query('INSERT INTO note(id_ecole,id_eleve,id_matiere,note) VALUES('."\"".$idEcole."\"".','."\"".$idEleve."\"".','."\"".$idMatiere."\"".',00.00)');
                        }
                        ?>
                        <script type="text/javascript">
                            alert("Ajout de l'élève effectuée avec succées!"); 
                            window.location.href = "EnseignantPage.php"
                        </script>
                        <?php 
                    }
                }
                else{
                    ?>
                        <script type="text/javascript">
                            alert("Vous n'avez pas le droit de manipuler cette classe !"); 
                            window.location.href = "EnseignantPage.php"
                        </script>
                        <?php 
                }

                
            }
            else{
                ?>
                    <script type="text/javascript">
                        alert("Classe non existant pour cette école !"); 
                        window.location.href = "EnseignantPage.php"
                    </script>
                    <?php
            }
             
        }

        // Suppression de l'eleve
        if((strcmp($_POST['manipuler'],"Supprimer")==0)){

            // Affectation de l'id_ecole
            $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];
            

            // Affectation fe l'id_classe
            $reponse=$pdo->prepare('SELECT id_classe FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom');
            $entree=$reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['classe']));
            $entree=$reponse->fetch();

            if($entree){

                $idClasse=$entree['id_classe'];

                $request=$pdo->prepare('SELECT id_eleve FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe= '."\"".$idClasse."\"".' AND prenom= :prenom AND nom= :nom AND anneescolaire= :annee AND mdp= :mdp');
                $request->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
                $test=$request->fetch();

                if(!$test){
                    ?>
                    <script type="text/javascript">
                        alert("élève non exitant!"); 
                        window.location.href = "EnseignantPage.php"
                    </script>
                    <?php 
                }else{
                    // Suppression de l'élève
                    $requete = $pdo->prepare('DELETE FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$idClasse."\"".' AND prenom= :prenom AND nom= :nom AND anneescolaire= :annee AND mdp= :mdp');
                    $reponseee=$requete->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
                    
                    // Suppression des notes pour cette eleve dans tout les matières 
                    $requestte=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"".' AND niveau='."\"".$_POST['niveau']."\"");
                    while($notice=$requestte->fetch()){
                        
                        // recuperation de l'id_matiere
                        $idMatiere=$notice['id_matiere'];
                        
                        // suppression de note pour cette matiere affecter a cet élève 
                        $affectNote=$pdo->query('DELETE FROM note WHERE id_ecole='."\"".$idEcole."\"".' AND id_eleve'."\"".$idEleve."\"".' AND id_matiere='."\"".$idMatiere."\"");
                    }

                    ?>
                    <script type="text/javascript">
                        alert("Suppression de l'élève est effectué avec succées!"); 
                        window.location.href = "EnseignantPage.php"
                    </script>
                    <?php 
                }
            }
            else{
                ?>
                <script type="text/javascript">
                    alert("Classe non existant pour cette école !"); 
                    window.location.href = "EnseignantPage.php"
                </script>
                <?php
            }

        }
        // Modification de lélève
        if((strcmp($_POST['manipuler'],"Modifier")==0)){

            // Affectation de l'id_ecole
            $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];

            // Affectation fe l'id_classe
            $reponse=$pdo->prepare('SELECT id_classe FROM classe WHERE id_ecole='."\"".$idEcole."\"".' AND niveau= :niveau AND nom= :nom');
            $entree=$reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['classe']));
            $entree=$reponse->fetch();
            if($entree){
                // classe existante
                $idClasse=$entree['id_classe'];

                $reponse = $pdo->prepare('SELECT id_eleve FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$idClasse."\"".' AND prenom= :prenom AND nom= :nom AND anneescolaire= :annee AND mdp= :mdp');
                $reponse->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
                $entree=$reponse->fetch();
                
                if($entree){
                    // recuperation de l'id_eleve
                    
                    $idEleve=$entree['id_eleve'];
                    $_SESSION['id_eleve']=$idEleve;
                    $_SESSION['id_ecole']=$idEcole;
                    $_SESSION['id_classe']=$idClasse;
                    $_SESSION['niveau']=$_POST['niveau'];
                    header('Location: EnseignModifEleve.php ');
                    exit();
                    $reponse->closeCursor();
                }else{
                    ?>
                    <script type="text/javascript">
                        alert("élève non existant!"); 
                        window.location.href = "EnseignantPage.php"
                    </script>
                    <?php 
                }
            }
            else{
                ?>
                <script type="text/javascript">
                    alert("Classe non existant!"); 
                    window.location.href = "EnseignantPage.php"
                </script>
                <?php 
            }
            
        }
    }
}

?>