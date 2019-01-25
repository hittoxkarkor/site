<?php
include "tpl/header.php";
?>	
		<div align="center">
			<h1><u>QCM</u></h1>
			<form action="index.php" method="post">
				<input type="hidden" name="task" value="verification_qcm">
				<input type="hidden" name="un_fichier" value="<?php echo $tpl_var['fichier'] ?>">				
				<?php echo $tpl_var['liste_qcm'] ?>
				<?php echo "<p>".$tpl_var['erreur']."</p>" ?>
				<input type="submit" value="Valider">
			</form>	
		</div>
<?php
include "tpl/footer.php";
?>