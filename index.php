<?php
session_start();
?>


<!doctype html>

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Carnet de note</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>

    <div>
        <img src="logo2-removebg.png" alt="logo" class="logo">
        <table>
            
            <tr class="button">
                <td>
                    <div class = "butt1" id="box-one"> 
                        <button id="but1" type="button" class="btn btn-primary" >Administration</button>
                    </div>
                    <!--<button type="button" id="but1" class="btn btn-primary init"  onclick="window.location.href = 'Administration.php'">Administration</button>-->
                                        
                </td>
                <td >
                    <div class="butt2" id="box-two"> 
                        <button id="but2" type="button" class="btn btn-primary">&nbsp;Enseignants&nbsp;</button>
                    </div>
                </td>
                <td >
                    <div class="butt3" id="box-three">
                        <button id="but3" type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eleves&nbsp;&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </td>
            </tr>
        </table>
    </div>

                                                  <!-- PARTIE FORMULAIRES -->

                                                   <!--Formulaire Administration-->
    <div id="testform">
        <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded" action="Administration/admin.php" >  
            <div class="inscription" >
                <fieldset>
                    <legend>Inscription</legend>
                    <table>
                       <tr>
                            <td><span class="label">Gouvernorat :</span></td>
                            <td><input type="text" name="gouvernorat" id="gouvernorat" /></td>
                        </tr><br />
                        <tr>
                            <td><span class="label">Délégation :</span></td>
                            <td><input type="text" name="delegation" id="delegation" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Nom de l'école :</span></td>
                            <td><input type="text" name="nomEcole" id="nomEcole" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Genre: </span></td>
                            <td><select name="genre" id="genre">
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="label">Nom :</span></td>
                            <td><input type="text" name="nom" id="nom" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Prénom :</span></td>
                            <td><input type="text" name="prenom" id="prenom" /></td>
                        </tr>
                        <tr>
                            <td><span class="label">Email :</span></td>
                            <td><input type="text" name="email" id="email" /></td>
                        </tr>
                    </table><br />
                    <div class="envoi"><input type="submit" name="envoi" value="Envoyer" class="btn btn-primary" id="btnsecondaire" /></div><br />
                </fieldset>
            </div>
        </form>


        <form name="formulaire" method="POST" action="Administration/admin.php" id="form">
            <aside class="connexion">
                <fieldset>
                    <legend>Déjà inscrit? Connectez-vous!</legend>
                    <table>
                        <tr>
                            <td><span class="label">Email:</span></td>
                            <td><input type="text" name="emailAdmin" id="email" /></td>
                        </tr><br />
                        <tr>
                            <td><span class="label">Mot de passe:</span></td>
                            <td><input type="password" name="mdpAdmin" id="mdp" /></td>
                        </tr>
                    </table><br />
                    <div class="connx"><input type="submit" name="envoi" value="Connexion" class="btn btn-primary" id="btnsecondaire"/></div><br />
                </fieldset>
            </aside>
        </form>
    </div>

                                               <!--Formulaire Enseignants-->
                                               
    <div id="testform1">

        <form name="formulaire" method="POST" action="Enseignant/enseignant.php" id="form">
            <aside class="connexion1">
                <!--<h3>Déjà inscrit? Connectez-vous!</h3>-->
                <fieldset>
                    <legend>Déjà inscrit? Connectez-vous!</legend>
                    <table>
                        <tr>
                            <td><span class="label">Login:</span></td>
                            <td><input type="text" name="loginEnseing" id="login" /></td>
                        </tr><br />
                        
                        <tr>
                            <td><span class="label">Mot de passe: </span></td>
                            <td><input type="password" name="mdpEnseing" id="mdp" /></td>
                        </tr>
                    </table><br />
                    <div class="connx"><input type="submit" name="envoi" value="Connexion" class="btn btn-primary" id="btnsecondaire" /></div><br />
                </fieldset>
            </aside>
        </form>
    </div>

                                                   <!--Formulaire Eléves-->
  
    <div id="testform2">
        <form name="formulaire" method="POST" action="Eleve/eleve.php" id="form">
            <aside class="connexion1">
                <fieldset>
                    <legend>Déjà inscrit? Connectez-vous!</legend>
                    <table>
                        <tr>
                            <td><span class="label">Nom: </span></td>
                            <td><input type="text" name="nomEleve" id="nom" /></td>
                        </tr><br />
                        <tr>
                            <td><span class="label">Prénom: </span></td>
                            <td><input type="text" name="prenomEleve" id="prenom" /></td>
                        </tr><br />
                        <tr>
                            <td><span class="label">Mot de passe: </span></td>
                            <td><input type="password" name="mdpEleve" id="mdp" /></td>
                        </tr>
                    </table><br />
                    <div class="connx"><input type="submit" name="envoi" value="Connexion" class="btn btn-primary" id="btnsecondaire" /></div><br />
                </fieldset>
            </aside>
        </form>
    </div>



                                                <!-- JQuery-->
    <script>
        $(document).ready(function(){

            $('button#but1').click(function(){
                if($('div#box-one').hasClass('butt1')){
                    $('div#box-one').removeClass('butt1').addClass('new_init1');
                    $('div#box-two').removeClass('butt2').addClass('new_init2');
                    $('div#box-three').removeClass('butt3').addClass('new_init3');

                    $("div#testform").css({
                        display: "block",
                        visibility: "visible" 
                    });

                }
                else{
                    if($("div#testform").is(":visible")){
                        $('div#box-one').removeClass('new-init1').addClass('butt1');
                        $('div#box-two').removeClass('new-init2').addClass('butt2');
                        $('div#box-three').removeClass('new-init3').addClass('butt3');

                        $('div#testform').hide();
                        /*$('div#testform1').hide(); we hide just the visible form
                        $('div#testform2').hide();*/ 
                    }
                    else{
                        if($("div#testform1").is(":visible") || $("div#testform2").is(":visible") ){
                            $('div#testform1').hide();
                            $('div#testform2').hide();
                            
                            $("div#testform").css({
                                display: "block",
                                visibility: "visible" 
                            });
                        }
                    }
                }
                
            });
            $('button#but2').click(function(){
                if($('div#box-two').hasClass('butt2')){
                    $('div#box-one').removeClass('butt1').addClass('new_init1');
                    $('div#box-two').removeClass('butt2').addClass('new_init2');
                    $('div#box-three').removeClass('butt3').addClass('new_init3');

                    $("div#testform1").css({
                        display: "block",
                        visibility: "visible" 
                    });
                }
                else{
                    if($("div#testform1").is(":visible")){
                        $('div#box-one').removeClass('new-init1').addClass('butt1');
                        $('div#box-two').removeClass('new-init2').addClass('butt2');
                        $('div#box-three').removeClass('new-init3').addClass('butt3');
                        $('div#testform1').hide();
                    }
                    else{
                        if($("div#testform").is(":visible") || $("div#testform2").is(":visible")){
                            $('div#testform').hide();
                            $('div#testform2').hide();

                            $("div#testform1").css({
                                display: "block",
                                visibility: "visible" 
                            });
                        }
                    }
                }
                
            });
            $('button#but3').click(function(){
                if($('div#box-three').hasClass('butt3')){
                    $('div#box-one').removeClass('butt1').addClass('new_init1');
                    $('div#box-two').removeClass('butt2').addClass('new_init2');
                    $('div#box-three').removeClass('butt3').addClass('new_init3');

                    $("div#testform2").css({
                        display: "block",
                        visibility: "visible" 
                      });
                }
                else{
                    if($("div#testform2").is(":visible")){
                        $('div#box-one').removeClass('new-init1').addClass('butt1');
                        $('div#box-two').removeClass('new-init2').addClass('butt2');
                        $('div#box-three').removeClass('new-init3').addClass('butt3');
                        $('div#testform2').hide();
                    }
                    else{
                        if($("div#testform").is(":visible") || $("div#testform1").is(":visible")){
                            $('div#testform').hide();
                            $('div#testform1').hide();

                            $("div#testform2").css({
                                display: "block",
                                visibility: "visible" 
                              });
                        }
                    }
                }
                
            });
        });
        
    </script>
</body>

</html>