<?php
session_start();

if ((!empty($_POST['envoi']))) {

    $hostName = "localhost";
    $dbName = "carnetdenote";
    $userName = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$hostName;dbname=$dbName", $userName, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    //Inscription d'un administrateur
    if ((strcmp($_POST['envoi'], "Envoyer") == 0)) {

        if (!empty($_POST['gouvernorat']) && !empty($_POST['delegation']) && !empty($_POST['nomEcole']) && !empty($_POST['genre']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
            // Recuperation de l'id_ecole
            $reponse = $pdo->prepare('SELECT id_ecole FROM ecole WHERE gouvernorat= :gouvernorat AND delegation= :delegation AND libelle= :nomEcole');
            $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'], 'delegation' => $_POST['delegation'], 'nomEcole' => $_POST['nomEcole']));
            $entree = $reponse->fetch();
            $idEcole = $entree['id_ecole'];

             // verifier le non existance d'un administrateur pour cette ecole
            $request=$pdo->query('SELECT id_admin FROM administration WHERE id_ecole='."\"".$idEcole."\"");
            $entree=$request->fetch();
            if($entree){
                ?>
                <script type="text/javascript">
                    alert("Administrateur déjà existant pour cette école!"); 
                    window.location.href = "index.php"
                </script>
                <?php 
            }
            else{
                // Creation de l'école 
                $requete = $pdo->prepare('INSERT INTO ecole(gouvernorat,delegation,libelle) VALUES (:gouvernorat,:delegation,:nomEcole)');
                $requete->execute(array('gouvernorat' => $_POST['gouvernorat'], 'delegation' => $_POST['delegation'], 'nomEcole' => $_POST['nomEcole']));

                // affectation de mot de passe 
                $reponse = $pdo->query('SELECT mdp FROM code WHERE used="non"');
                $entree = $reponse->fetch();
                $mdp = $entree['mdp'];
                $mdpadmin = substr($entree['mdp'], 0, strlen($entree['mdp']) - 1);

                // creaction de l'Administrateur
                $requete = $pdo->prepare('INSERT INTO administration(id_ecole,genre,prenom,nom,email,mdp,type) VALUES (' . "\"" . $idEcole . "\"" . ',:genre,:prenom, :nom,:email,' . "\"" . $mdpadmin . "\"" . ',6)');
                $requete->execute(array('genre' => $_POST['genre'], 'nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'email' => $_POST['email']));

                // Affirmer que ce mot de passe est utilisé 
                $entree = $pdo->query('UPDATE code SET used = "oui" WHERE mdp=' . "\"" . $mdp . "\"");

                ?>
                <script type="text/javascript">
                    alert("Vous êtes maintenant inscrit, vous pouvez vous connecter!"); //matekhdemch
                    window.location.href = "index.php"
                </script>
                <?php 

            }
            
        } else {
            ?>
            <script type="text/javascript">
                alert("Vous devez remplir tout les champs!"); 
                window.location.href = "index.php"
            </script>
            <?php 
        }
    } else {

        //connexion d'un administrateur
        if (!empty($_POST['emailAdmin']) && !empty($_POST['mdpAdmin'])) {

            $reponse = $pdo->prepare('SELECT Email, Mdp FROM administration WHERE Email = :email AND Mdp = :mdp');
            $requete = $reponse->execute(array('email' => $_POST['emailAdmin'], 'mdp' => $_POST['mdpAdmin']));
            $entree = $reponse->fetch();

             //s'il est existant
            if ($entree) {
               $_SESSION["emailAdmin"] = $_POST["emailAdmin"];
               $_SESSION["mdpAdmin"] = $_POST["mdpAdmin"];
               header('Location: administration.php');
               exit();
            } else {
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