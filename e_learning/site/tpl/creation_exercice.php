<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création d'exercice</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="creation_exercice_cours">
					<label for="une_matiere">Veuillez choisir une matière :</label><br>
					<select name="une_matiere">
						<?php echo $tpl_var['liste_matiere'] ?>
					</select>
					<br>
					<br>
					<input type="submit" value="Sélectionner">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
