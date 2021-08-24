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
                    


                    <li><a href="#" class="scroll-link" data-id="clients">Affectation Des Enseignants</a></li>
                    <!--<li><a href="#" class="scroll-link" data-id="contact">Contact</a></li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

   
    <!--Formulaire Gestion des Enseignants-->

    <!-- choix de manipulation -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div id="affichEnseign" style="display:block">
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
            $request=$pdo->query('SELECT * FROM matiere');
            // affichage de la table 
            echo "<table class=\"table table-success\" id=\"tableMatiere\">
                    <thead>
                        <tr class=\"danger\">
                            <th scope=\"col\">Id_Matiere</th>
                            <th scope=\"col\">Id_Ecole</th>
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
                        <td>".$entree['id_ecole']."</td>
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
                <div id="detailsper" style="display:block">
                            <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                        action="AdminGestionMatiere.php">
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
                                <table>
                                          <tr>
                                           <td><div class="envoi"><input type="submit" name="ModifMatiere" value="Enregistrer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                                           <td><div classe="envoi1"><input type="submit" name="ModifMatiere" value="Annuler" class="btn btn-primary" id="btnsecondaire"></div></td>
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