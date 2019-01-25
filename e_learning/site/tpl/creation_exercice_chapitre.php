<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création d'exercice</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_exercice">
					<input type="hidden" name="un_cours" value="<?php echo $tpl_var['cours'] ?>">					
					<?php echo $tpl_var['liste_chapitre'] ?>
					<br>
					<br>
					<label for="un_exercice">Veuillez saisir la question de l'exercice :</label><br>
					<input type="text" name="un_exercice" size="50"><br>
					<br>
					<input type="submit" value="Créer l'exercice" <?php echo $tpl_var['disabled']?> >
				</form>
			</div>
			<br>
		</div>

<?php
include "tpl/footer.php";
?>
