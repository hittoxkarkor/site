<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./www/bootstrap/bootstrap.min.css">	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
        <link rel="stylesheet" type="text/css" href="./www/css/style.css">
		<link rel="stylesheet" type="text/css" href="./www/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="./www/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="./www/css/component.css" />
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="./www/js/app.js"></script>	
		<script src="./www/js/modernizr.custom.js"></script>	
        <title><?php echo $tpl_var['titre_page'] ?></title>
		<meta name="keywords" content="google nexus 7 menu, css transitions, sidebar, side menu, slide out menu" />
		<meta name="author" content="Codrops" /> 			
		<link rel="shortcut icon" href="../favicon.ico">
    </head>

    <body>
		<div class="content">
			<div id="header" class="container-fluid" >
				<a href="./index.php?task=retour_accueil">E-LEARNING</a>
			</div>
			<div id="menu"  class="container-fluid" >
				<a href="./index.php?task=retour_accueil">Accueil</a> 
				<a href="./index.php?task=matiere">Matières</a> 
				<a href="./index.php?task=profil">Profil</a>
				<?php echo $tpl_var['creation_contenu'] ?>	
				<?php echo $tpl_var['modification_contenu'] ?>								
				<a href="./index.php?task=logout">Déconnexion</a>
			</div>