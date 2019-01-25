<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="www/css/bootstrap/css/bootstrap.min.css" id="bootstrap-css" type="text/css" />
        <link rel="stylesheet" href="www/css/connexion.css" type="text/css" />		
        <title>Connexion</title>
    </head>

<body id="LoginForm">
	<div class="container">
	<div class="login-form">
	<div class="main-div">
    <div class="panel">
		<h2>Connexion</h2>
   <p>Veuillez entrer vos identifiants de connexion </p>
   </div>
    <form id="Login" action="index.php" method="POST">
        <input type="hidden" name="task" value="login">

        <div class="form-group">

            <input type="email" class="form-control" id="inputEmail" placeholder="Adresse Mail" name="un_identifiant">

        </div>

        <div class="form-group">

            <input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe" name="un_mdp">

        </div>

        <div> 

            <?php if ($tpl_var['avec_erreur']){
            echo "<span id=\"erreur\">" . $tpl_var['message'] . "</span>";} ?>
        
        </div>
       
        <div class="form-login">
            <button type="submit" class="btn btn-outline-primary">Valider </button>
            <button type="submit" class="btn btn-outline-warning"> Un problème ?</button>
        </div>
        

    </form>
    </div>
</div></div></div>

</body>
</html>