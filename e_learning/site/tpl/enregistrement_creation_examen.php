<?php
include "tpl/header.php";
?>
	<form action="index.php" method="post">
		<input type="hidden" name="task" value="creation_examen">
		<input type="hidden" name="un_examen" value="<?php echo $tpl_var['examen'] ?>">
		<input type="hidden" name="question_un" value="<?php echo $tpl_var['question_un'] ?>">
		<input type="hidden" name="question_deux" value="<?php echo $tpl_var['question_deux'] ?>">
		<input type="hidden" name="question_trois" value="<?php echo $tpl_var['question_trois'] ?>">
		<input type="hidden" name="question_quatre" value="<?php echo $tpl_var['question_quatre'] ?>">
		<input type="hidden" name="question_cinq" value="<?php echo $tpl_var['question_cinq'] ?>">
		<input type="hidden" name="question_six" value="<?php echo $tpl_var['question_six'] ?>">
		<input type="hidden" name="question_sept" value="<?php echo $tpl_var['question_sept'] ?>">
		<input type="hidden" name="question_huit" value="<?php echo $tpl_var['question_huit'] ?>">
		<input type="hidden" name="question_neuf" value="<?php echo $tpl_var['question_neuf'] ?>">
		<input type="hidden" name="question_dix" value="<?php echo $tpl_var['question_dix'] ?>">
		<input type="hidden" name="question_onze" value="<?php echo $tpl_var['question_onze'] ?>">
		<input type="hidden" name="question_douze" value="<?php echo $tpl_var['question_douze'] ?>">
		<input type="hidden" name="question_treize" value="<?php echo $tpl_var['question_treize'] ?>">
		<input type="hidden" name="question_quatorze" value="<?php echo $tpl_var['question_quatorze'] ?>">
		<input type="hidden" name="question_quinze" value="<?php echo $tpl_var['question_quinze'] ?>">
		<input type="hidden" name="question_seize" value="<?php echo $tpl_var['question_seize'] ?>">
		<input type="hidden" name="question_dix_sept" value="<?php echo $tpl_var['question_dix_sept'] ?>">
		<input type="hidden" name="question_dix_huit" value="<?php echo $tpl_var['question_dix_huit'] ?>">
		<input type="hidden" name="question_dix_neuf" value="<?php echo $tpl_var['question_dix_neuf'] ?>">
		<input type="hidden" name="question_vingt" value="<?php echo $tpl_var['question_vingt'] ?>">
		<input type="hidden" name="une_matiere" value="<?php echo $tpl_var['matiere'] ?>">				
		<div align="center">
			<h1><u>Création d'examen</u></h1>
			<?php echo $tpl_var['creation_examen'] ?>
		</div>
		<div align="center">
			<a href="index.php?task=creation_examen">Retour à la création d'examen</a>
		</div>
<?php
include "tpl/footer.php";
?>