<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création de matière</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_matiere">
					<label for="une_matiere">Veuillez saisir l'intitulé de la matière :</label><br>
					<input type="text" name="une_matiere" size="50"><br>
					<br>
					<input type="submit" value="Créer la matière">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
