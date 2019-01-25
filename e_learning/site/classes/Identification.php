<?php

class Identification extends Modele {

    /**
     * 
     * @param type $identifiant
     * @return boolean retourne true lorsque l'identifiant fourni correspond à un compte existant
     */
    
    static public function testIdentification($identifiant) {
        $dbh = self::getConnexion();
        $test_id = $dbh->prepare("SELECT COUNT(*) FROM T_USER WHERE CN_ID_USER = '$identifiant'");
        $test_id->execute();
		$row_id = $test_id->fetch(PDO::FETCH_NUM);
		$existe_id = $row_id[0];
        return $existe_id == 1;
    }
    
    /**
     * 
     * @param type $identifiant
     * @return boolean retourne true lorsque l'identifiant fourni correspond à un compte étudiant
     */
    
    static public function testIdentificationEtudiant($identifiant) {
        $dbh = self::getConnexion();
        $test_id_etudiant = $dbh->prepare("SELECT COUNT(*) FROM T_USER WHERE CN_ID_USER = '$identifiant' AND NUM_GROUPE ='3'");
        $test_id_etudiant->execute();
		$row_id_etudiant = $test_id_etudiant->fetch(PDO::FETCH_NUM);
		$existe_id_etudiant = $row_id_etudiant[0];
        return $existe_id_etudiant == 1;
    }
    
    /**
     * 
     * @param type $identifiant
     * @return boolean retourne true lorsque l'identifiant fourni correspond à un compte professeur
     */
    
    static public function testIdentificationProfesseur($identifiant) {
        $dbh = self::getConnexion();
        $test_id_professeur = $dbh->prepare("SELECT COUNT(*) FROM T_USER WHERE CN_ID_USER = '$identifiant' AND NUM_GROUPE ='2'");
        $test_id_professeur->execute();
		$row_id_professeur = $test_id_professeur->fetch(PDO::FETCH_NUM);
		$existe_id_professeur = $row_id_professeur[0];
        return $existe_id_professeur == 1;
    }

    /**
     * 
     * @param type $identifiant
     * @return boolean retourne true lorsque l'identifiant fourni correspond à un compte administrateur
     */
    
    static public function testIdentificationAdministrateur($identifiant) {
        $dbh = self::getConnexion();
        $test_id_administrateur = $dbh->prepare("SELECT COUNT(*) FROM T_USER WHERE CN_ID_USER = '$identifiant' AND NUM_GROUPE ='1'");
        $test_id_administrateur->execute();
		$row_id_administrateur = $test_id_administrateur->fetch(PDO::FETCH_NUM);
		$existe_id_administrateur = $row_id_administrateur[0];
        return $existe_id_administrateur == 1;
    }    

    /**
     * 
     * @param string $identifiant
     * @param string $password
     * @return boolean Retourne true lorsque les informations fournies correspondent effectivement à un compte
     */
    
    static public function testConnexion($identifiant,$password) {
        $dbh = self::getConnexion();
        $test_conn = $dbh->prepare("SELECT COUNT(*) FROM T_USER WHERE CN_ID_USER = '$identifiant' AND MOT_DE_PASSE = '$password' AND ACTIF = '1'");
        $test_conn->execute();
		$row_conn = $test_conn->fetch(PDO::FETCH_NUM);
		$existe_conn = $row_conn[0];
        return $existe_conn == 1;
    }
    
    /**
     * 
     * @param string $identifiant
     * @return array Retourne un tableau avec les informations du compte utilisateur
     */

    static public function informations($identifiant) {
        $info = array();        
        $dbh = self::getConnexion();
        $recup_civilite = $dbh->prepare("SELECT CN_ID_CIVILITE FROM T_CIVILITE INNER JOIN T_USER ON T_CIVILITE.NUM_CIVILITE = T_USER.NUM_CIVILITE WHERE CN_ID_USER='$identifiant' AND T_USER.ACTIF = '1'");
        $recup_civilite->execute();
		$row_civilite = $recup_civilite->fetch(PDO::FETCH_NUM);
        $civilite = $row_civilite[0];       
        $recup_groupe = $dbh->prepare("SELECT CN_ID_NOM_GROUPE FROM T_GROUPE INNER JOIN T_USER ON T_GROUPE.NUM_GROUPE = T_USER.NUM_GROUPE WHERE CN_ID_USER='$identifiant' AND T_USER.ACTIF = '1'");
        $recup_groupe->execute();
		$row_groupe = $recup_groupe->fetch(PDO::FETCH_NUM);
        $groupe = $row_groupe[0];                  
        $recup_specialite = $dbh->prepare("SELECT CN_ID_SPECIALITE FROM T_SPECIALITE INNER JOIN T_USER ON T_SPECIALITE.NUM_SPECIALITE = T_USER.NUM_SPECIALITE WHERE CN_ID_USER='$identifiant' AND T_USER.ACTIF = '1'");
        $recup_specialite->execute();
		$row_specialite = $recup_specialite->fetch(PDO::FETCH_NUM);
        $specialite = $row_specialite[0];       
        $recup_info = $dbh->prepare("SELECT NOM, PRENOM, MOT_DE_PASSE FROM T_USER WHERE CN_ID_USER='$identifiant' AND ACTIF = '1'");
        $recup_info->execute();
		while ($row_info = $recup_info->fetch(PDO::FETCH_NUM)) {
            $info[] = array(
                'nom_user' => $row_info[0],
                'prenom_user' => $row_info[1],
                'mdp_user' => $row_info[2]                
            );
        }
        $info[0]['civilite'] = $civilite;
        $info[0]['groupe'] = $groupe;  
        $info[0]['specialite'] = $specialite;     
        return $info;             
    }     

}
    

