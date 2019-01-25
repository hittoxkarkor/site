<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Modification de matière</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_modification_matiere">
					<input type="hidden" name="id_matiere" value="<?php echo $tpl_var['id_matiere'] ?>">					
					<label for="une_matiere">Veuillez saisir le nouvel intitulé de la matière :</label><br>
					<input type="text" name="une_matiere" size="50" value="<?php echo $tpl_var['titre_matiere'] ?>"><br>
					<input type="radio" name="etat" value="1" id="actif" <?php echo $tpl_var['actif'] ?>><label for="actif">Actif</label> <input type="radio" name="etat" value="0" id="inactif" <?php echo $tpl_var['inactif'] ?>><label for="inactif">Inactif</label><br>
					<br>
					<input type="submit" value="Modifier la matière">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
