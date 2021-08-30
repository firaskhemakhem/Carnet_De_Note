<?php
session_start();
?>
<!DOCTYPE html>
    <html>
    <!--DONNEES PERSONNELLES DES AMDINS-->

        <head>

            <title> Eleve Page </title>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/css/bootstrap.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="styleEleve.css" />
        </head>

        <body>
            <nav class="nav-bg navbar navbar-floating navbar-default" role="navigation" id="floating-nav">
                <div class="container navbar-default">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#hidden-nav">
                                    <span class="sr-only">Toggle navigation</span> 
                                    <span class="icon-bar"></span> 
                                    <span class="icon-bar"></span> 
                                    <span class="icon-bar"></span>
                                </button>-->
                        <a class="navbar-brand scroll-top" href="#"><span id="eleve">Eleves</span></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="hidden-nav">
                        <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php" class="scroll-link" data-id="clients" ><span>Accueil</span></a></li>
                            <li class="active"><a href="#" class="scroll-link" data-id="slides" id="expand"> <span
                                        class="linktext">Données Personnelles</span><span class="linktext"
                                        style="display:none">Données Personnelles</span> </a></li>
                            <li class="active"><a href="#" class="scroll-link" data-id="about" id="notes"><span
                                        class="linktext">Carnet De Notes</span><span class="linktext"
                                        style="display:none">Carnet De Notes</span> </a></li>
                            <!--JQUERY-->
                            <script>
                                $('a#expand').click(function () {
                                    $('div#details').slideToggle();
                                    $('div#affichNotes').hide();
                                    $('span.linktext').toggle();
                                });

                                $('a#notes').click(function () {
                                    $('div#affichNotes').slideToggle();
                                    $('div#details').hide();
                                    $('span.linktext').toggle();
                                });
                            

                                                    
                            </script>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>

                        <!--Formulaire données personnelles-->

            <div id="details" style="display:none">
                <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                    action="DonPersEleves.php">
                    <!-- -->
                    <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->

                    <div class="modifier">
                        <fieldset>
                            <legend>Vous pouvez changer vos informations personnelles</legend>
                            <table>
                                <tr>
                                    <td><span class="label">Nom :</span></td>
                                    <td><input type="text" name="nom" id="nom" /></td>
                                </tr><br />
                                <tr>
                                    <td><span class="label">Prenom :</span></td>
                                    <td><input type="text" name="prenom" id="prenom" /></td>
                                </tr>
                                <tr>
                                    <td><span class="label">Mot de passe :</span></td>
                                    <td><input type="password" name="mdp" id="mdp" /></td>
                                </tr>
                            </table><br />
                            <div class="envoi">
                                <input type="submit" name="envoi" value="Envoyer" class="btn btn-primary" id="btnsecondaire" />
                            </div>
                            <br/>
                        </fieldset>
                    </div>
                </form>
            </div>
            

                                                     <!--Affichage Carnet Des Notes-->
            
        <div id="affichNotes" style="display:none">
            <aside >
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

                    echo "
                    <h3>Votre carnet de note :</h3>
                    <table class=\"table table-success table table-bordered\" id=\"carnet\">
                            <thead>
                                <tr class=\"danger\">
                                    <th scope=\"col\">Matière</th>
                                    <th scope=\"col\">Note</th>
                                    </tr>
                            </thead>
                            <tbody> 
                        ";

                    // affichage de la liste des matieres avec les notes
                    $idEleve=$_SESSION['id_eleve'];
                    $requetx=$pdo->query('SELECT id_matiere,note FROM note WHERE id_eleve='."\"".$idEleve."\"".' AND id_ecole='."\"".$_SESSION['id_ecole']."\"");
                    while($lecture=$requetx->fetch()){
                        $idMatiere=$lecture['id_matiere'];
                        $note=$lecture['note'];
                        $request=$pdo->query('SELECT libelle FROM matiere WHERE id_matiere='."\"".$idMatiere."\"");
                        $retour=$request->fetch();
                        $Matiere=$retour['libelle'];
                        echo"<tr class=\"success\">
                                <td>".$Matiere."</td>
                                <td>".$note."</td>
                            </tr>";
                    }
                    
                    echo"</tbody></table>";
                    $request->closeCursor();     
                ?>
            </aside>
        </div>
 
        </body>

    </html>