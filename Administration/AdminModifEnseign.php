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
           
            <div class="navbar-header">
                
                <a class="navbar-brand scroll-top" href="#"><span id="admin">Administrations</span></a>
            </div>
            
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
                    
                </ul>
            </div>
            
        </div>
        
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
            $reponse = $pdo->query('SELECT id_ecole FROM administration WHERE email='."\"".$_SESSION["emailAdmin"]."\"".' AND mdp='."\"".$_SESSION["mdpAdmin"]."\"");
            $entree=$reponse->fetch();
            $idEcole=$entree['id_ecole'];  
            $request=$pdo->query('SELECT * FROM enseignant WHERE id_ecole='."\"".$idEcole."\"");  
            // affichage de la table 
            echo "<table class=\"table table-success\" id=\"tableEnseign\">
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
            $request->closeCursor();     
        ?>
                    </aside>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div id="detailsper" style="display:block">
                            <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
                        action="AdminGestionEnseign.php">
                        
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

                                <table>
                                    <tr>
                                        <td><div class="envoi"><input type="submit" name="ModifEnseign" value="Enregistrer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                                        <td><div classe="envoi1"><input type="submit" name="ModifEnseign" value="Annuler" class="btn btn-primary" id="btnsecondaire"></div></td>
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
