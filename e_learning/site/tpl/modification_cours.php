<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Modification de cours</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="choisir_modification_matiere_cours">
					<label for="une_matiere">Veuillez choisir une matière :</label><br>
					<select name="une_matiere">
						<?php echo $tpl_var['liste_matiere'] ?>
					</select>
					<br>
					<br>
					<input type="submit" value="Sélectionner la matière">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
