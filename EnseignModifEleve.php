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
                    <li class="active"><a href="#" class="scroll-link" data-id="slides" id="donnees"> <span class="linktext">Données Personnelles</span><span class="linktext" style="display:none">Données Personnelles</span> </a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="about" id="eleves"><span class="linktext">Gestion Des Eleves</span><span class="linktext" style="display:none">Gestion Des Eleves</span> </a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="capabilities" id="notes"><span class="linktext">Gestion Des Notes</span><span class="linktext" style="display:none">Gestion Des Notes</span></a></li>
                </ul>
            </div>
        </div>
    </nav>



                                            <!--Formulaire Gestion des Eleves-->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div id="affichEleve" style="display:block">
                    <aside class="leftEleve">
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
            $request=$pdo->query('SELECT * FROM eleve WHERE id_ecole='."\"".$idEcole."\"");
            // affichage de la table 
            echo "<table class=\"table table-success\" id=\"tableEnseign\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Eleve</th>
                            <th scope=\"col\">Prenom</th>
                            <th scope=\"col\">Nom</th>
                            <th scope=\"col\">Année Scolaire</th>
                            <th scope=\"col\">Mot De Passe</th>
                            </tr>
                    </thead>
                    <tbody> 
                ";
            while($entree=$request->fetch()){
                echo"<tr  class=\"success\">
                        <td>".$entree['id_eleve']."</td>
                        <td>".$entree['prenom']."</td>
                        <td>".$entree['nom']."</td>
                        <td>".$entree['anneescolaire']."</td>
                        <td>".$entree['mdp']."</td>
                    </tr>";
            }
            echo"</tbody></table>";

            echo "<br/><br/><br/>";
            // affichage de la liste des classes avec les niveaux
            $request=$pdo->query('SELECT * FROM classe WHERE id_ecole='."\"".$idEcole."\"");
            echo "<table class=\"table table-success\" id=\"tableEnseign\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Classe</th>
                            <th scope=\"col\">Classe</th>
                            <th scope=\"col\">Niveau</th>
                            <th scope=\"col\">Nombre d'élèves</th>
                            </tr>
                    </thead>
                    <tbody> 
                ";
            while($entree=$request->fetch()){
                echo"<tr class=\"success\">
                        <td>".$entree['id_classe']."</td>
                        <td>".$entree['nom']."</td>
                        <td>".$entree['niveau']."</td>
                        <td>".$entree['nb']."</td>
                    </tr>";
            }
            echo"</tbody></table>";
            $request->closeCursor();     
        ?>
                    </aside>
                </div>
            </div>
        <div class="col-md-6 col-sm-6">
            <div id="details1" style="display:block">
                <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded" action="EnseignGestionEleve.php">
                    <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
                    <div class="modifier">
                        <fieldset>
                            <legend>Gestion des eleves</legend>
                            <table>
                                <tr>
                                    <td><span class="label">Nom :</span></td>
                                    <td><input type="text" name="nom" id="nom" /></td>
                                </tr><br />
                                <tr>
                                    <td><span class="label">Prénom :</span></td>
                                    <td><input type="text" name="prenom" id="prenom" /></td>
                                </tr>
                                <tr>
                                    <td><span class="label">Année Scolaire :</span></td>
                                    <td><input type="text" name="anneescolaire" id="anneescolaire" /></td>
                                </tr>
                                <tr>
                                    <td><span class="label">Niveau: </span></td>
                                    <td><select name="niveau" id="niveau">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="label">Nom du Classe :</span></td> <!-- On peut afficher seulement les classe pour ce niveau !!! (select )-->
                                    <td><input type="text" name="classe" id="classe" /></td>
                                </tr>
                                <tr>
                                    <td><span class="label">Mot de passe :</span></td>
                                    <td><input type="password" name="mdp" id="mdp" /></td>
                                </tr>
                            </table><br />
                            <table>
                                <tr>
                                    <td>
                                        <div class="envoi3"><input type="submit" name="ModifEleve" value="Enregistrer"
                                                        class="btn btn-primary" id="btnsecondaire" /></div>
                                    </td>
                                    <td>
                                        <div class="envoi2"><input type="submit" name="ModifEleve" value="Annuler"
                                                class="btn btn-primary" id="btnsecondaire" /></div>
                                    </td>
                                </tr>

                            </table>
                        </fieldset>
                    </div>
                </form>      
            </div>
        </div>
        </div>
    </div>
</body>
</html>