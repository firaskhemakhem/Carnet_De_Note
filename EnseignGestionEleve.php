<?php
session_start();

if(!empty($_POST['ModifEleve'])){
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
        // Enregistrement des modifications 
        if((strcmp($_POST['ModifEleve'],"Enregistrer")==0)){
            $request=$pdo->prepare('SELECT id_classe FROM classe WHERE niveau= :niveau AND nom= :nom');
            $request->execute(array('niveau' =>$_POST['niveau'], 'nom'=>$_POST['classe']));
            $test=$request->fetch();
            if($test){
                if(strcmp($test['id_classe'],$_SESSION['id_classe'])==0){
                    // pas de changement de classe 
                    $reponse = $pdo->prepare('UPDATE eleve SET prenom= :prenom , nom= :nom, anneescolaire= :annee, mdp= :mdp WHERE id_eleve='."\"".$_SESSION['id_eleve']."\""); 
                    $reponse->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
                }
                else{
                    // changement au niveau de la classe
                    if(strcmp($_POST['niveau'],$_SESSION['niveau'])==0){
                        // pas de changement de niveau 
                        $reponse = $pdo->prepare('UPDATE eleve SET id_classe='."\"".$test['id_classe']."\"".', prenom= :prenom , nom= :nom, anneescolaire= :annee, mdp= :mdp WHERE id_eleve='."\"".$_SESSION['id_eleve']."\""); /*id_eleve='."\"".$_SESSION['id_eleve']."\""*/
                        $reponse->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));
                    }
                    else{
                        // changement de niveau 
                        $reponse = $pdo->prepare('UPDATE eleve SET id_classe='."\"".$test['id_classe']."\"".', prenom= :prenom , nom= :nom, anneescolaire= :annee, mdp= :mdp WHERE id_eleve='."\"".$_SESSION['id_eleve']."\""); /*id_eleve='."\"".$_SESSION['id_eleve']."\""*/
                        $reponse->execute(array('prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'annee' => $_POST['anneescolaire'], 'mdp'=> $_POST['mdp']));

                        // Suppression des notes pour cette eleve dans tout les matières 
                        $requestte=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$_SESSION['id_ecole']."\"".' AND niveau='."\"".$_SESSION['niveau']."\"");
                        while($notice=$requestte->fetch()){
                            
                            // recuperation de l'id_matiere
                            $idMatiere=$notice['id_matiere'];
                            
                            // suppression de note pour cette matiere affecter a cet élève 
                            $affectNote=$pdo->query('DELETE FROM note WHERE id_ecole='."\"".$_SESSION['id_ecole']."\"".' AND id_eleve'."\"".$_SESSION['id_ecole']."\"".' AND id_matiere='."\"".$idMatiere."\"");
                        }
                    }
                    

                }
                
                ?>
                <script type="text/javascript">
                    alert("Coordonnées élèves mises à jour!"); 
                    window.location.href = "EnseignantPage.php"
                </script>
                <?php 
            }else{
                ?>
                <script type="text/javascript">
                    alert("Classe non existante!"); 
                    window.location.href = "EnseignantModifEleve.php"
                </script>
                <?php 
            }
        } 
    }
    if((strcmp($_POST['ModifEleve'],"Annuler")==0)){
        header('Location: EnseignantPage.php ');
        exit();
    }
    else{
        ?>
        <script type="text/javascript">
            alert("Vous devez remplir tout les champs!"); 
            window.location.href = "EnseignModifEleve.php"
        </script>
        <?php 
    }
}
?>