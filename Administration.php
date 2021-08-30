<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<!--DONNEES PERSONNELLES DES AMDINS-->

<head>

    <title> Carnet de notes</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styleAdmin.css" />

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
                <a class="navbar-brand scroll-top" href="#"><span id="admin">Administrations</span></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="hidden-nav">
                <ul class="nav navbar-nav">
                <li class="active"><a href="index.php" class="scroll-link" data-id="clients" ><span>Accueil</span></a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="slides" id="expand"> <span
                                class="linktext">Données Personnelles</span><span class="linktext"
                                style="display:none">Données Personnelles</span> </a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="about" id="enseignants"><span
                                class="linktext">Gestion Des Enseignants</span><span class="linktext"
                                style="display:none">Gestion Des Enseignants</span> </a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="capabilities" id="classe"><span
                                class="linktext">Gestion Des Classes</span><span class="linktext"
                                style="display:none">Gestion Des Classes</span></a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="projects" id="matiere"><span
                                class="linktext">Gestion Des Matières</span><span class="linktext"
                                style="display:none">Gestion Des Matières</span></a></li>
                    <li class="active"><a href="#" class="scroll-link" data-id="clients" id="Affectation"><span
                                class="linktext">Affectation Des Enseignants</span><span class="linktext"
                                style="display:none">Affectation Des Enseignants</span></a></li>
                    <!-- <button type="button" class="btn btn-warning" ><a href="index.php" class="styleAccueil">Acceuil</a></button>-->
                    <!--JQUERY-->
                    <script>
                        $('a#expand').click(function () {
                            $('div#details').slideToggle();
                            $('div#detailsper').hide();
                            $('div#affichEnseign').hide();
                            $('div#affichClasse').hide();
                            $('div#affichMatiere').hide();
                            $('div#detailsclass').hide();
                            $('div#detailsmat').hide();
                            $('div#affectation').hide();
                            $('div#affectationEnseign').hide();
                            //$('div#detailsnew').hide();
                            $('span.linktext').toggle();
                        });

                        $('a#enseignants').click(function () {
                            $('div#detailsper').slideToggle();
                            $('div#affichEnseign').slideToggle();
                            $('div#affichClasse').hide();
                            $('div#affichMatiere').hide();
                            $('div#details').hide();
                            $('div#detailsclass').hide();
                            $('div#detailsmat').hide();
                            $('div#affectation').hide();
                            $('div#affectationEnseign').hide();
                            //$('div#detailsnew').hide();
                            $('span.linktext').toggle();
                        });
                        /*$('a#enseignants').click(function () {
                            $('div#affichEnseign').slideToggle();
                            $('div#details').hide();
                            $('div#detailsper').hide();
                            $('div#detailsclass').hide();
                            $('span.linktext').toggle();
                        });*/

                        $('a#classe').click(function () {
                            $('div#detailsclass').slideToggle();
                            $('div#affichClasse').slideToggle();
                            $('div#details').hide();
                            $('div#detailsper').hide();
                            $('div#affichEnseign').hide();
                            $('div#affichMatiere').hide();
                            $('div#detailsmat').hide();
                            $('div#affectation').hide();
                            $('div#affectationEnseign').hide();
                            //$('div#detailsnew').hide();
                            $('span.linktext').toggle();
                        });
                        $('a#matiere').click(function () {
                            $('div#detailsmat').slideToggle();
                            $('div#affichMatiere').slideToggle();
                            $('div#details').hide();
                            $('div#detailsper').hide();
                            $('div#affichEnseign').hide();
                            $('div#affichClasse').hide();
                            $('div#detailsclass').hide();
                            $('div#affectation').hide();
                            $('div#affectationEnseign').hide();
                            //$('div#detailsnew').hide();
                            $('span.linktext').toggle();
                        });
                        $('a#Affectation').click(function () {
                            $('div#affectation').slideToggle();
                            $('div#affectationEnseign').slideToggle();
                            $('div#details').hide();
                            $('div#detailsper').hide();
                            $('div#detailsmat').hide();
                            $('div#affichMatiere').hide();
                            $('div#affichEnseign').hide();
                            $('div#affichClasse').hide();
                            $('div#detailsclass').hide();
                            //$('div#detailsnew').hide();
                            $('span.linktext').toggle();
                        });
                       

                                               
                    </script>
                    <!--<li><a href="#" class="scroll-link" data-id="contact">Contact</a></li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
        
    </nav>

    <!--Formulaire données personnelles-->

    <div id="details" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="DonPersAdmin.php">
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
                            <td><span class="label">Email :</span></td>
                            <td><input type="text" name="email" id="email" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Mot de passe :</span></td>
                            <td><input type="password" name="mdp" id="mdp" /></td>
                        </tr>
                    </table><br />
                    <div class="envoi"><input type="submit" name="envoi" value="Envoyer" class="btn btn-primary"
                            id="btnsecondaire" /></div><br />
                </fieldset>
            </div>
        </form>
    </div>

    <!--Formulaire Gestion des Enseignants-->

    <!-- choix de manipulation -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div id="affichEnseign" style="display:none">
                    <aside class="leftEnseign">
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
            $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];  
            $request=$pdo->query('SELECT * FROM enseignant WHERE id_ecole='."\"".$idEcole."\"");
            // affichage de la table 
            echo "
            <h3>Liste des enseignants :</h3>
            <table class=\"table table-success\" id=\"tableEnseign\">
                    <thead>
                        <tr class=\"success\">
                            <th scope=\"col\">Id_Enseignant</th>
                            <th scope=\"col\">Prenom</th>
                            <th scope=\"col\">Nom</th>
                            <th scope=\"col\">Genre</th>
                            <th scope=\"col\">Email</th>
                            <th scope=\"col\">Login</th>
                            <th scope=\"col\">Mot De Passe</th>
                            </tr>
                    </thead>
                    <tbody> 
                ";
            while($entree=$request->fetch()){
                echo"<tr class=\"success\">
                        <td>".$entree['id_enseignant']."</td>
                        <td>".$entree['prenom']."</td>
                        <td>".$entree['nom']."</td>
                        <td>".$entree['genre']."</td>
                        <td>".$entree['email']."</td>
                        <td>".$entree['login']."</td>
                        <td>".$entree['mdp']."</td>
                    </tr>";
            }
            echo"</tbody></table>";
            $request->closeCursor();     
        ?>
                    </aside>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div id="detailsper" style="display:none">
                    <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                        action="GestionEnseig.php">
                        <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
                        <div class="modifier" id="modifierEnseign">
                            <fieldset>
                                <legend>Gestion des enseignants </legend>
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
                                        <td><span class="label">Genre: </span></td>
                                        <td><select name="genre" id="genre">
                                                <option value="Homme">Homme</option>
                                                <option value="Femme">Femme</option>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Login :</span></td>
                                        <td><input type="text" name="login" id="login" /></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Email :</span></td>
                                        <td><input type="text" name="email" id="email" /></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Mot de passe :</span></td>
                                        <td><input type="password" name="mdp" id="mdp" /></td>
                                    </tr>
                                </table><br />
                                <table>
                                    <tr>
                                        <td>
                                            <div class="envoi3"><input type="submit" name="manipuler" value="Ajouter"
                                                    class="btn btn-primary" id="btnsecondaire" /></div>
                                        </td>
                                        <td>
                                            <div class="envoi2"><input type="submit" name="manipuler" value="Modifier"
                                                    class="btn btn-primary" id="btnsecondaireModif" /></div>
                                        </td>
                                        <td>
                                            <div class="envoi0"><input type="submit" name="manipuler" value="Supprimer"
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



    <!-- Affichage de la liste des enseignants -->


    <!--Nouvelles données enseignants-->
    <!-- Ce formulaire doit être traité dans une nouvelle page ! -->
    <?php /*
    <div id="detailsnew" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="GestionEnseig.php">
            <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
            <div class="modifier">
                <fieldset>
                    <legend>Entrer les nouvelles données :</legend>
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
                            <td><span class="label">Genre: </span></td>
                            <td><select name="genre" id="genre">
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="label">Login :</span></td>
                            <td><input type="text" name="login" id="login" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Email :</span></td>
                            <td><input type="text" name="email" id="email" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Mot de passe :</span></td>
                            <td><input type="password" name="mdp" id="mdp" /></td>
                        </tr>
                    </table><br />
                    
                    <div class="envoi3"><input type="submit" name="ModifEnseign" value="Enregistrer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            
                </fieldset>
            </div>
        </form>
    </div>
    */
    ?>

    <!--<div id="details135" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="GestionEnseig.php">
    -->
    <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
    <!--
            <div class="modifier">
                <h3>Ajoutez des Enseignants</h3>
                <fieldset>
                    <table>
                        <tr>
                            <td>Nom :</td>
                            <td><input type="text" name="nom" id="nom" /></td>
                        </tr><br />
                        <tr>
                            <td>Prénom :</td>
                            <td><input type="text" name="prenom" id="prenom" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Genre: </span></td>
                            <td><select name="genre" id="genre">
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                            </td>
                        </tr>
                        <tr>
                            <td>Login :</td>
                            <td><input type="text" name="login" id="login" /></td>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <td><input type="text" name="email" id="email" /></td>
                        </tr>
                        <tr>
                            <td>Mot de passe :</td>
                            <td><input type="password" name="mdp" id="mdp" /></td>
                        </tr>
                    </table><br />
                    <div class="envoi"><input type="submit" name="envoi" value="Envoyer" /></div><br />
                </fieldset>
            </div>
        </form>
    </div>-->

    <!--Formulaire Gestion des Classes-->
                                                   <!--*****************************************-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div id="affichClasse" style="display:none">
                    <aside class="leftClasse">
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
            $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];   
            $request=$pdo->query('SELECT * FROM classe WHERE id_ecole='."\"".$idEcole."\"");
            // affichage de la table 
            echo "
            <h3>Liste des classes :</h3>
            <table class=\"table table-success\" id=\"tableClasse\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Classe</th>
                            <th scope=\"col\">Niveau</th>
                            <th scope=\"col\">Nom</th>
                            <th scope=\"col\">Nombre d'élèves</th>
                            </tr>
                    </thead>
                    <tbody> 
                ";
            while($entree=$request->fetch()){
                echo"<tr class=\"success\">
                        <td>".$entree['id_classe']."</td>
                        <td>".$entree['niveau']."</td>
                        <td>".$entree['nom']."</td>
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

            <div id="detailsclass" style="display:none">
                <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                    action="GestionClasse.php">
                    <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->

                    <div class="modifier">
                        <fieldset>
                            <legend>Ajoutez des Classes</legend>
                            <table>
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
                                <td><span class="label">Nom :</span></td>
                                <td><input type="text" name="nom" id="nom" /></td>
                                </tr>
                                <tr>
                                    <td><span class="label">Nombre d'élèves :</span></td>
                                    <td><input type="text" name="nb" id="nb" /></td>
                                </tr>
                            </table><br />
                            <table>
                                <tr>
                                    <td>
                                        <div class="envoi3"><input type="submit" name="manipuler" value="Ajouter"
                                                class="btn btn-primary" id="btnsecondaire" /></div>
                                    </td>
                                    <td>
                                        <div class="envoi2"><input type="submit" name="manipuler" value="Modifier"
                                                class="btn btn-primary" id="btnsecondaire" /></div>
                                    </td>
                                    <td>
                                        <div class="envoi0"><input type="submit" name="manipuler" value="Supprimer"
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
<!--Nouvelles données Classe-->
    <!-- Ce formulaire doit être traité dans une nouvelle page ! -->
    <?php /*
    <div id="detailsnew" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="GestionClasse.php">
            <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
            <div class="modifier">
                <fieldset>
                    <legend>Entrer les nouvelles données :</legend>
                    <table>
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
                                <td><span class="label">Nom :</span></td>
                                <td><input type="text" name="nom" id="nom" /></td>
                                </tr>
                                <tr>
                                    <td><span class="label">Nombre d'élèves :</span></td>
                                    <td><input type="text" name="nb" id="nb" /></td>
                                </tr>
                            </table><br/>
                    
                    <div class="envoi3"><input type="submit" name="ModifClasse" value="Enregistrer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            
                </fieldset>
            </div>
        </form>
    </div>
    */
    ?>


    <!--Formulaire Gestion des Matiéres-->       <!--*****************************************-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div id="affichMatiere" style="display:none">
                    <aside class="leftMatiere">
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
            $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole']; 
            $request=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"");
            // affichage de la table 
            echo "
            <h3>Liste des matières :</h3>
            <table class=\"table table-success\" id=\"tableMatiere\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Matiere</th>
                            <th scope=\"col\">Niveau</th>
                            <th scope=\"col\">Libellé</th>
                            <th scope=\"col\">Coefficient</th>
                            </tr>
                    </thead>
                    <tbody> 
                ";
            while($entree=$request->fetch()){
                echo"<tr class=\"success\">
                        <td>".$entree['id_matiere']."</td>
                        <td>".$entree['niveau']."</td>
                        <td>".$entree['libelle']."</td>
                        <td>".$entree['coefficient']."</td>
                    </tr>";
            }
            echo"</tbody></table>";
            $request->closeCursor();     
        ?>
                    </aside>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div id="detailsmat" style="display:none">
                    <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                        action="GestionMatiere.php">
                        <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->

                        <div class="modifier">
                            <fieldset>
                                <legend>Ajoutez des Matières</legend>
                                <table>
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
                                        <td><span class="label">libelle :</span></td>
                                        <td><input type="text" name="libelle" id="libelle" /></td>
                                    </tr><br />
                                    <tr>
                                        <td><span class="label">Coefficient :</span></td>
                                        <td><input type="text" name="coefficient" id="coefficient" /></td>
                                    </tr>
                                </table><br />
                                <table>
                                    <tr>
                                        <td>
                                            <div class="envoi3"><input type="submit" name="manipuler" value="Ajouter"
                                                    class="btn btn-primary" id="btnsecondaire" /></div>
                                        </td>
                                        <td>
                                            <div class="envoi2"><input type="submit" name="manipuler" value="Modifier"
                                                    class="btn btn-primary" id="btnsecondaire" /></div>
                                        </td>
                                        <td>
                                            <div class="envoi0"><input type="submit" name="manipuler" value="Supprimer"
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

    <!--Nouvelles données Matiere-->
    <!-- Ce formulaire doit être traité dans une nouvelle page ! -->
    <?php /*
    <div id="detailsnew" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="GestionMatiere.php">
            <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
            <div class="modifier">
                <fieldset>
                    <legend>Entrer les nouvelles données :</legend>
                    <table>
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
                                        <td><span class="label">libelle :</span></td>
                                        <td><input type="text" name="libelle" id="libelle" /></td>
                                    </tr><br />
                                    <tr>
                                        <td><span class="label">Coefficient :</span></td>
                                        <td><input type="text" name="coefficient" id="coefficient" /></td>
                                    </tr>
                    </table><br />
                    
                    <div class="envoi3"><input type="submit" name="ModifMatiere" value="Enregistrer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            
                </fieldset>
            </div>
        </form>
    </div>
    */
    ?>

