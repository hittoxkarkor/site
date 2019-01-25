<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création de cours</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_cours">
					<label for="une_matiere">Veuillez choisir une matière :</label><br>
					<select name="une_matiere">
						<?php echo $tpl_var['liste_matiere'] ?>
					</select>
					<br>
					<br>
					<label for="un_cours">Veuillez saisir l'intitulé du cours :</label><br>
					<input type="text" name="un_cours" size="50"><br>
					<br>
					<input type="submit" value="Créer le cours">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
