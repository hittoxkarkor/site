<?php
include "tpl/header.php";
?>
	<form action="index.php" method="post">
		<input type="hidden" name="task" value="creation_controle_cours">
		<input type="hidden" name="un_controle" value="<?php echo $tpl_var['controle'] ?>">
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
		<input type="hidden" name="un_cours" value="<?php echo $tpl_var['cours'] ?>">
		<input type="hidden" name="une_matiere" value="<?php echo $tpl_var['matiere'] ?>">						
		<div align="center">
			<h1><u>Création de contrôle</u></h1>
			<?php echo $tpl_var['creation_controle'] ?>
		</div>
		<div align="center">
			<a href="index.php?task=creation_controle">Retour à la création de contrôles</a>
		</div>
<?php
include "tpl/footer.php";
?>