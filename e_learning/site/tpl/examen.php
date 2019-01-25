<?php
include "tpl/header.php";
?>	
		<div align="center">
			<h1><u>Examen</u></h1>
			<form action="index.php" method="post">
				<input type="hidden" name="task" value="enregistrement_examen">
				<input type="hidden" name="une_question_examen" value="<?php echo $tpl_var['num_question_examen'] ?>">							
				<?php echo $tpl_var['question_examen'] ?>
				<input type="submit" value="Valider">
			</form>	
		</div>
		<div align="center">
			<?php echo $tpl_var['retour_questions'] ?>
		</div>
<?php
include "tpl/footer.php";
?>