<?php

class Administration extends Modele {
    
    static public function listeEvenements() {
        $liste_evenements = array();        
        $dbh = self::getConnexion();
        $recup_liste_evenements = $dbh->prepare("SELECT TYPE_EVENEMENT, UTILISATEUR FROM T_EVENEMENTS ORDER BY NUM_EVENEMENT DESC LIMIT 10");
        $recup_liste_evenements->execute();
		while ($row_liste_evenements = $recup_liste_evenements->fetch(PDO::FETCH_NUM)) {
            $liste_evenements[] = array(
                'evenement' => $row_liste_evenements[0],
                'user' => $row_liste_evenements[1]                
            );
        }
        return $liste_evenements;  
    }

}
    

