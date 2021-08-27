<?php
session_start();

if((!empty($_POST['select']))){

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
    if(!empty($_POST['id'])&&!empty($_POST['classe'])&&!empty($_POST['niveau'])){
        $request=$pdo->prepare('SELECT id_classe FROM classe WHERE id_classe= :id');
        $request->execute(array('id' => $_POST['id']));
        $test=$request->fetch();
        if($test){
            $_SESSION['id_classe']=$test['id_classe'];
            $_SESSION['niveau']=$_POST['niveau'];
            $_SESSION['classe']=$_POST['classe'];
            header('Location: CarnetDeNote.php');
            exit();
        }
        else{
            ?>
            <script type="text/javascript">
                alert("classe non existante !");
                window.location.href = "EnseignantPage.php";
            </script>
            <?php
        }
    }
}
?>