<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Modification de chapitre</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_modification_chapitre">
					<input type="hidden" name="id_chapitre" value="<?php echo $tpl_var['id_chapitre'] ?>">					
					<label for="un_chapitre">Veuillez saisir le nouvel intitulé du chapitre :</label><br>
					<input type="text" name="un_chapitre" size="50" value="<?php echo $tpl_var['titre_chapitre'] ?>"><br>
					<label for="un_cours">Veuillez saisir le nouvel url de la vidéo :</label><br>					
					<input type="text" name="un_url" size="50" value="<?php echo $tpl_var['url'] ?>"><br>
					<input type="radio" name="etat" value="1" id="actif" <?php echo $tpl_var['actif'] ?>><label for="actif">Actif</label> <input type="radio" name="etat" value="0" id="inactif" <?php echo $tpl_var['inactif'] ?>><label for="inactif">Inactif</label><br>
					<br>
					<input type="submit" value="Modifier le chapitre">
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
