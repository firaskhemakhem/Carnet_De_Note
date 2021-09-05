<?php
session_start();

if(!empty($_POST['ModifEnseign'])){
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
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&& !empty($_POST['genre']) && !empty($_POST['login'])&&!empty($_POST['email'])&&!empty($_POST['mdp'])){
        // Enregistrement de la modification d'un enseignant
        if((strcmp($_POST['ModifEnseign'],"Enregistrer")==0)){

            $reponse = $pdo->prepare('UPDATE enseignant SET nom= :nom, prenom= :prenom, genre= :genre, login= :login, email= :email, mdp= :mdp WHERE id_enseignant='."\"".$_SESSION['id_enseignat']."\"");
            $reponse->execute(array('genre' => $_POST['genre'],'prenom' => $_POST['prenom'],'nom' => $_POST['nom'],'login' => $_POST['login'],'email' => $_POST['email'],'mdp' => $_POST['mdp']));
            if(strcmp($_SESSION['login'],$_POST['login'])!=0 && strcmp($_SESSION['mdp'],$_POST['mdp'])!=0){
                // envoi du mot de passe par mail 
                $destinataire = $_POST['email'];
                // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
                $expediteur = $_SESSION["emailAdmin"];
                $copie = $_SESSION["emailAdmin"];
                $copie_cachee = $_SESSION["emailAdmin"];
                $objet = 'Code Inscription'; // Objet du message
                $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
                $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
                $headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
                $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
                $headers .= 'Cc: '.$copie."\n"; // Copie Cc
                $headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
                $message = 'Vos coordonnées sont mises à jour. Ceci est votre nouveau mot de passe :'.$_POST['mdp'].', du login :'.$_POST['login'];
                if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
                {
                    echo 'Votre message a bien été envoyé ';
                }
                else // Non envoyé
                {
                    echo "Votre message n'a pas pu être envoyé";
                }
            }
            header('Location: Administration.php ');
            exit();
            $reponse->closeCursor();
        }
        
    }
    if((strcmp($_POST['ModifEnseign'],"Annuler")==0)){
        header('Location: Administration.php ');
        exit();
    }
    else{
?>
        <script type="text/javascript">
            alert(" Vous devez remplir tout les champs !");
        </script>
<?php
    }
}
else{
    echo "no connection !";
}

?>