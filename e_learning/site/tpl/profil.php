<?php
include "tpl/header.php";
?>
		<div align="center">
			<h1><u>Profil</u></h1>
			<table>
				<tr>
					<td>Civilite :</td>
					<td><?php echo $tpl_var['civilite'] ?></td>
				</tr>
				<tr>
					<td>Nom :</td>
					<td><?php echo $tpl_var['nom'] ?></td>
				</tr>
				<tr>
					<td>Prénom :</td>
					<td><?php echo $tpl_var['prenom'] ?></td>
				</tr>	
				<tr>
					<td>Mot de passe :</td>
					<td><?php echo $tpl_var['motdepasse'] ?></td>
				</tr>
				<tr>
					<td>Cursus :</td>
					<td><?php echo $tpl_var['groupe'] ?></td>
				</tr>
				<tr>
					<td>Spécialité :</td>
					<td><?php echo $tpl_var['specialite'] ?></td>
				</tr>			
			</table>
			<br>
			<?php echo $tpl_var['notes'] ?>
		</div>
<?php
include "tpl/footer.php";
?>