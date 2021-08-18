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
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    if ((strcmp($_POST['envoi'], "Envoyer") == 0)) {

        if (!empty($_POST['gouvernorat']) && !empty($_POST['delegation']) && !empty($_POST['nomEcole']) && !empty($_POST['genre']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {

            // verifier le non existance d'un administrateur pour cette ecole
            // cette condition doit être verifié 

            // Creation de l'école 
            $requete = $pdo->prepare('INSERT INTO ecole(gouvernorat,delegation,libelle) VALUES (:gouvernorat,:delegation,:nomEcole)');
            $requete->execute(array('gouvernorat' => $_POST['gouvernorat'], 'delegation' => $_POST['delegation'], 'nomEcole' => $_POST['nomEcole']));

            // Recuperation de l'id_ecole
            $reponse = $pdo->prepare('SELECT id_ecole FROM ecole WHERE gouvernorat= :gouvernorat AND delegation= :delegation AND libelle= :nomEcole');
            $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'], 'delegation' => $_POST['delegation'], 'nomEcole' => $_POST['nomEcole']));
            $entree = $reponse->fetch();
            $idEcole = $entree['id_ecole'];

            // affectation de mot de passe 
            $reponse = $pdo->query('SELECT mdp FROM code WHERE used="non"');
            $entree = $reponse->fetch();
            $mdp = $entree['mdp'];
            $mdpadmin = substr($entree['mdp'], 0, strlen($entree['mdp']) - 1);

            // creaction de l'Administrateur
            $requete = $pdo->prepare('INSERT INTO administation(id_ecole,genre,prenom,nom,email,mdp,type) VALUES (' . "\"" . $idEcole . "\"" . ',:genre,:prenom, :nom,:email,' . "\"" . $mdpadmin . "\"" . ',6)');
            $requete->execute(array('genre' => $_POST['genre'], 'nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'email' => $_POST['email']));

            // Affirmer que ce mot de passe est utilisé 
            $entree = $pdo->query('UPDATE code SET used = "oui" WHERE mdp=' . "\"" . $mdp . "\"");

            // Redirection vers la page d'acceuil
            header('Location: index.html ');
            /*?>
            <script type="text/javascript">
                alert("Vous êtes maintenant inscrit, connectez-vous!"); //matekhdemch
            </script>
            <?php */
            exit();
        } else {
            echo "vous devez remplir tous les champs!";
        }
    } else {

        if (!empty($_POST['emailAdmin']) && !empty($_POST['mdpAdmin'])) {


            $reponse = $pdo->prepare('SELECT Email, Mdp FROM administation WHERE Email = :email AND Mdp = :mdp');
            $requete = $reponse->execute(array('email' => $_POST['emailAdmin'], 'mdp' => $_POST['mdpAdmin']));
            $entree = $reponse->fetch();

            if ((strcmp($entree['Email'], 0) == 1) && (strcmp($entree['Mdp'], 0) == 1)) { //s'il est existant
                $_SESSION["emailAdmin"] = $_POST["emailAdmin"];
                $_SESSION["mdpAdmin"] = $_POST["mdpAdmin"];
                header('Location: administration.php');
                exit();
            } else {
                //   header('Location: FormulaireAdmin.html');
?>
                <script type="text/javascript">
                    alert("Vous n'êtes pas inscrits !");
                </script>
<?php
                exit();
            }
            $reponse->closeCursor();
        }
    }
}


?>