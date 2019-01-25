<?php

class Examens extends Modele {

	//Vérification s'il existe au moins un QCM
    static public function verifQCM(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_QCM");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }
	
	//Liste des questions du QCM
    static public function listeQcm($fichier) {
        $qcm = array();
		$dbh = self::getConnexion();
        $liste_qcm = $dbh->prepare("SELECT NUM_QCM,CN_ID_QCM FROM T_QCM WHERE NUM_FICHIER = '$fichier' AND ACTIF = '1'");
        $liste_qcm->execute();
		while ($row_liste_qcm = $liste_qcm->fetch(PDO::FETCH_NUM)) {
            $qcm[] = array(
                'num_id' => $row_liste_qcm[0],
                'cn_id_qcm' => $row_liste_qcm[1]
			);
		}
        return $qcm;
    } 
    
	//Liste des réponses du QCM
    static public function listeRepQcm($qcm) {
        $repqcm = array();
		$dbh = self::getConnexion();
        $liste_rep_qcm = $dbh->prepare("SELECT NUM_REPONSE_QCM,CN_ID_REPONSE_QCM,ETAT FROM T_REPONSE_QCM WHERE NUM_QCM = '$qcm' AND ACTIF = '1'");
        $liste_rep_qcm->execute();
		while ($row_liste_rep_qcm = $liste_rep_qcm->fetch(PDO::FETCH_NUM)) {
            $repqcm[] = array(
                'num_reponse_qcm' => $row_liste_rep_qcm[0],                
                'cn_id_reponse_qcm' => $row_liste_rep_qcm[1],
                'etat' => $row_liste_rep_qcm[2]
            );
        }
        return $repqcm;
    }     

	//Enregistrement des réponses du QCM
    static public function noteRepQcm($note,$qcm,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_NOTE_QCM WHERE NUM_QCM = $qcm AND NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];             
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_NOTE_QCM` (`NUM_NOTE_QCM`, `ACTIF`, `USER_CREATION`, `DATE_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_NOTE_QCM`, `NUM_USER`, `NUM_QCM`, `NOTE_QCM_USER`) 
            VALUES (NULL, '1', '$nom', NOW(), '$nom', NOW(), NULL, '$num_user', '$qcm', '$note');");
            $creer->execute();
        } else {
            $maj = $dbh->prepare("UPDATE T_NOTE_QCM SET USER_MAJ='$nom', DATE_MAJ = NOW(), NOTE_QCM_USER = '$note' WHERE NUM_QCM = '$qcm' AND NUM_USER = '$num_user'");
            $maj->execute();
        }     
    } 

	//Enregistrement des réponses du QCM
    static public function validationQcm($qcm,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];       
        $verif = $dbh->prepare("SELECT CN_ID_NOTE_QCM FROM T_NOTE_QCM WHERE NUM_QCM = '$qcm' AND NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);        
        $existe = $row_verif[0];   
        if ($existe == NULL) {
            var_dump($existe); 
            $validation = $dbh->prepare("UPDATE T_NOTE_QCM SET CN_ID_NOTE_QCM ='Validé' WHERE NUM_QCM = '$qcm' AND NUM_USER = '$num_user'");
            $validation->execute();
        }
    } 

	//Vérification s'il existe au moins un Exercice
    static public function verifExercice(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_EXERCICE");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }    

	//Liste des Exercices
    static public function listeExercices($cours) {
        $exercices = array();
		$dbh = self::getConnexion();
        $liste_exercices = $dbh->prepare("SELECT NUM_EXERCICE FROM T_EXERCICE INNER JOIN T_CHAPITRE_COURS ON T_EXERCICE.NUM_CHAPITRE_COURS = T_CHAPITRE_COURS.NUM_CHAPITRE_COURS WHERE T_CHAPITRE_COURS.NUM_COURS = '$cours' AND T_EXERCICE.ACTIF = '1'");
        $liste_exercices->execute();
		while ($row_liste_exercices = $liste_exercices->fetch(PDO::FETCH_NUM)) {
            $exercices[] = array(
                'num_exercice' => $row_liste_exercices[0]             
            );
        }
        return $exercices;
    }  
    
	//Question des Exercices
    static public function questionExercice($exercice) {
		$dbh = self::getConnexion();
        $question_exercice = $dbh->prepare("SELECT CN_ID_EXERCICE FROM T_EXERCICE WHERE NUM_EXERCICE = '$exercice' AND ACTIF = '1'");
        $question_exercice->execute();
        $row_question = $question_exercice->fetch(PDO::FETCH_NUM);
        $question = $row_question[0];
        return $question;
    }          

	//Enregistrement des Réponses des Exercices
    static public function enregistrementReponseExercice($exercice,$reponse,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_REPONSE_EXERCICE WHERE NUM_EXERCICE = $exercice AND NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_REPONSE_EXERCICE` (`NUM_REPONSE_EXERCICE`, `ACTIF`, `USER_CREATION`, `DATE_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_EXERCICE`, `CORRECTION_EXERCICE`,`VALIDATION`, `NUM_EXERCICE`, `NUM_USER`) 
            VALUES (NULL, '1', '$nom', NOW(), '$nom', NOW(), '$reponse', NULL , 'FALSE', '$exercice', '$num_user');");
            $creer->execute();
            return 0;
        } else {
            return 1;
        }     
    } 

	//Vérification s'il existe au moins un Controle
    static public function verifControle(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_CONTROLE");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }    

	//Liste des Controles
    static public function listeControles($matiere) {
        $controles = array();
		$dbh = self::getConnexion();
        $liste_controles = $dbh->prepare("SELECT NUM_CONTROLE FROM T_CONTROLE INNER JOIN T_COURS ON T_CONTROLE.NUM_COURS = T_COURS.NUM_COURS  WHERE NUM_MATIERE = '$matiere' AND T_CONTROLE.ACTIF = '1' ORDER BY NUM_CONTROLE");
        $liste_controles->execute();
		while ($row_liste_controles = $liste_controles->fetch(PDO::FETCH_NUM)) {
            $controles[] = array(
                'num_controle' => $row_liste_controles[0]             
            );
        }
        return $controles;
    }  

	//Vérification s'il existe au moins un Controle
    static public function verifQuestionControle(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_QUESTION_CONTROLE");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }  

	//Liste question des Controles
    static public function listeQuestionControle($controle) {
        $liste_question_controle = array();
		$dbh = self::getConnexion();
        $liste_question = $dbh->prepare("SELECT NUM_QUESTION_CONTROLE FROM T_QUESTION_CONTROLE WHERE NUM_CONTROLE = '$controle' AND ACTIF = '1'");
        $liste_question->execute();
		while ($row_liste_question = $liste_question->fetch(PDO::FETCH_NUM)) {
            $liste_question_controle[] = array(
                'num_question_controle' => $row_liste_question[0]             
            );
        }
        return $liste_question_controle;
    }  

	//Question des Controle
    static public function questionControle($question) {
		$dbh = self::getConnexion();
        $question_controle = $dbh->prepare("SELECT CN_ID_QUESTION_CONTROLE FROM T_QUESTION_CONTROLE WHERE NUM_QUESTION_CONTROLE = '$question' AND ACTIF = '1'");
        $question_controle->execute();
        $row_question = $question_controle->fetch(PDO::FETCH_NUM);
        $question = $row_question[0];
        return $question;
    }      

	//Enregistrement des Réponses des Controles
    static public function enregistrementReponseControle($question_controle,$reponse_controle,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_REPONSE_CONTROLE WHERE NUM_QUESTION_CONTROLE = $question_controle AND NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_REPONSE_CONTROLE` (`NUM_REPONSE_CONTROLE`, `ACTIF`, `USER_CREATION`, `DATE_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_CONTROLE`, `CORRECTION_CONTROLE`,`VALIDATION`, `NUM_QUESTION_CONTROLE`, `NUM_USER`) 
            VALUES (NULL, '1', '$nom', NOW(), '$nom', NOW(), '$reponse_controle', NULL , 'FALSE', '$question_controle', '$num_user');");
            $creer->execute();
            return 0;
        } else {
            return 1;
        }     
    } 

	//Vérification s'il existe au moins un Examen
    static public function verifExamen(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_EXAMEN_BLANC");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }

	//Liste des Examens
    static public function listeExamens() {
        $examens = array();
		$dbh = self::getConnexion();
        $liste_examens = $dbh->prepare("SELECT NUM_EXAMEN_BLANC, CN_ID_EXAMEN_BLANC FROM T_EXAMEN_BLANC WHERE ACTIF = '1'");
        $liste_examens->execute();
		while ($row_liste_examens = $liste_examens->fetch(PDO::FETCH_NUM)) {
            $examens[] = array(
                'num_examen' => $row_liste_examens[0],
                'cn_id_examen' => $row_liste_examens[1]            
            );
        }
        return $examens;
    }  

	//Vérification s'il existe au moins un Examen
    static public function verifQuestionExamen(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_QUESTION_EXAMEN_BLANC");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }    

	//Liste des questions des Examens
    static public function listeQuestionExamen($examen) {
        $liste_question_examen = array();
		$dbh = self::getConnexion();
        $liste_question = $dbh->prepare("SELECT NUM_QUESTION_EXAMEN_BLANC FROM T_QUESTION_EXAMEN_BLANC WHERE NUM_EXAMEN_BLANC = '$examen' AND ACTIF = '1'");
        $liste_question->execute();
		while ($row_liste_question = $liste_question->fetch(PDO::FETCH_NUM)) {
            $liste_question_examen[] = array(
                'num_question_examen' => $row_liste_question[0]             
            );
        }
        return $liste_question_examen;
    }  

	//Question des Examens
    static public function questionExamen($question) {
		$dbh = self::getConnexion();
        $question_examen = $dbh->prepare("SELECT CN_ID_QUESTION_EXAMEN_BLANC FROM T_QUESTION_EXAMEN_BLANC WHERE NUM_QUESTION_EXAMEN_BLANC = '$question' AND ACTIF = '1'");
        $question_examen->execute();
        $row_question = $question_examen->fetch(PDO::FETCH_NUM);
        $question = $row_question[0];
        return $question;
    }      

	//Enregistrement des Réponses des Examens
    static public function enregistrementReponseExamen($question_examen,$reponse_examen,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_REPONSE_EXAMEN_BLANC WHERE NUM_QUESTION_EXAMEN_BLANC = $question_examen AND NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_REPONSE_EXAMEN_BLANC` (`NUM_REPONSE_EXAMEN_BLANC`, `ACTIF`, `USER_CREATION`, `DATE_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_EXAMEN_BLANC`, `CORRECTION_EXAMEN_BLANC`,`VALIDATION`, `NUM_QUESTION_EXAMEN_BLANC`, `NUM_USER`) 
            VALUES (NULL, '1', '$nom', NOW(), '$nom', NOW(), '$reponse_examen', NULL , 'FALSE', '$question_examen', '$num_user');");
            $creer->execute();
            return 0;
        } else {
            return 1;
        }     
    } 

	//Vérification si des exercices ont au moins une note
    static public function exercicesVerification($identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $verif_exercices = $dbh->prepare("SELECT COUNT(*) FROM T_NOTE_EXERCICE WHERE NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif_exercices->execute();
        $row_verif_exercices = $verif_exercices->fetch(PDO::FETCH_NUM);
        $existe_exercice = $row_verif_exercices[0];  
        if ($existe_exercice != '0') {
            $resultat = 1;
        } else {
            $resultat = 0;
        }
        return $resultat;
    } 

	//Vérification si des exercices ont été réalisés
    static public function exericesRealises($cours,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $nombre_exercices_realises = $dbh->prepare("SELECT COUNT(*) FROM T_REPONSE_EXERCICE INNER JOIN T_EXERCICE ON T_REPONSE_EXERCICE.NUM_EXERCICE = T_EXERCICE.NUM_EXERCICE INNER JOIN T_CHAPITRE_COURS ON T_EXERCICE.NUM_CHAPITRE_COURS = T_CHAPITRE_COURS.NUM_CHAPITRE_COURS WHERE T_CHAPITRE_COURS.NUM_COURS = $cours AND NUM_USER = '$num_user' AND T_REPONSE_EXERCICE.ACTIF = '1'");
        $nombre_exercices_realises->execute();
        $row_nombre_exercices_realises = $nombre_exercices_realises->fetch(PDO::FETCH_NUM);
        $resultat = $row_nombre_exercices_realises[0];
        return $resultat;
    } 

	//Nombre d'exercices par cours
    static public function nombreExercices($cours) {
        $dbh = self::getConnexion(); 
        $nombre_exercices = $dbh->prepare("SELECT COUNT(*) FROM T_EXERCICE INNER JOIN T_CHAPITRE_COURS ON T_EXERCICE.NUM_CHAPITRE_COURS = T_CHAPITRE_COURS.NUM_CHAPITRE_COURS WHERE T_CHAPITRE_COURS.NUM_COURS = $cours AND T_EXERCICE.ACTIF = '1'");
        $nombre_exercices->execute();
        $row_nombre_exercices = $nombre_exercices->fetch(PDO::FETCH_NUM);
        $resultat = $row_nombre_exercices[0];
        return $resultat;
    } 

	//Note des exercices réalisés par cours
    static public function noteExercices($cours,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $note_exercices = $dbh->prepare("SELECT SUM(CN_ID_NOTE_EXERCICE) FROM T_NOTE_EXERCICE INNER JOIN T_REPONSE_EXERCICE ON T_NOTE_EXERCICE.NUM_REPONSE_EXERCICE = T_REPONSE_EXERCICE.NUM_REPONSE_EXERCICE INNER JOIN T_EXERCICE ON T_REPONSE_EXERCICE.NUM_EXERCICE = T_EXERCICE.NUM_EXERCICE INNER JOIN T_CHAPITRE_COURS ON T_EXERCICE.NUM_CHAPITRE_COURS = T_CHAPITRE_COURS.NUM_CHAPITRE_COURS WHERE T_CHAPITRE_COURS.NUM_COURS = $cours AND T_NOTE_EXERCICE.NUM_USER = '$num_user' AND T_NOTE_EXERCICE.ACTIF = '1'");
        $note_exercices->execute();
        $row_note_exercices = $note_exercices->fetch(PDO::FETCH_NUM);
        $resultat = $row_note_exercices[0];
        if ($resultat == NULL) {
            $resultat = 0;
        }
        return $resultat;
    } 

	//Vérification si des contrôles ont au moins une note
    static public function controlesVerification($identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $verif_controles = $dbh->prepare("SELECT COUNT(*) FROM T_NOTE_CONTROLE WHERE NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif_controles->execute();
        $row_verif_controles = $verif_controles->fetch(PDO::FETCH_NUM);
        $existe_controle = $row_verif_controles[0];  
        if ($existe_controle != '0') {
            $resultat = 1;
        } else {
            $resultat = 0;
        }
        return $resultat;
    } 

	//Nombre de controles par matières
    static public function nombreControles($matiere) {
        $dbh = self::getConnexion(); 
        $nombre_controles = $dbh->prepare("SELECT COUNT(*) FROM T_CONTROLE INNER JOIN T_COURS ON T_CONTROLE.NUM_COURS = T_COURS.NUM_COURS WHERE T_COURS.NUM_MATIERE = $matiere AND T_CONTROLE.ACTIF = '1'");
        $nombre_controles->execute();
        $row_nombre_controles = $nombre_controles->fetch(PDO::FETCH_NUM);
        $resultat = $row_nombre_controles[0];
        return $resultat;
    } 

	//Note des controles réalisés par matières
    static public function noteControles($controle,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $note_controles = $dbh->prepare("SELECT SUM(CN_ID_NOTE_CONTROLE) FROM T_NOTE_CONTROLE INNER JOIN T_REPONSE_CONTROLE ON T_NOTE_CONTROLE.NUM_REPONSE_CONTROLE = T_REPONSE_CONTROLE.NUM_REPONSE_CONTROLE INNER JOIN T_QUESTION_CONTROLE ON T_REPONSE_CONTROLE.NUM_QUESTION_CONTROLE = T_QUESTION_CONTROLE.NUM_QUESTION_CONTROLE WHERE T_QUESTION_CONTROLE.NUM_CONTROLE = $controle AND T_NOTE_CONTROLE.NUM_USER = $num_user AND T_NOTE_CONTROLE.ACTIF = '1'");
        $note_controles->execute();
        $row_note_controles = $note_controles->fetch(PDO::FETCH_NUM);
        $resultat = $row_note_controles[0];
        if ($resultat == NULL) {
            $resultat = 0;
        }
        return $resultat;
    } 

	//Vérification si des examens ont au moins une note
    static public function examensVerification($identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $verif_examens = $dbh->prepare("SELECT COUNT(*) FROM T_NOTE_EXAMEN_BLANC WHERE NUM_USER = '$num_user' AND ACTIF = '1'");
        $verif_examens->execute();
        $row_verif_examens = $verif_examens->fetch(PDO::FETCH_NUM);
        $existe_examen = $row_verif_examens[0];  
        if ($existe_examen != '0') {
            $resultat = 1;
        } else {
            $resultat = 0;
        }
        return $resultat;
    } 

	//Note des examens réalisés par matières
    static public function noteExamens($examen,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];   
        $note_examens = $dbh->prepare("SELECT SUM(CN_ID_NOTE_EXAMEN_BLANC) FROM T_NOTE_EXAMEN_BLANC INNER JOIN T_REPONSE_EXAMEN_BLANC ON T_NOTE_EXAMEN_BLANC.NUM_REPONSE_EXAMEN_BLANC = T_REPONSE_EXAMEN_BLANC.NUM_REPONSE_EXAMEN_BLANC INNER JOIN T_QUESTION_EXAMEN_BLANC ON T_REPONSE_EXAMEN_BLANC.NUM_QUESTION_EXAMEN_BLANC = T_QUESTION_EXAMEN_BLANC.NUM_QUESTION_EXAMEN_BLANC WHERE T_QUESTION_EXAMEN_BLANC.NUM_EXAMEN_BLANC = $examen AND T_NOTE_EXAMEN_BLANC.NUM_USER = '$num_user' AND T_NOTE_EXAMEN_BLANC.ACTIF = '1'");
        $note_examens->execute();
        $row_note_examens = $note_examens->fetch(PDO::FETCH_NUM);
        $resultat = $row_note_examens[0];
        if ($resultat == NULL) {
            $resultat = 0;
        }
        return $resultat;
    } 

	//Récupération du numéro d'examen
    static public function numExamen($question_examen) {
        $dbh = self::getConnexion(); 
        $num_examen = $dbh->prepare("SELECT NUM_EXAMEN_BLANC FROM T_QUESTION_EXAMEN_BLANC WHERE NUM_QUESTION_EXAMEN_BLANC = $question_examen AND ACTIF = '1'");
        $num_examen->execute();
        $row_num_examen = $num_examen->fetch(PDO::FETCH_NUM);
        $resultat = $row_num_examen[0];
        return $resultat;
    } 

	//Récupération du NUM_MATIERE et du CN_ID_MATIERE pour le fil d'ariane de la page des questions des controles
    static public function arianeControle($controle) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_controle = $dbh->prepare("SELECT T_COURS.NUM_MATIERE, CN_ID_MATIERE FROM T_MATIERE INNER JOIN T_COURS ON T_MATIERE.NUM_MATIERE = T_COURS.NUM_MATIERE INNER JOIN T_CONTROLE ON T_COURS.NUM_COURS = T_CONTROLE.NUM_COURS WHERE T_CONTROLE.NUM_CONTROLE = '$controle'");
        $ariane_controle->execute();
		while ($row_ariane_controle = $ariane_controle->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_matiere' => $row_ariane_controle[0],
                'cn_id_matiere' => $row_ariane_controle[1]
			);
		}
        return $ariane;
    }

	//Récupération du NUM_MATIERE et du CN_ID_MATIERE pour le fil d'ariane de la page des controles
    static public function arianeListeControle($matiere) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_liste_controle = $dbh->prepare("SELECT NUM_MATIERE, CN_ID_MATIERE FROM T_MATIERE WHERE NUM_MATIERE = '$matiere'");
        $ariane_liste_controle->execute();
		while ($row_ariane_liste_controle = $ariane_liste_controle->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_matiere' => $row_ariane_liste_controle[0],
                'cn_id_matiere' => $row_ariane_liste_controle[1]
			);
		}
        return $ariane;
    }

	//Récupération du NUM_MATIERE et du CN_ID_MATIERE pour le fil d'ariane de la page de validation des réponses du controle
    static public function arianeQuestionControle($controle) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_question_controle = $dbh->prepare("SELECT T_COURS.NUM_MATIERE, CN_ID_MATIERE FROM T_MATIERE INNER JOIN T_COURS ON T_MATIERE.NUM_MATIERE = T_COURS.NUM_MATIERE INNER JOIN T_CONTROLE ON T_COURS.NUM_COURS = T_CONTROLE.NUM_COURS INNER JOIN T_QUESTION_CONTROLE ON T_CONTROLE.NUM_CONTROLE = T_QUESTION_CONTROLE.NUM_CONTROLE WHERE T_QUESTION_CONTROLE.NUM_QUESTION_CONTROLE = '$controle'");
        $ariane_question_controle->execute();
		while ($row_ariane_question_controle = $ariane_question_controle->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_matiere' => $row_ariane_question_controle[0],
                'cn_id_matiere' => $row_ariane_question_controle[1]
			);
		}
        return $ariane;
    }

	//Récupération du numéro de matiere
    static public function numMatiere($controle) {
        $dbh = self::getConnexion(); 
        $num_matiere = $dbh->prepare("SELECT NUM_MATIERE FROM T_COURS INNER JOIN T_CONTROLE ON T_COURS.NUM_COURS = T_CONTROLE.NUM_COURS WHERE NUM_CONTROLE = $controle AND T_COURS.ACTIF = '1'");
        $num_matiere->execute();
        $row_num_matiere = $num_matiere->fetch(PDO::FETCH_NUM);
        $resultat = $row_num_matiere[0];
        return $resultat;
    } 

	//Récupération du numéro de controle
    static public function numControle($question_controle) {
        $dbh = self::getConnexion(); 
        $num_controle = $dbh->prepare("SELECT NUM_CONTROLE FROM T_QUESTION_CONTROLE WHERE NUM_QUESTION_CONTROLE = $question_controle AND ACTIF = '1'");
        $num_controle->execute();
        $row_num_controle = $num_controle->fetch(PDO::FETCH_NUM);
        $resultat = $row_num_controle[0];
        return $resultat;
    } 

	//Récupération du NUM_MATIERE, du CN_ID_MATIERE, du NUM_COURS et du CN_ID_COURS pour le fil d'ariane de la page des exercices
    static public function arianeListeExercice($cours) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_liste_exercice = $dbh->prepare("SELECT T_MATIERE.NUM_MATIERE, CN_ID_MATIERE, NUM_COURS, CN_ID_COURS FROM T_MATIERE INNER JOIN T_COURS ON T_MATIERE.NUM_MATIERE = T_COURS.NUM_MATIERE WHERE NUM_COURS = '$cours'");
        $ariane_liste_exercice->execute();
		while ($row_ariane_liste_exercice = $ariane_liste_exercice->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_matiere' => $row_ariane_liste_exercice[0],
                'cn_id_matiere' => $row_ariane_liste_exercice[1],
                'num_cours' => $row_ariane_liste_exercice[2],
                'cn_id_cours' => $row_ariane_liste_exercice[3]
			);
		}
        return $ariane;
    }

