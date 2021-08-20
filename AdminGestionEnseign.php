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