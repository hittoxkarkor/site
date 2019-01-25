<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Modification de cours</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_modification_cours">
					<input type="hidden" name="id_cours" value="<?php echo $tpl_var['id_cours'] ?>">					
					<label for="un_cours">Veuillez saisir le nouvel intitulé de la matière :</label><br>
					<input type="text" name="un_cours" size="50" value="<?php echo $tpl_var['titre_cours'] ?>"><br>
					<input type="radio" name="etat" value="1" id="actif" <?php echo $tpl_var['actif'] ?>><label for="actif">Actif</label> <input type="radio" name="etat" value="0" id="inactif" <?php echo $tpl_var['inactif'] ?>><label for="inactif">Inactif</label><br>
					<br>
					<input type="submit" value="Modifier le cours">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
