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
                    <li class="active"><a href="index.php" class="scroll-link" data-id="clients" ><span>Accueil</span></a></li>
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
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded" action="GestionNote.php">
            <fieldset>
                    <legend><?php echo $_SESSION['classe'] ;?></legend>
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
                $reponse = $pdo->query('SELECT id_ecole FROM enseignant WHERE login='."\"".$_SESSION['loginEnseing']."\"".' AND mdp='."\"".$_SESSION['mdpEnseing']."\"");
                $entree=$reponse->fetch();
                $idEcole=$entree['id_ecole'];  

                echo "<table class=\"table table-success\" id=\"tableEnseign\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Eleve</th>
                            <th scope=\"col\">Nom et Prenom </th>";

                $requestte=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"".' AND niveau='."\"".$_SESSION['niveau']."\"");
                while($select=$requestte->fetch()){
                    // affichage des matières
                    
                    echo "<th scope=\"col\">".$select['libelle']."</th>";
                }
                echo "</tr>
                </thead>
                <tbody> 
                ";

                $request=$pdo->query('SELECT * FROM eleve WHERE id_ecole='."\"".$idEcole."\"".' AND id_classe='."\"".$_SESSION['id_classe']."\"");
                while($lecture=$request->fetch()){
                    $idEleve=$lecture['id_eleve'];
                    $requestte=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"".' AND niveau='."\"".$_SESSION['niveau']."\"");
                    echo"<tr class=\"success\">
                            <td>".$idEleve."</td>
                            <td>".$lecture['nom']." ".$lecture['prenom']."</td>";
                    while($notice=$requestte->fetch()){
                        $NomMatiere=$notice['libelle'];
                        $idMatiere=$notice['id_matiere'];
                        $getNote=$pdo->query('SELECT note FROM note WHERE id_ecole='."\"".$idEcole."\"".'AND id_matiere='."\"".$idMatiere."\"".'AND id_eleve='."\"".$idEleve."\"");
                        $notefetch=$getNote->fetch();
                        $note=$notefetch['note'];
                        if($note == NULL ){
                            $note="00.00";
                        }
                        $nameinput=$NomMatiere."|".$idEleve;
                            
                            echo "<td><input type=\"text\" name=$nameinput id=$nameinput value=$note /></td>";
                            /*echo "<td>".$note."</td>";*/
                    }
                    echo "</tr>";
                }
                echo"</tbody></table>";
                $request->closeCursor(); 
                echo "<table>
                <tr>
                    <td><div class=\"envoi\"><input type=\"submit\" name=\"ModifNote\" value=\"Enregistrer\" class=\"btn btn-primary\" id=\"btnsecondaire\"/></div></td>
                    <td><div classe=\"envoi1\"><input type=\"submit\" name=\"ModifNote\" value=\"Annuler\" class=\"btn btn-primary\" id=\"btnsecondaire\"></div></td>
                </tr>
            </table>  "    
        ?>
            </div>
    </form>
</div>
    

<script type="text/javascript">

        function suivant_connect(enCours, suivant, event) {
            // Compatibilité IE / Firefox
            if (!event && window.event) {
                event = window.event;
            }
            keycode = event.which;
            if (window.event) {
                keycode = window.event.keyCode;
            }
            if (keycode == 13) {
                document.formulaire[suivant].focus();
            }
        }
        function final_touch(event) {
            var keycode;
            keycode = event.which;
            if (window.event) {
                keycode = window.event.keyCode;
            }
            if (keycode == 13) {
                validationHorsBon();
            }
        }
        function validationHorsBon() {
            alert('this form is submitted !:');
            document.forms["horsBon"].submit();
        }

    </script>

</body>
</html>