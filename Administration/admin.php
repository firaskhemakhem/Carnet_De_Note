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

        if (!empty($_POST['gouvernorat']) && !empty($_POST['delegation']) && !empty($_POST['nomEcole']) && !empty($_POST['genre']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])) {
            
            
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
                // Recuperation de l'id_ecole
                $reponse = $pdo->prepare('SELECT id_ecole FROM ecole WHERE gouvernorat= :gouvernorat AND delegation= :delegation AND libelle= :nomEcole');
                $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'], 'delegation' => $_POST['delegation'], 'nomEcole' => $_POST['nomEcole']));
                $entre = $reponse->fetch();
                $idEcole = $entre['id_ecole'];
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

                // envoi du mot de passe par mail 
                $destinataire = $_POST['email'];
                // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
                $expediteur = 'med@ministeres.tn';
                $copie = 'med@ministeres.tn';
                $copie_cachee = 'med@ministeres.tn';
                $objet = 'Code Inscription'; // Objet du message
                $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
                $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
                $headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
                $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
                $headers .= 'Cc: '.$copie."\n"; // Copie Cc
                $headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
                $message = 'Vous êtes maintenant inscrit à la plateforme de votre école. Ceci est votre mot de passe :'. $mdpadmin;
                if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
                {
                    echo 'Votre message a bien été envoyé ';
                }
                else // Non envoyé
                {
                    echo "Votre message n'a pas pu être envoyé";
                }
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

            $reponse = $pdo->prepare('SELECT Email, Mdp,id_admin FROM administration WHERE Email = :email AND Mdp = :mdp');
            $requete = $reponse->execute(array('email' => $_POST['emailAdmin'], 'mdp' => $_POST['mdpAdmin']));
            $entree = $reponse->fetch();

             //s'il est existant
            if ($entree) {
                $idAdmin=$entree['id_admin'];
                $_SESSION["emailAdmin"] = $_POST["emailAdmin"];
                $_SESSION["mdpAdmin"] = $_POST["mdpAdmin"];
                // recuperation de l'id ecole 
                $reponse = $pdo->prepare('SELECT id_ecole FROM administration WHERE id_admin='."\"".$idAdmin."\"");
                $reponse->execute(array('gouvernorat' => $_POST['gouvernorat'], 'delegation' => $_POST['delegation'], 'nomEcole' => $_POST['nomEcole']));
                $entreeee = $reponse->fetch();
                $idEcole = $entreeee['id_ecole'];
                $_SESSION["id_ecole"]=$idEcole;
                header('Location: administration.php');
                exit();
            } else {
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
                window.location.href = "index.php"
            </script>
            <?php 
        }
    }
}


?>