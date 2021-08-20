<?php
session_start();
if((!empty($_POST['ModifMatiere']))){

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
    if(!empty($_POST['niveau'])&&!empty($_POST['libelle'])&& !empty($_POST['coefficient'])){
        // Enregistrement de la modification d'une classe
        if((strcmp($_POST['ModifMatiere'],"Enregistrer")==0)){

            $reponse = $pdo->prepare('UPDATE matiere SET niveau= :niveau, libelle= :libelle, coefficient= :coefficient WHERE id_matiere='."\"".$_SESSION['id_matiere']."\"");
            $reponse->execute(array('niveau' => $_POST['niveau'],'libelle' => $_POST['libelle'],'coefficient' => $_POST['coefficient']));
            header('Location: Administration.php ');
            exit();
            $reponse->closeCursor();
        }
    }
    if((strcmp($_POST['ModifMatiere'],"Annuler")==0)){
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