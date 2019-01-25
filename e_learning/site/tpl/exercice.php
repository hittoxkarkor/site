<?php
include "tpl/header.php";
?>	
		<div class="fil_ariane">
			<?php echo $tpl_var['fil_ariane'] ?>	
		</div>
		<div align="center">
			<h1><u>Exercice</u></h1>
			<form action="index.php" method="post">
				<input type="hidden" name="task" value="enregistrement_exercice">
				<input type="hidden" name="un_exercice" value="<?php echo $tpl_var['num_exercice'] ?>">							
				<?php echo $tpl_var['question_exercice'] ?>
				<input type="submit" value="Valider">
			</form>	
		</div>
		<div align="center">
			<?php echo $tpl_var['retour_question'] ?>
		</div>		
<?php
include "tpl/footer.php";
?>
