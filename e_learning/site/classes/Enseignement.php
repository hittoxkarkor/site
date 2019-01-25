<?php

class Enseignement extends Modele {

	//Vérification s'il existe au moins une matière
    static public function verifMatieres(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_MATIERE");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }

	//Récupération de la liste des Matières, avec CN_ID_MATIERE et NUM_MATIERE
    static public function listeMatieres() {
        $matieres = array();
		$dbh = self::getConnexion();
        $liste_matiere = $dbh->prepare("SELECT NUM_MATIERE, CN_ID_MATIERE FROM T_MATIERE WHERE ACTIF = '1'");
        $liste_matiere->execute();
		while ($row_liste_matiere = $liste_matiere->fetch(PDO::FETCH_NUM)) {
            $matieres[] = array(
                'num_matiere' => $row_liste_matiere[0],
                'cn_id_matiere' => $row_liste_matiere[1]
			);
		}
        return $matieres;
    } 

	//Récupération du titre de la Matière
    static public function titreMatiere($matiere){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT CN_ID_MATIERE FROM T_MATIERE WHERE NUM_MATIERE = '$matiere'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $titre = $row_recup[0];
        return $titre;
    }


 	//Vérification s'il existe au moins un cours
     static public function verifCours($matiere){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_COURS WHERE NUM_MATIERE = $matiere");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe;
    }

	//Récupération du titre du cours
    static public function titreCours($cours){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT CN_ID_COURS FROM T_COURS WHERE NUM_COURS = '$cours'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $titre = $row_recup[0];
        return $titre;
    }    
 
	//Récupération de la liste des Cours, avec CN_ID_COURS et NUM_COURS
    static public function listeCours($matiere) {
        $cours = array();
		$dbh = self::getConnexion();
        $liste_cours = $dbh->prepare("SELECT NUM_COURS, CN_ID_COURS FROM T_COURS WHERE NUM_MATIERE = '$matiere' AND ACTIF = '1'");
        $liste_cours->execute();
		while ($row_liste_cours = $liste_cours->fetch(PDO::FETCH_NUM)) {
            $cours[] = array(
                'num_cours' => $row_liste_cours[0],
                'cn_id_cours' => $row_liste_cours[1]
			);
		}
        return $cours;
    }

	//Récupération du NUM_MATIERE et du CN_ID_MATIERE
    static public function arianeCours($cours) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_cours = $dbh->prepare("SELECT T_COURS.NUM_MATIERE, CN_ID_MATIERE FROM T_MATIERE INNER JOIN T_COURS ON T_MATIERE.NUM_MATIERE = T_COURS.NUM_MATIERE WHERE T_COURS.NUM_COURS = '$cours'");
        $ariane_cours->execute();
		while ($row_ariane_cours = $ariane_cours->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_matiere' => $row_ariane_cours[0],
                'cn_id_matiere' => $row_ariane_cours[1]
			);
		}
        return $ariane;
    }

	//Récupération du NUM_COURS et du CN_ID_COURS
    static public function arianeChapitre($chapitre) {
        $ariane = array();
		$dbh = self::getConnexion();
        $ariane_chapitre = $dbh->prepare("SELECT T_CHAPITRE_COURS.NUM_COURS, CN_ID_COURS, T_COURS.NUM_MATIERE, CN_ID_MATIERE  FROM T_CHAPITRE_COURS INNER JOIN T_COURS ON T_CHAPITRE_COURS.NUM_COURS = T_COURS.NUM_COURS INNER JOIN T_MATIERE ON T_COURS.NUM_MATIERE = T_MATIERE.NUM_MATIERE WHERE T_CHAPITRE_COURS.NUM_CHAPITRE_COURS = '$chapitre'");
        $ariane_chapitre->execute();
		while ($row_ariane_chapitre = $ariane_chapitre->fetch(PDO::FETCH_NUM)) {
            $ariane[] = array(
                'num_cours' => $row_ariane_chapitre[0],
                'cn_id_cours' => $row_ariane_chapitre[1],
                'num_matiere' => $row_ariane_chapitre[2],
                'cn_id_matiere' => $row_ariane_chapitre[3]                
			);
		}
        return $ariane;
    }

 	//Vérification s'il existe au moins un chapitre de cours
     static public function verifChapitres($cours){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_CHAPITRE_COURS WHERE NUM_COURS = $cours");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }
 
	//Récupération de la liste des Chapitres de cours, avec CN_ID_CHAPITRE_COURS et NUM_CHAPITRE_COURS
    static public function listeChapitres($cours) {
        $chapitre = array();
		$dbh = self::getConnexion();
        $liste_chapitre = $dbh->prepare("SELECT NUM_CHAPITRE_COURS, CN_ID_CHAPITRE_COURS FROM T_CHAPITRE_COURS WHERE NUM_COURS = '$cours' AND ACTIF = '1'");
        $liste_chapitre->execute();
		while ($row_liste_chapitre = $liste_chapitre->fetch(PDO::FETCH_NUM)) {
            $chapitre[] = array(
                'num_chapitre' => $row_liste_chapitre[0],
                'cn_id_chapitre' => $row_liste_chapitre[1]
			);
		}
        return $chapitre;
    }	
	
 	//Vérification s'il existe au moins un fichier de cours
     static public function verifFichier(){
        $dbh = self::getConnexion();
        $verif = $dbh->prepare("SELECT COUNT(*) FROM T_FICHIER");
        $verif->execute();
        $row_verif = $verif->fetch(PDO::FETCH_NUM);
        $existe = $row_verif[0];
        return $existe != 0;
    }
 
	//Récupération de la liste des fichiers, avec CN_ID_FICHIER et URL
    static public function listeFichier($chapitre) {
        $fichier = array();
		$dbh = self::getConnexion();
        $liste_fichier = $dbh->prepare("SELECT NUM_FICHIER, CN_ID_FICHIER, URL FROM T_FICHIER WHERE NUM_CHAPITRE_COURS = '$chapitre' AND ACTIF = '1'");
        $liste_fichier->execute();
		while ($row_liste_fichier = $liste_fichier->fetch(PDO::FETCH_NUM)) {
            $fichier[] = array(
                'num_fichier' => $row_liste_fichier[0],			
                'cn_id_fichier' => $row_liste_fichier[1],
                'url' => $row_liste_fichier[2]
			);
		}
        return $fichier;
    }	

	//Récupération du nombre de cours par matière
    static public function nombreCours($matiere) {
        $fichier = array();
        $dbh = self::getConnexion();
        $nombre_cours = $dbh->prepare("SELECT COUNT(*) FROM T_COURS WHERE NUM_MATIERE = $matiere");
        $nombre_cours->execute();
        $row_nombre_cours = $nombre_cours->fetch(PDO::FETCH_NUM);
        $resultat = $row_nombre_cours[0];
        return $resultat;
    }

	//Enregistrement d'une matière
    static public function enregistrementCreationMatiere($matiere,$identifiant) {
        $existe = 0;
        $liste_matieres = array();  
        $test_matieres = strtoupper($matiere);
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $liste_nom_matiere = $dbh->prepare("SELECT CN_ID_MATIERE FROM T_MATIERE WHERE ACTIF = '1'");
        $liste_nom_matiere->execute();
		while ($row_liste_nom_matiere = $liste_nom_matiere->fetch(PDO::FETCH_NUM)) {
            $liste_matieres[] = array(
                'cn_id_matiere' => $row_liste_nom_matiere[0]
            );
        }
        foreach($liste_matieres as $row) {
            $row['cn_id_matiere'] = strtoupper($row['cn_id_matiere']);
            if ($row['cn_id_matiere'] == $test_matieres){
                $existe = 1;
                break;
            } else {
                $existe = 0;
            }
        }
        if ($existe == 0){
                $creer = $dbh->prepare("INSERT INTO `T_MATIERE` (`NUM_MATIERE`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_MATIERE`) 
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$matiere')");
                $creer->execute();
                return 0;
        } else {
            return 1;
        }     
    } 
    
    //Enregistrement d'un cours
    static public function enregistrementCreationCours($matiere,$cours,$identifiant) {
        $existe = 0;
        $liste_cours = array();  
        $test_cours = strtoupper($cours);
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $liste_nom_cours = $dbh->prepare("SELECT CN_ID_COURS FROM T_COURS WHERE NUM_MATIERE = $matiere AND ACTIF = '1'");
        $liste_nom_cours->execute();
        while ($row_liste_nom_cours = $liste_nom_cours->fetch(PDO::FETCH_NUM)) {
            $liste_cours[] = array(
                'cn_id_cours' => $row_liste_nom_cours[0]
            );
        }
        foreach($liste_cours as $row) {
            $row['cn_id_cours'] = strtoupper($row['cn_id_cours']);
            if ($row['cn_id_cours'] == $test_cours){
                $existe = 1;
                break;
            } else {
                $existe = 0;
            }
        }

        if ($existe == 0){
                $creer = $dbh->prepare("INSERT INTO `T_COURS` (`NUM_COURS`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_COURS`, `NUM_MATIERE`) 
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$cours', '$matiere')");
                $creer->execute();
                return 0;
        } else {
            return 1;
        }     
    } 

    //Enregistrement d'un chapitre
    static public function enregistrementCreationChapitreCours($cours,$chapitre,$url,$identifiant) {
        $existe = 0;
        $liste_chapitre = array();  
        $test_chapitre = strtoupper($cours);
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];   
        $liste_nom_chapitre_cours = $dbh->prepare("SELECT CN_ID_CHAPITRE FROM T_CHAPITRE_COURS WHERE NUM_COURS = $cours AND ACTIF = '1'");
        $liste_nom_chapitre_cours->execute();
		while ($row_liste_nom_chapitre_cours = $liste_nom_chapitre_cours->fetch(PDO::FETCH_NUM)) {
            $liste_chapitre[] = array(
                'cn_id_chapitre' => $row_liste_nom_chapitre_cours[0]
            );
        }
        foreach($liste_chapitre as $row) {
            $row['cn_id_chapitre'] = strtoupper($row['cn_id_chapitre']);
            if ($row['cn_id_chapitre'] == $test_chapitre){
                $existe = 1;
                break;
            } else {
                $existe = 0;
            }
        }
        if ($existe == 0){
                $creer_chapitre = $dbh->prepare("INSERT INTO `T_CHAPITRE_COURS` (`NUM_CHAPITRE_COURS`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_CHAPITRE_COURS`, `NUM_COURS`) 
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$chapitre', '$cours')");
                $creer_chapitre->execute();
                $recup_num_chapitre = $dbh->prepare("SELECT NUM_CHAPITRE_COURS FROM T_CHAPITRE_COURS WHERE ACTIF = '1' ORDER BY NUM_CHAPITRE_COURS DESC LIMIT 1");  
                $recup_num_chapitre->execute(); 
                $row_num_chapitre = $recup_num_chapitre->fetch(PDO::FETCH_NUM);
                $num_chapitre = $row_num_chapitre[0];                                     
                $creer_fichier = $dbh->prepare("INSERT INTO `T_FICHIER` (`NUM_FICHIER`, `ACTIF`, `DATE_CREATION`, `USER_CREATION`, `USER_MAJ`, `DATE_MAJ`, `CN_ID_FICHIER`, `NUM_TYPE_FICHIER`, `URL`, `NUM_CHAPITRE_COURS`) 
                VALUES (NULL, '1', NOW(), '$nom', '$nom', NOW(), '$chapitre', '1', '$url' , $num_chapitre)");
                $creer_fichier->execute();
                return 0;
        } else {
            return 1;
        }     
    } 
    
	//Modification d'une matière
    static public function enregistrementModificationMatiere($id_matiere,$nom_matiere,$etat,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];     
        $maj = $dbh->prepare("UPDATE `T_MATIERE` SET `ACTIF` = '$etat', `USER_MAJ` = '$nom', `DATE_MAJ` = now(), `CN_ID_MATIERE` = '$nom_matiere' WHERE NUM_MATIERE = '$id_matiere'");
        $maj->execute();    
    } 

	//Récupération de l'état d'une Matière
    static public function etatMatiere($matiere){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT ACTIF FROM T_MATIERE WHERE NUM_MATIERE = '$matiere'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $etat = $row_recup[0];
        return $etat;
    }


	//Récupération de la liste des Matières (actives ET inactives), avec CN_ID_MATIERE et NUM_MATIERE
    static public function listeAllMatieres() {
        $matieres = array();
		$dbh = self::getConnexion();
        $liste_matiere = $dbh->prepare("SELECT NUM_MATIERE, CN_ID_MATIERE FROM T_MATIERE");
        $liste_matiere->execute();
		while ($row_liste_matiere = $liste_matiere->fetch(PDO::FETCH_NUM)) {
            $matieres[] = array(
                'num_matiere' => $row_liste_matiere[0],
                'cn_id_matiere' => $row_liste_matiere[1]
			);
		}
        return $matieres;
    } 

	//Récupération de la liste des Cours (Actifs et inactifs), avec CN_ID_COURS et NUM_COURS
    static public function listeAllCours($matiere) {
        $cours = array();
		$dbh = self::getConnexion();
        $liste_cours = $dbh->prepare("SELECT NUM_COURS, CN_ID_COURS FROM T_COURS WHERE NUM_MATIERE = '$matiere'");
        $liste_cours->execute();
		while ($row_liste_cours = $liste_cours->fetch(PDO::FETCH_NUM)) {
            $cours[] = array(
                'num_cours' => $row_liste_cours[0],
                'cn_id_cours' => $row_liste_cours[1]
			);
		}
        return $cours;
    }

	//Récupération de l'état du cours
    static public function etatCours($cours){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT ACTIF FROM T_COURS WHERE NUM_COURS = '$cours'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $etat = $row_recup[0];
        return $etat;
    }    

	//Modification d'un cours
    static public function enregistrementModificationCours($id_cours,$nom_cours,$etat,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);
        $nom = $row_nom[0];     
        $maj = $dbh->prepare("UPDATE `T_COURS` SET `ACTIF` = '$etat', `USER_MAJ` = '$nom', `DATE_MAJ` = now(), `CN_ID_COURS` = '$nom_cours' WHERE NUM_COURS = '$id_cours'");
        $maj->execute();    
    } 

	//Récupération de la liste des Chapitres de cours, avec CN_ID_CHAPITRE_COURS et NUM_CHAPITRE_COURS
    static public function listeAllChapitres($cours) {
        $chapitre = array();
		$dbh = self::getConnexion();
        $liste_chapitre = $dbh->prepare("SELECT NUM_CHAPITRE_COURS, CN_ID_CHAPITRE_COURS FROM T_CHAPITRE_COURS WHERE NUM_COURS = '$cours'");
        $liste_chapitre->execute();
		while ($row_liste_chapitre = $liste_chapitre->fetch(PDO::FETCH_NUM)) {
            $chapitre[] = array(
                'num_chapitre' => $row_liste_chapitre[0],
                'cn_id_chapitre' => $row_liste_chapitre[1]
			);
		}
        return $chapitre;
    }	

	//Récupération de l'état du chapitre
    static public function etatChapitre($chapitre){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT ACTIF FROM T_CHAPITRE_COURS WHERE NUM_CHAPITRE_COURS = '$chapitre'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $etat = $row_recup[0];
        return $etat;
    }    

	//Récupération du titre du chapitre
    static public function titreChapitre($chapitre){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT CN_ID_CHAPITRE_COURS FROM T_CHAPITRE_COURS WHERE NUM_CHAPITRE_COURS = '$chapitre'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $titre = $row_recup[0];
        return $titre;
    }  

	//Récupération de l'URL d'une vidéo
    static public function urlVideo($chapitre){
        $dbh = self::getConnexion();
        $recup = $dbh->prepare("SELECT URL FROM T_FICHIER WHERE NUM_CHAPITRE_COURS = '$chapitre'");
        $recup->execute();
        $row_recup = $recup->fetch(PDO::FETCH_NUM);
        $url = $row_recup[0];
        return $url;
    }      

	//Modification d'un chapitre
    static public function enregistrementModificationChapitre($id_chapitre,$nom_chapitre,$url,$etat,$identifiant) {
        $dbh = self::getConnexion();
        $recup_num_user = $dbh->prepare("SELECT NUM_USER FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_num_user->execute();
        $row_num_user = $recup_num_user->fetch(PDO::FETCH_NUM);
        $num_user = $row_num_user[0];     
        $recup_nom = $dbh->prepare("SELECT PRENOM FROM T_USER WHERE CN_ID_USER = '$identifiant' AND ACTIF = '1'");
        $recup_nom->execute();
        $row_nom = $recup_nom->fetch(PDO::FETCH_NUM);        
        $nom = $row_nom[0];                     
        $maj = $dbh->prepare("UPDATE `T_CHAPITRE_COURS` SET `ACTIF` = '$etat', `USER_MAJ` = '$nom', `DATE_MAJ` = now(), `CN_ID_CHAPITRE_COURS` = '$nom_chapitre' WHERE NUM_CHAPITRE_COURS = '$id_chapitre'");
        $maj->execute();    
        $maj = $dbh->prepare("UPDATE `T_FICHIER` SET `ACTIF` = '$etat', `USER_MAJ` = '$nom', `DATE_MAJ` = now(), `CN_ID_FICHIER` = '$nom_chapitre', `URL` = '$url' WHERE NUM_CHAPITRE_COURS = '$id_chapitre'");
        $maj->execute();          
    } 

}
    
