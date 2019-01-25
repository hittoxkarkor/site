<?php
include "tpl/header.php";
?>		
		<div align="center">
			<div id="bloc_creation">
				<h1><u>Création de QCM</u></h1>
				<form action="index.php" method="post">
					<input type="hidden" name="task" value="enregistrement_creation_qcm">
					<input type="hidden" name="un_cours" value="<?php echo $tpl_var['cours'] ?>">					
					<?php echo $tpl_var['liste_chapitre'] ?>
					<br>
					<br>
					<label for="question_un">Veuillez saisir la première question du QCM :</label><br>
					<input type="text" name="question_un" size="50" value="<?php echo $tpl_var['question_un'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					<br>
					<label for="reponse_un_un">Veuillez saisir la première réponse à la première question du QCM :</label><br>
					<input type="text" name="reponse_un_un" size="50" value="<?php echo $tpl_var['reponse_un_un'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_un_un" value="1" id="bonne_un_un" <?php echo $tpl_var['bonne_un_un'] ?>><label for="bonne_un_un">Bonne</label> <input type="radio" name="type_reponse_un_un" value="0" id="fausse_un_un" <?php echo $tpl_var['fausse_un_un'] ?>><label for="fausse_un_un">Fausse</label><br>
					<br>
					<label for="reponse_un_deux">Veuillez saisir la deuxième réponse à la première question du QCM :</label><br>
					<input type="text" name="reponse_un_deux" size="50" value="<?php echo $tpl_var['reponse_un_deux'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_un_deux" value="1" id="bonne_un_deux" <?php echo $tpl_var['bonne_un_trois'] ?>><label for="bonne_un_deux">Bonne</label> <input type="radio" name="type_reponse_un_deux" value="0" id="fausse_un_deux" <?php echo $tpl_var['fausse_un_deux'] ?>><label for="fausse_un_deux">Fausse</label><br>
					<br>
					<label for="reponse_un_trois">Veuillez saisir la troisième réponse à la première question du QCM :</label><br>
					<input type="text" name="reponse_un_trois" size="50" value="<?php echo $tpl_var['reponse_un_trois'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_un_trois" value="1" id="bonne_un_trois" <?php echo $tpl_var['bonne_un_trois'] ?>><label for="bonne_un_trois">Bonne</label> <input type="radio" name="type_reponse_un_trois" value="0" id="fausse_un_trois" <?php echo $tpl_var['fausse_un_trois'] ?>><label for="fausse_un_trois">Fausse</label><br>
					<br>
					<br>
					<label for="question_deux">Veuillez saisir la deuxième question du QCM :</label><br>
					<input type="text" name="question_deux" size="50" value="<?php echo $tpl_var['question_deux'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					<br>
					<label for="reponse_deux_un">Veuillez saisir la première réponse à la deuxième question du QCM :</label><br>
					<input type="text" name="reponse_deux_un" size="50" value="<?php echo $tpl_var['reponse_deux_un'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_deux_un" value="1" id="bonne_deux_un" <?php echo $tpl_var['bonne_deux_un'] ?>><label for="bonne_deux_un">Bonne</label> <input type="radio" name="type_reponse_deux_un" value="0" id="fausse_deux_un" <?php echo $tpl_var['fausse_deux_un'] ?>><label for="fausse_deux_un">Fausse</label><br>
					<br>
					<label for="reponse_deux_deux">Veuillez saisir la deuxième réponse à la deuxième question du QCM :</label><br>
					<input type="text" name="reponse_deux_deux" size="50" value="<?php echo $tpl_var['reponse_deux_deux'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_deux_deux" value="1" id="bonne_deux_deux" <?php echo $tpl_var['bonne_deux_deux'] ?>><label for="bonne_deux_deux">Bonne</label> <input type="radio" name="type_reponse_deux_deux" value="0" id="fausse_deux_deux" <?php echo $tpl_var['fausse_deux_deux'] ?>><label for="fausse_deux_deux">Fausse</label><br>
					<br>
					<label for="reponse_deux_trois">Veuillez saisir la troisième réponse à la deuxième question du QCM :</label><br>
					<input type="text" name="reponse_deux_trois" size="50" value="<?php echo $tpl_var['reponse_deux_trois'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_deux_trois" value="1" id="bonne_deux_trois" <?php echo $tpl_var['bonne_deux_trois'] ?>><label for="bonne_deux_trois">Bonne</label> <input type="radio" name="type_reponse_deux_trois" value="0" id="fausse_deux_trois" <?php echo $tpl_var['fausse_deux_trois'] ?>><label for="fausse_deux_trois">Fausse</label><br>
					<br>
					<br>
					<label for="question_trois">Veuillez saisir la troisième question du QCM :</label><br>
					<input type="text" name="question_trois" size="50" value="<?php echo $tpl_var['question_trois'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					<br>
					<label for="reponse_trois_un">Veuillez saisir la première réponse à la troisième question du QCM :</label><br>
					<input type="text" name="reponse_trois_un" size="50" value="<?php echo $tpl_var['reponse_trois_un'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_trois_un" value="1" id="bonne_trois_un" <?php echo $tpl_var['bonne_trois_un'] ?>><label for="bonne_trois_un">Bonne</label> <input type="radio" name="type_reponse_trois_un" value="0" id="fausse_trois_un" <?php echo $tpl_var['fausse_trois_un'] ?>><label for="fausse_trois_un">Fausse</label><br>
					<br>
					<label for="reponse_trois_deux">Veuillez saisir la deuxième réponse à la troisième question du QCM :</label><br>
					<input type="text" name="reponse_trois_deux" size="50" value="<?php echo $tpl_var['reponse_trois_deux'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_trois_deux" value="1" id="bonne_trois_deux" <?php echo $tpl_var['bonne_trois_deux'] ?>><label for="bonne_trois_deux">Bonne</label> <input type="radio" name="type_reponse_trois_deux" value="0" id="fausse_trois_deux" <?php echo $tpl_var['fausse_trois_deux'] ?>><label for="fausse_trois_deux">Fausse</label><br>
					<br>
					<label for="reponse_trois_trois">Veuillez saisir la troisième réponse à la troisième question du QCM :</label><br>
					<input type="text" name="reponse_trois_trois" size="50" value="<?php echo $tpl_var['reponse_trois_trois'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_trois_trois" value="1" id="bonne_trois_trois" <?php echo $tpl_var['bonne_trois_trois'] ?>><label for="bonne_trois_trois">Bonne</label> <input type="radio" name="type_reponse_trois_trois" value="0" id="fausse_trois_trois" <?php echo $tpl_var['fausse_trois_trois'] ?>><label for="fausse_trois_trois">Fausse</label><br>
					<br>
					<br>
					<label for="question_quatre">Veuillez saisir la quatrième question du QCM :</label><br>
					<input type="text" name="question_quatre" size="50" value="<?php echo $tpl_var['question_quatre'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					<br>
					<label for="reponse_quatre_un">Veuillez saisir la première réponse à la quatrième question du QCM :</label><br>
					<input type="text" name="reponse_quatre_un" size="50" value="<?php echo $tpl_var['reponse_quatre_un'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_quatre_un" value="1" id="bonne_quatre_un" <?php echo $tpl_var['bonne_quatre_un'] ?>><label for="bonne_quatre_un">Bonne</label> <input type="radio" name="type_reponse_quatre_un" value="0" id="fausse_quatre_un" <?php echo $tpl_var['fausse_quatre_un'] ?>><label for="fausse_quatre_un">Fausse</label><br>
					<br>
					<label for="reponse_quatre_deux">Veuillez saisir la deuxième réponse à la quatrième question du QCM :</label><br>
					<input type="text" name="reponse_quatre_deux" size="50" value="<?php echo $tpl_var['reponse_quatre_deux'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_quatre_deux" value="1" id="bonne_quatre_deux" <?php echo $tpl_var['bonne_quatre_deux'] ?>><label for="bonne_quatre_deux">Bonne</label> <input type="radio" name="type_reponse_quatre_deux" value="0" id="fausse_quatre_deux" <?php echo $tpl_var['fausse_quatre_deux'] ?>><label for="fausse_quatre_deux">Fausse</label><br>
					<br>
					<label for="reponse_quatre_trois">Veuillez saisir la troisième réponse à la quatrième question du QCM :</label><br>
					<input type="text" name="reponse_quatre_trois" size="50" value="<?php echo $tpl_var['reponse_quatre_trois'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_quatre_trois" value="1" id="bonne_quatre_trois" <?php echo $tpl_var['bonne_quatre_trois'] ?>><label for="bonne_quatre_trois">Bonne</label> <input type="radio" name="type_reponse_quatre_trois" value="0" id="fausse_quatre_trois" <?php echo $tpl_var['fausse_quatre_trois'] ?>><label for="fausse_quatre_trois">Fausse</label><br>
					<br>
					<br>
					<label for="question_cinq">Veuillez saisir la cinquième question du QCM :</label><br>
					<input type="text" name="question_cinq" size="50" value="<?php echo $tpl_var['question_cinq'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					<br>
					<label for="reponse_cinq_un">Veuillez saisir la première réponse à la cinquième question du QCM :</label><br>
					<input type="text" name="reponse_cinq_un" size="50" value="<?php echo $tpl_var['reponse_cinq_un'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_cinq_un" value="1" id="bonne_cinq_un" <?php echo $tpl_var['bonne_cinq_un'] ?>><label for="bonne_cinq_un">Bonne</label> <input type="radio" name="type_reponse_cinq_un" value="0" id="fausse_cinq_un" <?php echo $tpl_var['fausse_cinq_un'] ?>><label for="fausse_cinq_un">Fausse</label><br>
					<br>
					<label for="reponse_cinq_deux">Veuillez saisir la deuxième réponse à la cinquième question du QCM :</label><br>
					<input type="text" name="reponse_cinq_deux" size="50" value="<?php echo $tpl_var['reponse_cinq_deux'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_cinq_deux" value="1" id="bonne_cinq_deux" <?php echo $tpl_var['bonne_cinq_deux'] ?>><label for="bonne_cinq_deux">Bonne</label> <input type="radio" name="type_reponse_cinq_deux" value="0" id="fausse_cinq_deux" <?php echo $tpl_var['fausse_cinq_deux'] ?>><label for="fausse_cinq_deux">Fausse</label><br>
					<br>
					<label for="reponse_cinq_trois">Veuillez saisir la troisième réponse à la cinquième question du QCM :</label><br>
					<input type="text" name="reponse_cinq_trois" size="50" value="<?php echo $tpl_var['reponse_cinq_trois'] ?>" <?php echo $tpl_var['readonly'] ?>><br>
					La réponse est-elle bonne ou fausse ?<br>
					<input type="radio" name="type_reponse_cinq_trois" value="1" id="bonne_cinq_trois" <?php echo $tpl_var['bonne_cinq_trois'] ?>><label for="bonne_cinq_trois">Bonne</label> <input type="radio" name="type_reponse_cinq_trois" value="0" id="fausse_cinq_trois" <?php echo $tpl_var['fausse_cinq_trois'] ?>><label for="fausse_cinq_trois">Fausse</label><br>
					<br>																																			
					<input type="submit" value="Créer le QCM" <?php echo $tpl_var['disabled']?> >
				</form>
			</div>
			<br>
		</div>

<?php
include "tpl/footer.php";
?>
