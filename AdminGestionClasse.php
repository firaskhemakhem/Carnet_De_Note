<?php
session_start();

if((!empty($_POST['ModifClasse']))){

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
    if(!empty($_POST['niveau'])&&!empty($_POST['nom'])&& !empty($_POST['nb'])){
        // Enregistrement de la modification d'une classe
        if((strcmp($_POST['ModifClasse'],"Enregistrer")==0)){

            $reponse = $pdo->prepare('UPDATE classe SET niveau= :niveau, nom= :nom, nb= :nb WHERE id_classe='."\"".$_SESSION['id_classe']."\"");
            $reponse->execute(array('niveau' => $_POST['niveau'],'nom' => $_POST['nom'],'nb' => $_POST['nb']));
            header('Location: Administration.php ');
            exit();
            $reponse->closeCursor();
        }
    }
    if((strcmp($_POST['ModifClasse'],"Annuler")==0)){
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

?>