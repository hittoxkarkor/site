<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Modification de cours</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="choisir_modification_cours">
					<?php echo $tpl_var['liste_cours'] ?>
					<br>
					<br>
					<input type="submit" value="Sélectionner le cours" <?php echo $tpl_var['disabled'] ?>>
				</form>
			</div>

		</div>

<?php
include "tpl/footer.php";
?>
