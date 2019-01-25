<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création de contrôle</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_controle">
					<input type="hidden" name="une_matiere" value="<?php echo $tpl_var['matiere'] ?>">					
					<?php echo $tpl_var['liste_cours'] ?>
					<br>
					<br>
					<label for="un_controle">Veuillez saisir l'intitulé du contrôle :</label><br>
					<input type="text" name="un_controle" size="50" value="<?php echo $tpl_var['controle'] ?>" <?php echo $tpl_var['readonly']?>><br>
					<br>
					<label for="question_un">Veuillez saisir l'intitulé de la première question :</label><br>
					<input type="text" name="question_un" size="50" value="<?php echo $tpl_var['question_un'] ?>" <?php echo $tpl_var['readonly']?>><br>
					<label for="question_deux">Veuillez saisir l'intitulé de la deuxième question :</label><br>
					<input type="text" name="question_deux" size="50" value="<?php echo $tpl_var['question_deux'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_trois">Veuillez saisir l'intitulé de la troisième question :</label><br>
					<input type="text" name="question_trois" size="50" value="<?php echo $tpl_var['question_trois'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_quatre">Veuillez saisir l'intitulé de la quatrième question :</label><br>
					<input type="text" name="question_quatre" size="50" value="<?php echo $tpl_var['question_quatre'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_cinq">Veuillez saisir l'intitulé de la cinquième question :</label><br>
					<input type="text" name="question_cinq" size="50" value="<?php echo $tpl_var['question_cinq'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_six">Veuillez saisir l'intitulé de la sixième question :</label><br>
					<input type="text" name="question_six" size="50" value="<?php echo $tpl_var['question_six'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_sept">Veuillez saisir l'intitulé de la septième question :</label><br>
					<input type="text" name="question_sept" size="50" value="<?php echo $tpl_var['question_sept'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_huit">Veuillez saisir l'intitulé de la huitième question :</label><br>
					<input type="text" name="question_huit" size="50" value="<?php echo $tpl_var['question_huit'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_neuf">Veuillez saisir l'intitulé de la neuvième question :</label><br>
					<input type="text" name="question_neuf" size="50" value="<?php echo $tpl_var['question_neuf'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<label for="question_dix">Veuillez saisir l'intitulé de la dixième question :</label><br>
					<input type="text" name="question_dix" size="50" value="<?php echo $tpl_var['question_dix'] ?>" <?php echo $tpl_var['readonly']?>><br>	
					<br>
					<input type="submit" value="Créer le contrôle" <?php echo $tpl_var['disabled']?> >
				</form>
			</div>
			<br>
		</div>

<?php
include "tpl/footer.php";
?>