//Récupération du NUM_MATIERE, du CN_ID_MATIERE, du NUM_COURS et du CN_ID_COURS pour le fil d'ariane de la page de question des exercices
    static public function arianeExercice($exercice) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_exercice = $dbh->prepare("SELECT T_MATIERE.NUM_MATIERE, CN_ID_MATIERE, T_COURS.NUM_COURS, CN_ID_COURS FROM T_MATIERE INNER JOIN T_COURS ON T_MATIERE.NUM_MATIERE = T_COURS.NUM_MATIERE INNER JOIN T_CHAPITRE_COURS ON T_COURS.NUM_COURS = T_CHAPITRE_COURS.NUM_COURS INNER JOIN T_EXERCICE ON T_CHAPITRE_COURS.NUM_CHAPITRE_COURS = T_EXERCICE.NUM_CHAPITRE_COURS WHERE NUM_EXERCICE = '$exercice'");
        $ariane_exercice->execute();
		while ($row_ariane_exercice = $ariane_exercice->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_matiere' => $row_ariane_exercice[0],
                'cn_id_matiere' => $row_ariane_exercice[1],
                'num_cours' => $row_ariane_exercice[2],
                'cn_id_cours' => $row_ariane_exercice[3]
			);
		}
        return $ariane;
    }
  
	//Récupération du numéro de Cours
    static public function numCOurs($exercice) {
        $dbh = self::getConnexion(); 
        $num_cours = $dbh->prepare("SELECT NUM_COURS FROM T_CHAPITRE_COURS INNER JOIN T_EXERCICE ON T_CHAPITRE_COURS.NUM_CHAPITRE_COURS = T_EXERCICE.NUM_CHAPITRE_COURS WHERE NUM_EXERCICE = $exercice AND T_EXERCICE.ACTIF = '1'");
        $num_cours->execute();
        $row_num_cours = $num_cours->fetch(PDO::FETCH_NUM);
        $resultat = $row_num_cours[0];
        return $resultat;
    } 

	//Enregistrement de création d'un Examen
    static public function enregistrementCreationExamen($matiere,$examen,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$question_onze,$question_douze,$question_treize,$question_quatorze,$question_quinze,$question_seize,$question_dix_sept,$question_dix_huit,$question_dix_neuf,$question_vingt,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_EXAMEN_BLANC WHERE CN_ID_EXAMEN_BLANC = '$examen' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_EXAMEN_BLANC` (`NUM_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_EXAMEN_BLANC`, `NUM_MATIERE`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$examen', '$matiere');");
            $creer->execute();
            $recup_num_examen = $dbh->prepare("SELECT NUM_EXAMEN_BLANC FROM T_EXAMEN_BLANC WHERE ACTIF = '1' ORDER BY NUM_EXAMEN_BLANC DESC LIMIT 1");  
            $recup_num_examen->execute(); 
            $row_num_examen = $recup_num_examen->fetch(PDO::FETCH_NUM);
            $num_examen = $row_num_examen[0];   
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_un', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_deux', $num_examen)");
            $creer_question->execute();            
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_trois', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_quatre', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_cinq', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_six', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_sept', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_huit', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_neuf', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_dix', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_onze', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_douze', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_treize', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_quatorze', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_quinze', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_seize', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_dix_sept', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_dix_huit', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_dix_neuf', $num_examen)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_EXAMEN_BLANC` (`NUM_QUESTION_EXAMEN_BLANC`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_EXAMEN_BLANC`, `NUM_EXAMEN_BLANC`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_vingt', $num_examen)");
            $creer_question->execute();                                                                                                                                                                                                                        
            return 0;
        } else {
            return 1;
        }     
    } 

	//Enregistrement de création d'un Controle
    static public function enregistrementCreationControle($cours,$controle,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_CONTROLE WHERE CN_ID_CONTROLE = '$controle' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_CONTROLE` (`NUM_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_CONTROLE`, `NUM_COURS`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$controle', '$cours');");
            $creer->execute();
            $recup_num_controle = $dbh->prepare("SELECT NUM_CONTROLE FROM T_CONTROLE WHERE ACTIF = '1' ORDER BY NUM_CONTROLE DESC LIMIT 1");  
            $recup_num_controle->execute(); 
            $row_num_controle = $recup_num_controle->fetch(PDO::FETCH_NUM);
            $num_controle = $row_num_controle[0];   
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_un', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_deux', $num_controle)");
            $creer_question->execute();            
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_trois', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_quatre', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_cinq', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_six', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_sept', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_huit', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_neuf', $num_controle)");
            $creer_question->execute();
            $creer_question = $dbh->prepare("INSERT INTO `T_QUESTION_CONTROLE` (`NUM_QUESTION_CONTROLE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QUESTION_CONTROLE`, `NUM_CONTROLE`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_dix', $num_controle)");
            $creer_question->execute();                                                                                                                                                                                                                  
            return 0;
        } else {
            return 1;
        }     
    }     

	//Enregistrement de création d'un Exercice
    static public function enregistrementCreationExercice($chapitre,$exercice,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_EXERCICE WHERE CN_ID_EXERICE = '$exercice' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer = $dbh->prepare("INSERT INTO `T_EXERCICE` (`NUM_EXERCICE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_EXERCICE`, `NUM_CHAPITRE_COURS`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$exercice', '$chapitre');");
            $creer->execute();                                                                                                                                                                               
            return 0;
        } else {
            return 1;
        }     
    }     

	//Enregistrement de création d'un QCM
    static public function enregistrementCreationQCM($chapitre,$question_un,$reponse_un_un,$etat_un_un,$reponse_un_deux,$etat_un_deux,$reponse_un_trois,$etat_un_trois,$question_deux,$reponse_deux_un,$etat_deux_un,$reponse_deux_deux,$etat_deux_deux,$reponse_deux_trois,$etat_deux_trois,$question_trois,$reponse_trois_un,$etat_trois_un,$reponse_trois_deux,$etat_trois_deux,$reponse_trois_trois,$etat_trois_trois,$question_quatre,$reponse_quatre_un,$etat_quatre_un,$reponse_quatre_deux,$etat_quatre_deux,$reponse_quatre_trois,$etat_quatre_trois,$question_cinq,$reponse_cinq_un,$etat_cinq_un,$reponse_cinq_deux,$etat_cinq_deux,$reponse_cinq_trois,$etat_cinq_trois,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];  
        $recup_num_fichier = $dbh->prepare("SELECT NUM_FICHIER FROM T_FICHIER WHERE NUM_CHAPITRE_COURS = '$chapitre' AND ACTIF = '1'");
        $recup_num_fichier->execute();
        $row_num_fichier = $recup_num_fichier->fetch(PDO::FETCH_NUM);
        $num_fichier = $row_num_fichier[0];           
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_QCM WHERE NUM_FICHIER = '$num_fichier' AND ACTIF = '1'");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];        
        if ($existe == 0){
            $creer_question = $dbh->prepare("INSERT INTO `T_QCM` (`NUM_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QCM`, `NUM_FICHIER`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_un', '$num_fichier');");
            $creer_question->execute();
            $recup_num_qcm = $dbh->prepare("SELECT NUM_QCM FROM T_QCM WHERE ACTIF = '1' ORDER BY NUM_QCM DESC LIMIT 1");  
            $recup_num_qcm->execute(); 
            $row_num_qcm = $recup_num_qcm->fetch(PDO::FETCH_NUM);
            $num_qcm = $row_num_qcm[0];   
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_un_un', '$etat_un_un', $num_qcm)");
            $creer_reponse->execute();
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_un_deux', '$etat_un_deux', $num_qcm)");
            $creer_reponse->execute();            
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_un_trois', '$etat_un_trois', $num_qcm)");
            $creer_reponse->execute();            
            $creer_question = $dbh->prepare("INSERT INTO `T_QCM` (`NUM_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QCM`, `NUM_FICHIER`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_deux', '$num_fichier');");
            $creer_question->execute();
            $recup_num_qcm = $dbh->prepare("SELECT NUM_QCM FROM T_QCM WHERE ACTIF = '1' ORDER BY NUM_QCM DESC LIMIT 1");  
            $recup_num_qcm->execute(); 
            $row_num_qcm = $recup_num_qcm->fetch(PDO::FETCH_NUM);
            $num_qcm = $row_num_qcm[0];   
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_deux_un', '$etat_deux_un', $num_qcm)");
            $creer_reponse->execute();
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_deux_deux', '$etat_deux_deux', $num_qcm)");
            $creer_reponse->execute();            
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_deux_trois', '$etat_deux_trois', $num_qcm)");
            $creer_reponse->execute(); 
            $creer_question = $dbh->prepare("INSERT INTO `T_QCM` (`NUM_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QCM`, `NUM_FICHIER`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_trois', '$num_fichier');");
            $creer_question->execute();
            $recup_num_qcm = $dbh->prepare("SELECT NUM_QCM FROM T_QCM WHERE ACTIF = '1' ORDER BY NUM_QCM DESC LIMIT 1");  
            $recup_num_qcm->execute(); 
            $row_num_qcm = $recup_num_qcm->fetch(PDO::FETCH_NUM);
            $num_qcm = $row_num_qcm[0];   
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_trois_un', '$etat_trois_un', $num_qcm)");
            $creer_reponse->execute();
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_trois_deux', '$etat_trois_deux', $num_qcm)");
            $creer_reponse->execute();            
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_trois_trois', '$etat_trois_trois', $num_qcm)");
            $creer_reponse->execute(); 
            $creer_question = $dbh->prepare("INSERT INTO `T_QCM` (`NUM_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QCM`, `NUM_FICHIER`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_quatre', '$num_fichier');");
            $creer_question->execute();
            $recup_num_qcm = $dbh->prepare("SELECT NUM_QCM FROM T_QCM WHERE ACTIF = '1' ORDER BY NUM_QCM DESC LIMIT 1");  
            $recup_num_qcm->execute(); 
            $row_num_qcm = $recup_num_qcm->fetch(PDO::FETCH_NUM);
            $num_qcm = $row_num_qcm[0];   
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_quatre_un', '$etat_quatre_un', $num_qcm)");
            $creer_reponse->execute();
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_quatre_deux', '$etat_quatre_deux', $num_qcm)");
            $creer_reponse->execute();            
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_quatre_trois', '$etat_quatre_trois', $num_qcm)");
            $creer_reponse->execute(); 
            $creer_question = $dbh->prepare("INSERT INTO `T_QCM` (`NUM_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_QCM`, `NUM_FICHIER`) 
            VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$question_cinq', '$num_fichier');");
            $creer_question->execute();
            $recup_num_qcm = $dbh->prepare("SELECT NUM_QCM FROM T_QCM WHERE ACTIF = '1' ORDER BY NUM_QCM DESC LIMIT 1");  
            $recup_num_qcm->execute(); 
            $row_num_qcm = $recup_num_qcm->fetch(PDO::FETCH_NUM);
            $num_qcm = $row_num_qcm[0];   
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_cinq_un', '$etat_cinq_un', $num_qcm)");
            $creer_reponse->execute();
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_cinq_deux', '$etat_cinq_deux', $num_qcm)");
            $creer_reponse->execute();            
            $creer_reponse = $dbh->prepare("INSERT INTO `T_REPONSE_QCM` (`NUM_REPONSE_QCM`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_REPONSE_QCM`, `ETAT`, `NUM_QCM`)
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$reponse_cinq_trois', '$etat_cinq_trois', $num_qcm)");
            $creer_reponse->execute();                         
            return 0;
        } else {
            return 1;
        }     
    }       

}
    
