<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="administration.css" />
        <title>Administration</title>

        <!--<script language="javascript">
            function validation_gouvernorat(gouvernorat) {
                if (gouvernorat.value == "") {
                    alert("Vous devez saisir votre gouvernorat!");
                    return false;
                }
                return true;
            }
            function validation_delegation(delegation) {
                if (delegation.value == "") {
                    alert("Vous devez saisir votre delegation!");
                    return false;
                }
                return true;
            }
            function validation_nomEcole(nomEcole) {
                if (nomEcole.value == "") {
                    alert("Vous devez saisir votre gouvernorat!");
                    return false;
                }
                return true;
            }
            function validation_genre(genre) {
                if (genre.value == "") {
                    alert("Vous devez saisir votre genre!");
                    return false;
                }
                return true;
            }
            function validation_nom(nom) {
                if (nom.value == "") {
                    alert("Vous devez saisir votre nom!");
                    return false;
                }
                return true;
            }
            function validation_prenom(prenom) {
                if (prenom.value == "") {
                    alert("Vous devez saisir votre prenom!");
                    return false;
                }
                return true;
            }
            function validation_email(email) {
                if (email.value == "") {
                    alert("Vous devez saisir votre email!");
                    return false;
                }
            function validation_mdp(mdp) {
                if (mdp.value == "") {
                    alert("Vous devez saisir votre mot de passe!");
                    return false;
                }
            aux1=email.value.lastIndexOf("@");
            Login=email.value.substring(0,aux1);
            aux2=email.value.lastIndexOf(".");
            Extension=email.value.substring(aux2+1,ChampMail.length);
            Domaine=email.value.substring(aux1+1,aux2);
            
            if(Login.length<=2)
            {
                alert("Ceci n'est pas une adresse mail valide !");
                return false;
            }
        
            if(Domaine.length<=1)
            {
                alert("Ceci n'est pas une adresse mail valide !");
                return false;
            }

            if((Extension.length<2)||(Extension.length>3))
            {
                alert("Ceci n'est pas une adresse mail valide !");
                return false;
            }
            return true;
            }

            function validation(gouvernorat, delegation, nomEcole, genre, nom, prenom, email, mdp){
                return((validation_gouvernorat(gouvernorat)) && (validation_delegation(delegation)) && (validation_nomEcole(nomEcole)) && (validation_genre(genre) && (validation_nom(nom)) && (validation_prenom(prenom)) && validation_email(email)) && validation_mdp(mdp));
            }
        </script>-->
    </head>

<body>
    <form name="formulaire" method="POST" id="form" enctype="application/x-www-form-urlencoded" action="admin.php" >  <!--onsubmit="javascript:return validation(document.formulaire.gouvernorat,document.formulaire.delegation,document.formulaire.nomEcole,document.formulaire.genre,document.formulaire.nom,document.formulaire.prenom,document.formulaire.email);"-->

        <div class="inscription">
            <h3>Inscription</h3>
            <fieldset>
                <table>
                   <tr>
                        <td>Gouvernorat :</td>
                        <td><input type="text" name="gouvernorat" id="gouvernorat" /></td>
                    </tr><br />
                    <tr>
                        <td>Délégation :</td>
                        <td><input type="text" name="delegation" id="delegation" /></td>
                    </tr>
                    <tr>
                        <td>Nom de l'école :</td>
                        <td><input type="text" name="nomEcole" id="nomEcole" /></td>
                    </tr>
                    <tr>
                        <td>Genre :</td>
                        <td><input type="text" name="genre" id="genre" /></td>
                    </tr>
                    <tr>
                        <td>Nom :</td>
                        <td><input type="text" name="nom" id="nom" /></td>
                    </tr>
                    <tr>
                        <td>Prénom :</td>
                        <td><input type="text" name="prenom" id="prenom" /></td>
                    </tr>
                    <tr>
                        <td>Email :</td>
                        <td><input type="text" name="email" id="email" /></td>
                    </tr>
                    <tr>
                        <td>Mot de passe: </td>
                        <td><input type="password" name="mdp" id="mdp" /></td>
                    </tr>
                </table><br />
                <div class="envoi"><input type="submit" name="envoi" value="Envoyer" /></div><br />
            </fieldset>
        </div>
    </form>

    <form name="formulaire" method="POST" action="admin.php" id="form">
        <aside class="connexion">
            <h3>Déjà inscrit? Connectez-vous!</h3>
            <fieldset>
                <table>
                    <tr>
                        <td>Email: </td>
                        <td><input type="text" name="email" id="email" /></td>
                    </tr><br />
                    <tr>
                        <td>Mot de passe: </td>
                        <td><input type="password" name="mdp" id="mdp" /></td>
                    </tr>
                </table><br />
                <div class="connx"><input type="submit" name="envoi" value="Connexion"/></div><br />
            </fieldset>
        </aside>
    </form>
</body>

</html>
