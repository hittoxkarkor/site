<?php
include "tpl/header.php";
?>
	<form action="index.php" method="post">
		<input type="hidden" name="task" value="creation_qcm_chapitre">
		<input type="hidden" name="un_cours" value="<?php echo $tpl_var['cours'] ?>">
		<input type="hidden" name="un_chapitre" value="<?php echo $tpl_var['chapitre'] ?>">
		<input type="hidden" name="question_un" value="<?php echo $tpl_var['question_un'] ?>">
		<input type="hidden" name="reponse_un_un" value="<?php echo $tpl_var['reponse_un_un'] ?>">
		<input type="hidden" name="etat_un_un" value="<?php echo $tpl_var['etat_un_un'] ?>">
		<input type="hidden" name="reponse_un_deux" value="<?php echo $tpl_var['reponse_un_deux'] ?>">
		<input type="hidden" name="etat_un_deux" value="<?php echo $tpl_var['etat_un_deux'] ?>">
		<input type="hidden" name="reponse_un_trois" value="<?php echo $tpl_var['reponse_un_trois'] ?>">
		<input type="hidden" name="etat_un_trois" value="<?php echo $tpl_var['etat_un_trois'] ?>">
		<input type="hidden" name="question_deux" value="<?php echo $tpl_var['question_deux'] ?>">
		<input type="hidden" name="reponse_deux_un" value="<?php echo $tpl_var['reponse_deux_un'] ?>">
		<input type="hidden" name="etat_deux_un" value="<?php echo $tpl_var['etat_deux_un'] ?>">
		<input type="hidden" name="reponse_deux_deux" value="<?php echo $tpl_var['reponse_deux_deux'] ?>">
		<input type="hidden" name="etat_deux_deux" value="<?php echo $tpl_var['etat_deux_deux'] ?>">
		<input type="hidden" name="reponse_deux_trois" value="<?php echo $tpl_var['reponse_deux_trois'] ?>">
		<input type="hidden" name="etat_deux_trois" value="<?php echo $tpl_var['etat_deux_trois'] ?>">
		<input type="hidden" name="question_trois" value="<?php echo $tpl_var['question_trois'] ?>">
		<input type="hidden" name="reponse_trois_un" value="<?php echo $tpl_var['reponse_trois_un'] ?>">
		<input type="hidden" name="etat_trois_un" value="<?php echo $tpl_var['etat_trois_un'] ?>">
		<input type="hidden" name="reponse_trois_deux" value="<?php echo $tpl_var['reponse_trois_deux'] ?>">
		<input type="hidden" name="etat_trois_deux" value="<?php echo $tpl_var['etat_trois_deux'] ?>">
		<input type="hidden" name="reponse_trois_trois" value="<?php echo $tpl_var['reponse_trois_trois'] ?>">
		<input type="hidden" name="etat_trois_trois" value="<?php echo $tpl_var['etat_trois_trois'] ?>">
		<input type="hidden" name="question_quatre" value="<?php echo $tpl_var['question_quatre'] ?>">
		<input type="hidden" name="reponse_quatre_un" value="<?php echo $tpl_var['reponse_quatre_un'] ?>">
		<input type="hidden" name="etat_quatre_un" value="<?php echo $tpl_var['etat_quatre_un'] ?>">
		<input type="hidden" name="reponse_quatre_deux" value="<?php echo $tpl_var['reponse_quatre_deux'] ?>">
		<input type="hidden" name="etat_quatre_deux" value="<?php echo $tpl_var['etat_quatre_deux'] ?>">
		<input type="hidden" name="reponse_quatre_trois" value="<?php echo $tpl_var['reponse_quatre_trois'] ?>">
		<input type="hidden" name="etat_quatre_trois" value="<?php echo $tpl_var['etat_quatre_trois'] ?>">
		<input type="hidden" name="question_cinq" value="<?php echo $tpl_var['question_cinq'] ?>">
		<input type="hidden" name="reponse_cinq_un" value="<?php echo $tpl_var['reponse_cinq_un'] ?>">
		<input type="hidden" name="etat_cinq_un" value="<?php echo $tpl_var['etat_cinq_un'] ?>">
		<input type="hidden" name="reponse_cinq_deux" value="<?php echo $tpl_var['reponse_cinq_deux'] ?>">
		<input type="hidden" name="etat_cinq_deux" value="<?php echo $tpl_var['etat_cinq_deux'] ?>">
		<input type="hidden" name="reponse_cinq_trois" value="<?php echo $tpl_var['reponse_cinq_trois'] ?>">
		<input type="hidden" name="etat_cinq_trois" value="<?php echo $tpl_var['etat_cinq_trois'] ?>">								
		<div align="center">
			<h1><u>Création de QCM </u></h1>
			<?php echo $tpl_var['creation_qcm'] ?>
		</div>
		<div align="center">
			<a href="index.php?task=creation_qcm">Retour à la création de QCM</a>
		</div>
<?php
include "tpl/footer.php";
?>