<?php
include "tpl/header.php";
?>
	<form action="index.php" method="post">
		<input type="hidden" name="task" value="creation_exercice_chapitre">
		<input type="hidden" name="un_cours" value="<?php echo $tpl_var['cours'] ?>">
		<input type="hidden" name="un_chapitre" value="<?php echo $tpl_var['chapitre'] ?>">						
		<div align="center">
			<h1><u>Création d'exercice</u></h1>
			<?php echo $tpl_var['creation_exercice'] ?>
		</div>
		<div align="center">
			<a href="index.php?task=creation_exercice">Retour à la création d'exercice</a>
		</div>
<?php
include "tpl/footer.php";
?>