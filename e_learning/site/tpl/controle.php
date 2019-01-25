<?php
include "tpl/header.php";
?>	
		<div class="fil_ariane">
			<?php echo $tpl_var['fil_ariane'] ?>	
		</div>	
		<div align="center">
			<h1><u>Controle</u></h1>
			<form action="index.php" method="post">
				<input type="hidden" name="task" value="enregistrement_controle">
				<input type="hidden" name="une_question_controle" value="<?php echo $tpl_var['num_question_controle'] ?>">							
				<?php echo $tpl_var['question_controle'] ?>
				<input type="submit" value="Valider">
			</form>	
		</div>
		<div align="center">
			<?php echo $tpl_var['retour_questions'] ?>
		</div>
<?php
include "tpl/footer.php";
?>