<div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div id="affectation" style="display:none">
                    <aside class="leftEnseign">
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
            $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];  
            $request=$pdo->query('SELECT * FROM enseignant WHERE id_ecole='."\"".$idEcole."\"");
            // affichage de la table enseignants
            echo "
            <h3>Liste des enseignants :</h3>
            <table class=\"table table-success\" id=\"tableEnseign\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Enseignant</th>
                            <th scope=\"col\">Prenom</th>
                            <th scope=\"col\">Nom</th>
                            <th scope=\"col\">Genre</th>
                            <th scope=\"col\">Email</th>
                            <th scope=\"col\">Login</th>
                            <th scope=\"col\">Mot De Passe</th>
                            </tr>
                    </thead>
                    <tbody> 
                ";
            while($entree=$request->fetch()){
                echo"<tr class=\"success\">
                        <td>".$entree['id_enseignant']."</td>
                        <td>".$entree['prenom']."</td>
                        <td>".$entree['nom']."</td>
                        <td>".$entree['genre']."</td>
                        <td>".$entree['email']."</td>
                        <td>".$entree['login']."</td>
                        <td>".$entree['mdp']."</td>
                    </tr>";
            }
            echo"</tbody></table>";
              
            echo "<br/><br/>";
            // affichage de la liste des classes avec les niveaux
            $request=$pdo->query('SELECT * FROM classe WHERE id_ecole='."\"".$idEcole."\"");
            echo "
            <h3>Liste des classes :</h3>
            <table class=\"table table-success\" id=\"tableEnseign\">
                    <thead>
                        <tr  class=\"danger\">
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

            echo "<br/><br/>";
            // affichage de la liste des matiéres avec les niveaux
            $request=$pdo->query('SELECT * FROM matiere WHERE id_ecole='."\"".$idEcole."\"");
            echo "
            <h3>Liste des matières :</h3>
            <table class=\"table table-success\" id=\"tableMatiere\">
            <thead>
                <tr class=\"danger\">
                    <th scope=\"col\">Id_Matiere</th>
                    <th scope=\"col\">Niveau</th>
                    <th scope=\"col\">Libellé</th>
                    <th scope=\"col\">Coefficient</th>
                    </tr>
            </thead>
            <tbody> 
        ";
    while($entree=$request->fetch()){
        echo"<tr class=\"success\">
                <td>".$entree['id_matiere']."</td>
                <td>".$entree['niveau']."</td>
                <td>".$entree['libelle']."</td>
                <td>".$entree['coefficient']."</td>
            </tr>";
    }
    echo"</tbody></table>";

    echo "<br/><br/>";
    //table affectation
    echo "
    <h3>Liste des affectations :</h3>
    <table class=\"table table-success\" id=\"tableEnseign\">
    <thead>
        <tr class=\"danger\">
            <th scope=\"col\">Nom Enseignant</th>
            <th scope=\"col\">Prenom Enseignant</th>
            <th scope=\"col\">Classe</th>
            <th scope=\"col\">Matiére</th>
            <th scope=\"col\">Niveau</th>
            <th scope=\"col\">Coefficient</th>
            <th scope=\"col\">Année Scolaire</th>
            </tr>
    </thead>
    <tbody> 
    ";
    $request=$pdo->query('SELECT * FROM affectation');
    while($entree=$request->fetch()){
        $idEnseignant=$entree['id_enseignant'];
        $idClasse=$entree['id_classe'];
        $idMatiere=$entree['id_matiere'];
        $reponse=$pdo->query('SELECT prenom,nom FROM enseignant WHERE id_enseignant ='."\"".$idEnseignant."\"");
        $test=$reponse->fetch();
        $reponse1=$pdo->query('SELECT niveau,nom FROM classe WHERE id_classe='."\"".$idClasse."\"");
        $test1=$reponse1->fetch();
        $reponse2=$pdo->query('SELECT libelle,coefficient FROM matiere WHERE id_matiere='."\"".$idMatiere."\"");
        $test2=$reponse2->fetch();
    echo"<tr class=\"success\">
        
        <td>".$test['nom']."</td>
        <td>".$test['prenom']."</td>
        <td>".$test1['nom']."</td>
        <td>".$test2['libelle']."</td>
        <td>".$test1['niveau']."</td>
        <td>".$test2['coefficient']."</td>
        <td>".$entree['anneescolaire']."</td>
    </tr>";
    }
echo"</tbody></table>";

echo "<br/><br/><br/>";

            $request->closeCursor();     
        ?>
                    </aside>
                </div>

            </div>
            <div class="col-md-6 col-sm-6">
                <div id="affectationEnseign" style="display:none">
                    <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                        action="GestionEnseig.php">
                        <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
                        <div class="modifier" id="modifierEnseign">
                            <fieldset>
                                <legend>Affectation des enseignants </legend>
                                <table>
                                    <tr>
                                        <td><span class="label">Id enseignant :</span></td>
                                        <td><input type="text" name="idEnseign" id="idEnseign" /></td>
                                    </tr><br />
                                    <tr>
                                        <td><span class="label">Id classe :</span></td>
                                        <td><input type="text" name="idClasse" id="idClasse" /></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Id matiére :</span></td>
                                        <td><input type="text" name="idMatiere" id="idMatiere" /></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Année scolaire :</span></td>
                                        <td><input type="text" name="annee" id="annee" /></td>
                                    </tr>
                                </table><br />
                                <table>
                                    <tr>
                                        <td>
                                            <div class="envoi2"><input type="submit" name="manipuler" value="Affecter"
                                                    class="btn btn-primary" id="btnsecondaireModif" /></div>
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
