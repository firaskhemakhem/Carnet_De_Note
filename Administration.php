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
                    <!--JQUERY-->
                    <script>
                        $('a#expand').click(function () {
                            $('div#details').slideToggle();
                            $('div#detailsper').hide();
                            $('div#detailsclass').hide();
                            $('div#detailsmat').hide();
                            $('span.linktext').toggle();
                        });

                        $('a#enseignants').click(function () {
                            $('div#detailsper').slideToggle();
                            $('div#details').hide();
                            $('div#detailsclass').hide();
                            $('div#detailsmat').hide();
                            $('span.linktext').toggle();
                        });

                        $('a#classe').click(function () {
                            $('div#detailsclass').slideToggle();
                            $('div#details').hide();
                            $('div#detailsper').hide();
                            $('div#detailsmat').hide();
                            $('span.linktext').toggle();
                        });

                        $('a#matiere').click(function () {
                            $('div#detailsmat').slideToggle();
                            $('div#details').hide();
                            $('div#detailsper').hide();
                            $('div#detailsclass').hide();
                            $('span.linktext').toggle();
                        });
                    </script>

                    <li><a href="#" class="scroll-link" data-id="clients">Affectation Des Enseignants</a></li>
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
        action="DonPersAdmin.php" > <!-- -->
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

    <div id="detailsper" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="GestionEnseig.php">
            <!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
            <div class="modifier">
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
                            <td><div class="envoi3"><input type="submit" name="manipuler" value="Ajouter" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            <td><div class="envoi2"><input type="submit" name="manipuler" value="Modifier" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            <td><div class="envoi0"><input type="submit" name="manipuler" value="Supprimer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                        </tr>

                    </table>
                </fieldset>
            </div>
        </form>
    </div>

    <!--<div id="details135" style="display:none">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded"
            action="GestionEnseig.php">
    --><!--onsubmit="javascript:return validation(document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->
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
                            <td><div class="envoi3"><input type="submit" name="manipuler" value="Ajouter" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            <td><div class="envoi2"><input type="submit" name="manipuler" value="Modifier" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            <td><div class="envoi0"><input type="submit" name="manipuler" value="Supprimer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </form>
    </div>

    <!--Formulaire Gestion des Matiéres-->

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
                            <td ><div class="envoi3"><input type="submit" name="manipuler" value="Ajouter" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            <td ><div class="envoi2"><input type="submit" name="manipuler" value="Modifier" class="btn btn-primary" id="btnsecondaire"/></div></td>
                            <td ><div class="envoi0"><input type="submit" name="manipuler" value="Supprimer" class="btn btn-primary" id="btnsecondaire"/></div></td>
                        </tr>
                        
                    </table>
                </fieldset>
            </div>
        </form>
    </div>
</body>

</html>



