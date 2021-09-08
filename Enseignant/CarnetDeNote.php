<?php 
session_start();
?>
<!DOCTYPE html>
<html>
                                <!--DONNEES PERSONNELLES DES ENSEIGNANTS-->
<head>

    <title> Carnet de notes</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="enseignant.css">

</head>

<body>

    <nav class="nav-bg navbar navbar-floating navbar-default" role="navigation" id="floating-nav">
        <div class="container navbar-default">
            <div class="navbar-header">
                <a class="navbar-brand scroll-top" href="#"><span id="enseignant">Enseignants</span></a>
            </div>

            <div class="collapse navbar-collapse" id="hidden-nav">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="../index.php" class="scroll-link" data-id="clients" ><span>Accueil</span></a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="slides" id="donnees"> <span class="linktext">Données Personnelles</span><span class="linktext" style="display:none">Données Personnelles</span> </a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="about" id="eleves"><span class="linktext">Gestion Des Eleves</span><span class="linktext" style="display:none">Gestion Des Eleves</span> </a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="capabilities" id="notes"><span class="linktext">Gestion Des Notes</span><span class="linktext" style="display:none">Gestion Des Notes</span></a></li>

                                            

                    </script>
                </ul>
            </div>
        </div>
    </nav>

    
                                            <!--Carnet de Notes-->

    <div id="affichCarnet" style="display:block">
        <form id="monForm" name="form_connect" method="POST" enctype="application/x-www-form-urlencoded" action="GestionNote.php">
            <fieldset>
                    <h2><?php echo $_SESSION['classe'] ;?></h2>
            <?php 
                // connection a la base de donneé
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
                //$i=1;
                //echo "<input type=\"text\" name=$i id=$i value=$i />";
                echo "<table class=\"table table-success table table-bordered\" id=\"tableEnseign\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Élève</th>
                            <th scope=\"col\">Nom et Prénom </th>";
                
                $idEcole=$_SESSION['id_ecole'];
                $test=$pdo->query('SELECT id_matiere FROM affectation WHERE id_ecole='."\"".$idEcole."\"".'AND id_enseignant='."\"".$_SESSION['id_enseignant']."\"".' AND id_classe='."\"".$_SESSION['id_classe']."\"");
                while($retour=$test->fetch()){
                    // affichage des matières
                    $requestte=$pdo->query('SELECT libelle FROM matiere WHERE id_matiere='."\"".$retour['id_matiere']."\"");
                    $select=$requestte->fetch();
                    echo "<th scope=\"col\">".$select['libelle']."</th>";
                }
                echo "</tr>
                </thead>
                <tbody> 
                ";

                $request=$pdo->query('SELECT * FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$_SESSION['id_classe']."\"");
                $i=1;
                while($lecture=$request->fetch()){
                    $idEleve=$lecture['id_eleve'];

                    $test=$pdo->query('SELECT id_matiere FROM affectation WHERE id_ecole='."\"".$idEcole."\"".'AND id_enseignant='."\"".$_SESSION['id_enseignant']."\"".' AND id_classe='."\"".$_SESSION['id_classe']."\"");
                    
                    echo"<tr class=\"success\">
                            <td>".$idEleve."</td>
                            <td>".$lecture['nom']." ".$lecture['prenom']."</td>";
                    while($retour=$test->fetch()){
                        $j=1;
                        $requestte=$pdo->query('SELECT libelle FROM matiere WHERE id_matiere='."\"".$retour['id_matiere']."\"");
                        $notice=$requestte->fetch();
                        $NomMatiere=$notice['libelle'];
                        $idMatiere=$retour['id_matiere'];
                        $getNote=$pdo->query('SELECT note FROM note WHERE id_ecole='."\"".$idEcole."\"".'AND id_matiere='."\"".$idMatiere."\"".'AND id_eleve='."\"".$idEleve."\"");
                        $notefetch=$getNote->fetch();
                        $note=$notefetch['note'];
                        if($note == NULL ){
                            $note="00.00";
                        }
                        $nameinput=$NomMatiere."|".$idEleve;


                            echo "<td><input type=\"text\" name=$nameinput id=$nameinput value=$note /></td>";
                            
                    }
                    echo "</tr>";
                }
                echo"</tbody></table>";
                $request->closeCursor(); 
                echo "<table>
                <tr>
                    <td><div class=\"envoi4\"><input type=\"submit\" name=\"ModifNote\" value=\"Enregistrer\" class=\"btn btn-primary\" id=\"btnsecondaire\" onclick=\"javascript:validationHorsBon();\"/></div></td>
                    <td><div classe=\"envoi5\"><input type=\"submit\" name=\"ModifNote\" value=\"Annuler\" class=\"btn btn-primary\" id=\"btnsecondaire\" onclick=\"javascript:validationHorsBon();\"></div></td>
                </tr>
            </table>  "  ;

           
            
        ?>
            </div>
    </form>
</div>

</body>
</html>