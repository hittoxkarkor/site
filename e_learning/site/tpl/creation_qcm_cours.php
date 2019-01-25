<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création de QCM</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="creation_qcm_chapitre">
					<input type="hidden" name="une_matiere" value="<?php echo $tpl_var['matiere'] ?>">
						<?php echo $tpl_var['liste_cours'] ?>
					<br>
					<br>
					<input type="submit" value="Sélectionner" <?php echo $tpl_var['disabled'] ?>>
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
