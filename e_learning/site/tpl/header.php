<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./www/bootstrap/bootstrap.min.css">		
        <link rel="stylesheet" type="text/css" href="./www/css/style.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="./www/js/app.js"></script>		
        <title><?php echo $tpl_var['titre_page'] ?></title>
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