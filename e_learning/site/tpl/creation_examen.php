<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création d'examen</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_examen">
					<label for="une_matiere">Veuillez choisir une matière :</label><br>
					<select name="une_matiere">
						<?php echo $tpl_var['liste_matiere'] ?>
					</select>
					<br>
					<br>
					<label for="un_examen">Veuillez saisir l'intitulé de l'examen :</label><br>
					<input type="text" name="un_examen" size="50" value="<?php echo $tpl_var['examen'] ?>"><br>
					<br>
					<label for="question_un">Veuillez saisir l'intitulé de la première question :</label><br>
					<input type="text" name="question_un" size="50" value="<?php echo $tpl_var['question_un'] ?>"><br>
					<label for="question_deux">Veuillez saisir l'intitulé de la deuxième question :</label><br>
					<input type="text" name="question_deux" size="50" value="<?php echo $tpl_var['question_deux'] ?>"><br>	
					<label for="question_trois">Veuillez saisir l'intitulé de la troisième question :</label><br>
					<input type="text" name="question_trois" size="50" value="<?php echo $tpl_var['question_trois'] ?>"><br>	
					<label for="question_quatre">Veuillez saisir l'intitulé de la quatrième question :</label><br>
					<input type="text" name="question_quatre" size="50" value="<?php echo $tpl_var['question_quatre'] ?>"><br>	
					<label for="question_cinq">Veuillez saisir l'intitulé de la cinquième question :</label><br>
					<input type="text" name="question_cinq" size="50" value="<?php echo $tpl_var['question_cinq'] ?>"><br>	
					<label for="question_six">Veuillez saisir l'intitulé de la sixième question :</label><br>
					<input type="text" name="question_six" size="50" value="<?php echo $tpl_var['question_six'] ?>"><br>	
					<label for="question_sept">Veuillez saisir l'intitulé de la septième question :</label><br>
					<input type="text" name="question_sept" size="50" value="<?php echo $tpl_var['question_sept'] ?>"><br>	
					<label for="question_huit">Veuillez saisir l'intitulé de la huitième question :</label><br>
					<input type="text" name="question_huit" size="50" value="<?php echo $tpl_var['question_huit'] ?>"><br>	
					<label for="question_neuf">Veuillez saisir l'intitulé de la neuvième question :</label><br>
					<input type="text" name="question_neuf" size="50" value="<?php echo $tpl_var['question_neuf'] ?>"><br>	
					<label for="question_dix">Veuillez saisir l'intitulé de la dixième question :</label><br>
					<input type="text" name="question_dix" size="50" value="<?php echo $tpl_var['question_dix'] ?>"><br>	
					<label for="question_onze">Veuillez saisir l'intitulé de la onzième question :</label><br>
					<input type="text" name="question_onze" size="50" value="<?php echo $tpl_var['question_onze'] ?>"><br>	
					<label for="question_douze">Veuillez saisir l'intitulé de la douzième question :</label><br>
					<input type="text" name="question_douze" size="50" value="<?php echo $tpl_var['question_douze'] ?>"><br>	
					<label for="question_treize">Veuillez saisir l'intitulé de la treizième question :</label><br>
					<input type="text" name="question_treize" size="50" value="<?php echo $tpl_var['question_treize'] ?>"><br>	
					<label for="question_quatorze">Veuillez saisir l'intitulé de la quatorzième question :</label><br>
					<input type="text" name="question_quatorze" size="50" value="<?php echo $tpl_var['question_quatorze'] ?>"><br>	
					<label for="question_quinze">Veuillez saisir l'intitulé de la quinzième question :</label><br>
					<input type="text" name="question_quinze" size="50" value="<?php echo $tpl_var['question_quinze'] ?>"><br>	
					<label for="question_seize">Veuillez saisir l'intitulé de la seizième question :</label><br>
					<input type="text" name="question_seize" size="50" value="<?php echo $tpl_var['question_seize'] ?>"><br>	
					<label for="question_dix-sept">Veuillez saisir l'intitulé de la dix-septième question :</label><br>
					<input type="text" name="question_dix_sept" size="50" value="<?php echo $tpl_var['question_dix_sept'] ?>"><br>	
					<label for="question_dix-huit">Veuillez saisir l'intitulé de la dix-huitième question :</label><br>
					<input type="text" name="question_dix_huit" size="50" value="<?php echo $tpl_var['question_dix_huit'] ?>"><br>	
					<label for="question_dix-neuf">Veuillez saisir l'intitulé de la dix-neuvième question :</label><br>
					<input type="text" name="question_dix_neuf" size="50" value="<?php echo $tpl_var['question_dix_neuf'] ?>"><br>	
					<label for="question_vingt">Veuillez saisir l'intitulé de la vingtième question :</label><br>
					<input type="text" name="question_vingt" size="50" value="<?php echo $tpl_var['question_vingt'] ?>"><br>	
					<br>																																																																																																				
					<input type="submit" value="Créer l'examen">
				</form>
			</div>
			<br>
		</div>

<?php
include "tpl/footer.php";
?>
