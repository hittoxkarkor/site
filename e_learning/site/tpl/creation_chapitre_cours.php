<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création de chapitre de cours</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_chapitre_cours">
					<?php echo $tpl_var['liste_cours'] ?>
					<br>
					<br>
					<label for="un_chapitre">Veuillez saisir l'intitulé du chapitre de cours :</label><br>
					<input type="text" name="un_chapitre" size="50" <?php echo $tpl_var['readonly']?>><br>
					<br>
					<label for="un_cours">Veuillez mettre l'URL de la vidéo :</label><br>
					<input type="text" name="une_video" size="50" <?php echo $tpl_var['readonly']?>><br>
					<br>
					<input type="submit" value="Créer le chapitre" <?php echo $tpl_var['disabled']?> >
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
