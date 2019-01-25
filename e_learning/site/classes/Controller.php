<?php

class Controller {
    
    private $values = array();
    
    public function addVal($var_name, $value) {
        $this->values[$var_name] = $value;
    }

	//Page de connexion
    public function login($avec_erreur = false, $un_msg = NULL) {
        $vue = new Vue('connexion', $this->values);
        $vue->setVar('avec_erreur', $avec_erreur);
        $vue->setVar('message', $un_msg);
        $vue->generer();
    }

 	//Test de connexion 
    public function testConnexion($identifiant,$password) {
        if (!Identification::testIdentification($identifiant)) {
            $un_msg = "Votre identifiant n'a pas été reconnu. Veuillez recommencer.";
        } elseif ((!Identification::testIdentificationEtudiant($identifiant)) AND (!Identification::testIdentificationProfesseur($identifiant)) AND (!Identification::testIdentificationAdministrateur($identifiant))){
            $un_msg = "Vous n'êtes pas autorisé(e) à accéder à ce service.";
        } elseif (!Identification::testConnexion($identifiant, $password)) {
            $un_msg = "Votre mot de passe est erroné. Veuillez recommencer.";
        } elseif (Identification::testIdentificationEtudiant($identifiant)){
            $this->initialiserSessionEtudiant($identifiant);
            $this->accueil();
            return;
        } elseif (Identification::testIdentificationProfesseur($identifiant)){
            $this->initialiserSessionProfesseur($identifiant);
            $this->accueil();
            return;
        } else {
            $this->initialiserSessionAdmnistrateur($identifiant);
            $this->accueil();
            return;
        }
        $this->login(true, $un_msg);
    }

	//Initialisation de la session Etudiante
    public function initialiserSessionEtudiant($identifiant) {
        $_SESSION['id'] = $identifiant;
        $_SESSION['type'] = '0';
    }

	//Initialisation de la session Professeur
    public function initialiserSessionProfesseur($identifiant) {
        $_SESSION['id'] = $identifiant;
        $_SESSION['type'] = '1';
    }

	//Initialisation de la session Administrateur
    public function initialiserSessionAdmnistrateur($identifiant) {
        $_SESSION['id'] = $identifiant;
        $_SESSION['type'] = '2';
    }

 	//Création de la page d'accueil
    public function accueil() {
        $creation_contenu = '';
        $modification_contenu = '';
        $liste_evenements = '';
        $msg_accueil = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        
        if ($_SESSION['type'] == '2'){
            $msg_accueil = '<table width="600" style="border:1px black solid"><tr><td style="border:1px black solid" align="center"><b>DERNIERS ÉVÈNEMENTS</b></td><td style="border:1px black solid" align="center"><b>UTILISATEUR</b></td></tr>';            
            $liste_evenements = Administration::listeEvenements();
            foreach ($liste_evenements as $row){
                $msg_accueil .= "<tr><td style='border:1px black solid' align='center'>". $row['evenement'] ."</td><td style='border:1px black solid' align='center'>". $row['user'] ."</td></tr>";
            }
            $msg_accueil .= "</table>";              
        }  
        $vue = new Vue('accueil', $this->values);
        $vue->setVar('titre_page', 'Accueil');   
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);         
        $vue->setVar('liste_evenements', $msg_accueil);              
        $vue->generer();
    }

 	//Déconnexion 
    public function logout() {
        unset($_SESSION['id']);
        unset($_SESSION['type']);
        $this->login();
    }

 	//Création de la page de mentions légales
    public function mention() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $vue = new Vue('mentions', $this->values);
        $vue->setVar('titre_page', 'Mentions légales');  
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);                  
        $vue->generer();
    }	

 	//Création de la page de politique de confidentialité
    public function confidentialite() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $vue = new Vue('confidentialite', $this->values);
        $vue->setVar('titre_page', 'Politique de confidentialité');  
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);                  
        $vue->generer();
    }

 	//Création de la page de contact
    public function contact() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $vue = new Vue('contact', $this->values);
        $vue->setVar('titre_page', 'Nous contacter');  
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                   
        $vue->generer();
    }	

 	//Création de la page des profil
     public function profil() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $notes = '';
        if ($_SESSION['type'] == '0') {
            $notes = '<a href="index.php?task=notes">Notes</a>';
        }
        $profil = Identification::informations($_SESSION['id']);
        $civilite = $profil[0]['civilite'];
        $nom = $profil[0]['nom_user'];
        $prenom = $profil[0]['prenom_user'];
        $motdepasse = $profil[0]['mdp_user'];
        $groupe = $profil[0]['groupe'];
        $specialite = $profil[0]['specialite'];
        $vue = new Vue('profil', $this->values); 
        $vue->setVar('titre_page', 'Profil');                 
        $vue->setVar('civilite', $civilite);
        $vue->setVar('nom', $nom);   
        $vue->setVar('prenom', $prenom);   
        $vue->setVar('motdepasse', $motdepasse);   
        $vue->setVar('groupe', $groupe);   
        $vue->setVar('specialite', $specialite);  
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);  
        $vue->setVar('notes', $notes);                                                         
        $vue->generer();	
    }	

 	//Génération des erreurs
    public function erreur($msg) {
        $vue = new Vue('erreur', $this->values);
        $vue->setVar('msg_erreur', $msg);
        $vue->setVar('titre_page', 'Erreur');          
        $vue->generer();
    }   

 	//Création de la page des matières
    public function matiere() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_matiere = '';
        if (Enseignement::verifMatieres()){
            $msg_matiere ="<table><tbody><tr>";
            $matieres = Enseignement::listeMatieres();
            $i=0;
            foreach ($matieres as $row) {
                if ($i == 3 or $i == 6 or $i == 9 or $i == 12){
                    $msg_matiere .= "</tr><tr>";}
				$msg_matiere .= "<td align='center'><a href='index.php?task=cours&matiere=" . $row['num_matiere'] . "'><div class='swiggleBox'>". $row['cn_id_matiere']."<svg width='130' height='65' viewBox='0 0 130 65' xmlns='http://www.w3.org/2000/svg'>
                <path d='M0.6,0.5c0,5.4,0,61.5,0,61.5s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0
                s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0
                c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c0,0,0-56.1,0-61.5H0.6z'/>
              </svg></div></a></td>";
              $i++;
            }	
            $msg_matiere .=	"</tr></tbody></table><br><a href='index.php?task=liste_examen' class='btn-liquid'><span class='inner'>Examens</span></a>";	
        }        
        $vue = new Vue('matiere', $this->values);
        $vue->setVar('titre_page', 'Matières');          
        $vue->setVar('liste_matiere', $msg_matiere);   
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);        
        $vue->generer();
    }

 	//Création de la page des cours
    public function cours($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_cours = '';
        if (Enseignement::verifCours($matiere) != 0){
            $msg_cours ="<table><tbody><tr>";
            $cours = Enseignement::listeCours($matiere);
            $i=0;
            foreach ($cours as $row) {
                if ($i == 3 or $i == 6 or $i == 9 or $i == 12){
                        $msg_cours .= "</tr><tr>";}
                    $msg_cours .= "<td align='center'><a href='index.php?task=chapitre&cours=" . $row['num_cours'] . "'><div class='swiggleBox'>". $row['cn_id_cours']."<svg width='130' height='65' viewBox='0 0 130 65' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M0.6,0.5c0,5.4,0,61.5,0,61.5s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0
                    s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0
                    c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c0,0,0-56.1,0-61.5H0.6z'/>
                  </svg></div></a></td>";
                  $i++;
			}		
		    $msg_cours .= "</tr></tbody></table><br><a href='index.php?task=liste_controle&matiere=".$matiere."' class='btn-liquid'><span class='inner'>Contrôles</span></a>";
        }
        $titre_matiere = Enseignement::titreMatiere($matiere);
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a>";
        $vue = new Vue('cours', $this->values);
        $vue->setVar('titre_page', $titre_matiere);          
        $vue->setVar('liste_cours', $msg_cours);
        $vue->setVar('fil_ariane', $fil_ariane);  
        $vue->setVar('creation_contenu', $creation_contenu);
        $vue->setVar('modification_contenu', $modification_contenu);                  
        $vue->generer();
    }

 	//Création de la page des chapitres
    public function chapitre($cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_chapitre = '';
        if (Enseignement::verifChapitres($cours) != 0){
            $msg_chapitre ="<table><tbody><tr>";
            $chapitre = Enseignement::listeChapitres($cours);
            $i=0;
            foreach ($chapitre as $row) {
                if ($i == 3 or $i == 6 or $i == 9 or $i == 12){
                    $msg_chapitre .= "</tr><tr>";}
                $msg_chapitre .= "<td align='center'><a href='index.php?task=fichier&chapitre=" . $row['num_chapitre'] . "'><div class='swiggleBox'>" . $row['cn_id_chapitre'] . "<svg width='130' height='65' viewBox='0 0 130 65' xmlns='http://www.w3.org/2000/svg'>
                <path d='M0.6,0.5c0,5.4,0,61.5,0,61.5s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0
                s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0
                c5.4-5.4,9.9,0,9.9,0s4.5,5.4,9.9,0c0,0,0-56.1,0-61.5H0.6z'/>
              </svg></div></a></td>";
                $i++;
			}		
		    $msg_chapitre .="</tr></tbody></table><br><a href='index.php?task=liste_exercice&cours=".$cours."' class='btn-liquid'><span class='inner'>Exercices</span></a>";
        }
        $titre_cours = Enseignement::titreCours($cours); 
        $ariane_cours =  Enseignement::arianeCours($cours); 
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_cours[0]['num_matiere']."'>".$ariane_cours[0]['cn_id_matiere']."</a>";              
        $vue = new Vue('chapitre', $this->values);
        $vue->setVar('titre_page', $titre_cours);         
        $vue->setVar('liste_chapitre', $msg_chapitre);
        $vue->setVar('fil_ariane', $fil_ariane); 
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);                 
        $vue->generer();
    }

 	//Création de la page des fichiers
    public function fichier($chapitre) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
		$msg_fichier ="";
        if (Enseignement::verifFichier()){
            $fichier = Enseignement::listeFichier($chapitre);
            $msg_fichier .= "<h1>".  $fichier[0]['cn_id_fichier']  ."</h1><iframe  width='425' height='344' src='" . $fichier[0]['url'] . "' frameborder='0' allowfullscreen></iframe><div id='qcm'><a href='index.php?task=qcm&fichier=" . $fichier[0]['num_fichier'] ."'>QCM</a></div>";
            $titre_fichier = $fichier[0]['cn_id_fichier'];	
        }
        $ariane_chapitre =  Enseignement::arianeChapitre($chapitre);     
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_chapitre[0]['num_matiere']."'>".$ariane_chapitre[0]['cn_id_matiere']."</a> > <a href='index.php?task=chapitre&cours=" . $ariane_chapitre[0]['num_cours'] . "'>" . $ariane_chapitre[0]['cn_id_cours'] . "</a>";                      
        $vue = new Vue('fichier', $this->values);
        $vue->setVar('titre_page', $titre_fichier);         
        $vue->setVar('liste_fichier', $msg_fichier); 
        $vue->setVar('fil_ariane', $fil_ariane);    
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                    
        $vue->generer();
    }

 	//Création de la page des QCM
    public function qcm($fichier, $erreur = NULL) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_qcm ="";
        $i = 1;
        if (Examens::verifQcm()){
            $qcm = Examens::listeQcm($fichier);
            foreach ($qcm as $row) {
                $msg_qcm .= "<h2>Question n°" . $i . ": " . $row['cn_id_qcm'] . "</h2>";
                $rep_qcm = Examens::listeRepQcm($row['num_id']);
                foreach ($rep_qcm as $row_rep) {
                    $msg_qcm .= "<input type='radio' id='". $row_rep['num_reponse_qcm'] . "' value='". $row_rep['etat'] ."' name='question_". $i ."'><label for='" . $row_rep['num_reponse_qcm'] ."'>". $row_rep['cn_id_reponse_qcm'] ."</label><br>";
                }
                $i++;
			}
        }       
        $vue = new Vue('qcm', $this->values);
        $vue->setVar('titre_page', 'QCM');         
        $vue->setVar('liste_qcm', $msg_qcm);
        $vue->setVar('fichier', $fichier);
        $vue->setVar('erreur', $erreur);  
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                 
        $vue->generer();
    }

 	//Vérification des réponses du QCM
    public function verification_qcm($question_1,$question_2,$question_3,$question_4,$question_5,$fichier) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $verif = array($question_1,$question_2,$question_3,$question_4,$question_5);
        $msg = "";
        $compte = 0;
        for ($i=0; $i<=4;$i++) {
            if ($verif[$i] != 1)
            $compte++;            
            $msg = "Il reste " . $compte . " erreurs!";
            $note = (5 - $compte);
        }
        Examens::noteRepQcm($note,$fichier,$_SESSION['id']);
        if ($note != 5) {
            $this->qcm($fichier, $msg);
        } else {
            Examens::validationQcm($fichier,$_SESSION['id']);
            $vue = new Vue('validation_qcm', $this->values);
            $vue->setVar('titre_page', 'QCM');  
            $vue->setVar('creation_contenu', $creation_contenu);   
            $vue->setVar('modification_contenu', $modification_contenu);                 
            $vue->generer();
        }
    }       

 	//Création de la page de liste des Exercices
     public function liste_exercices($cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_liste_exercice ="<table><tbody>";
        $i = 1;
        if (Examens::verifExercice()){
            $liste_exercice = Examens::listeExercices($cours);
            foreach ($liste_exercice as $row){
                $msg_liste_exercice .= "<tr><td><a href='index.php?task=exercice&exercice=".$row['num_exercice']."'>Exercice n°".$i."</a></td></tr>";
                $i++;
            }
        }   
        $ariane_liste_exercice =  Examens::arianeListeExercice($cours); 
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_liste_exercice[0]['num_matiere']."'>".$ariane_liste_exercice[0]['cn_id_matiere']."</a> > <a href='index.php?task=chapitre&cours=" . $ariane_liste_exercice[0]['num_cours'] . "'>" . $ariane_liste_exercice[0]['cn_id_cours'] . "</a>";        
        $msg_liste_exercice .="</tbody></table>";
        $vue = new Vue('liste_exercice', $this->values);
        $vue->setVar('titre_page', 'Exercices');         
        $vue->setVar('liste_exercice', $msg_liste_exercice); 
        $vue->setVar('fil_ariane', $fil_ariane);   
        $vue->setVar('creation_contenu', $creation_contenu);    
        $vue->setVar('modification_contenu', $modification_contenu);                   
        $vue->generer();
    }

 	//Création de la page des Exercices
     public function exercice($exercice) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_exercice ="";
        $question_exercice = Examens::questionExercice($exercice);
        $msg_exercice .="<b>Question : ".$question_exercice."</b><br>";
        $msg_exercice .="<b>Réponse : </b><input type='text' name='reponse_exercice'><br>";  
        $ariane_exercice =  Examens::arianeExercice($exercice); 
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_exercice[0]['num_matiere']."'>".$ariane_exercice[0]['cn_id_matiere']."</a> > <a href='index.php?task=chapitre&cours=" . $ariane_exercice[0]['num_cours'] . "'>" . $ariane_exercice[0]['cn_id_cours'] . "</a>"; 
        $num_cours = Examens::numCours($exercice);         
        $retour_exercice ="<br><a href='index.php?task=liste_exercice&cours=".$num_cours."'>Retour à la liste des exercices</a>";
        $vue = new Vue('exercice', $this->values);
        $vue->setVar('titre_page', 'Exercices');         
        $vue->setVar('question_exercice', $msg_exercice); 
        $vue->setVar('num_exercice', $exercice); 
        $vue->setVar('fil_ariane', $fil_ariane); 
        $vue->setVar('retour_question', $retour_exercice); 
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);                                      
        $vue->generer();
    }    

 	//Page de confirmation d'enregistrement des réponses des Exercices
     public function enregistrement_reponse_exerice($exercice,$reponse) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_enregistrement_reponse_exercice ="";
        $enregistrement_reponse_exercice = Examens::enregistrementReponseExercice($exercice,$reponse,$_SESSION['id']);
         if ($enregistrement_reponse_exercice == 0) {
            $msg_enregistrement_reponse_exercice ="Votre réponse a bien été enregistrée!<br><br>";
        } else {
            $msg_enregistrement_reponse_exercice ="Vous avez déjà répondu à cet exercice!<br><br>";
        }
        $num_cours = Examens::numCours($exercice);         
        $retour_exercice ="<br><a href='index.php?task=liste_exercice&cours=".$num_cours."'>Retour à la liste des exercices</a>";
        $ariane_exercice =  Examens::arianeExercice($exercice); 
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_exercice[0]['num_matiere']."'>".$ariane_exercice[0]['cn_id_matiere']."</a> > <a href='index.php?task=chapitre&cours=" . $ariane_exercice[0]['num_cours'] . "'>" . $ariane_exercice[0]['cn_id_cours'] . "</a>";            
        $vue = new Vue('enregistrement_reponse_exercice', $this->values);
        $vue->setVar('titre_page', 'Exercices');         
        $vue->setVar('reponse_exercice', $msg_enregistrement_reponse_exercice);  
        $vue->setVar('fil_ariane', $fil_ariane);   
        $vue->setVar('retour_question', $retour_exercice);
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                                   
        $vue->generer();
    }      

 	//Création de la page de liste des Controles
     public function liste_controles($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_liste_controle ="<table><tbody>";
        $i = 1;
        if (Examens::verifControle()){
            $liste_controle = Examens::listeControles($matiere);
            foreach ($liste_controle as $row){
                $msg_liste_controle .= "<tr><td><a href='index.php?task=controle&controle=".$row['num_controle']."'>Controle n°".$i."</a></td></tr>";
                $i++;
            }
        }   
        $msg_liste_controle .="</tbody></table>";
        $ariane_controle =  Examens::arianeListeControle($matiere); 
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_controle[0]['num_matiere']."'>".$ariane_controle[0]['cn_id_matiere']."</a>";              
        $vue = new Vue('liste_controle', $this->values);
        $vue->setVar('titre_page', 'Contrôles');         
        $vue->setVar('liste_controle', $msg_liste_controle); 
        $vue->setVar('fil_ariane', $fil_ariane);   
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                      
        $vue->generer();
    }    

 	//Création de la liste des question du Controle
     public function questioncontrole($controle) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }      
        $msg_liste_question_controle ="<table><tbody>";
        $i = 1;
        if (Examens::verifQuestionControle()){
            $liste_question_controle = Examens::listeQuestionControle($controle);
            foreach ($liste_question_controle as $row){
                $msg_liste_question_controle .= "<tr><td><a href='index.php?task=question_controle&question=".$row['num_question_controle']."'>Question n°".$i."</a></td></tr>";
                $i++;
            }
        }
        $num_matiere = Examens::numMatiere($controle); 
        $ariane_controle =  Examens::arianeControle($controle); 
        $msg_liste_question_controle .="</tbody></table><br><a href='index.php?task=liste_controle&matiere=".$num_matiere."'>Retour à la liste des controles</a>";        
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_controle[0]['num_matiere']."'>".$ariane_controle[0]['cn_id_matiere']."</a>";
        $vue = new Vue('liste_question_controle', $this->values);
        $vue->setVar('titre_page', 'Contrôles');        
        $vue->setVar('liste_question_controle', $msg_liste_question_controle);  
        $vue->setVar('fil_ariane', $fil_ariane);
        $vue->setVar('creation_contenu', $creation_contenu);
        $vue->setVar('modification_contenu', $modification_contenu);                        
        $vue->generer();
    }    

 	//Création de la page du Controle
     public function controle($question) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }      
        $msg_question_controle ="";
        $question_controle = Examens::questionControle($question);
        $msg_question_controle .="<b>Question : ".$question_controle."</b><br>";
        $msg_question_controle .="<b>Réponse : </b><input type='text' name='reponse_controle'><br>";               
        $num_controle = Examens::numControle($question); 
        $retour_controle ="<br><a href='index.php?task=controle&controle=".$num_controle."'>Retour à la liste des questions</a>";                               
        $ariane_question_controle =  Examens::arianeQuestionControle($question);
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_question_controle[0]['num_matiere']."'>".$ariane_question_controle[0]['cn_id_matiere']."</a>";      
        $vue = new Vue('controle', $this->values);
        $vue->setVar('titre_page', 'Contrôles');        
        $vue->setVar('question_controle', $msg_question_controle); 
        $vue->setVar('num_question_controle', $question);  
        $vue->setVar('fil_ariane', $fil_ariane); 
        $vue->setVar('retour_questions', $retour_controle); 
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                                      
        $vue->generer();
    }        

 	//Page de confirmation d'enregistrement des réponses des Controles
     public function enregistrement_reponse_controle($question_controle,$reponse_controle) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }       
        $msg_enregistrement_reponse_controle ="";
        $enregistrement_reponse_controle = Examens::enregistrementReponseControle($question_controle,$reponse_controle,$_SESSION['id']);
        if ($enregistrement_reponse_controle == 0) {
            $msg_enregistrement_reponse_controle ="Votre réponse a bien été enregistrée!<br><br>";
        } else {
            $msg_enregistrement_reponse_controle ="Vous avez déjà répondu à cette question!<br><br>";
        }
        $num_controle = Examens::numControle($question_controle); 
        $retour_controle ="<br><a href='index.php?task=controle&controle=".$num_controle."'>Retour à la liste des questions</a>";                               
        $ariane_question_controle =  Examens::arianeQuestionControle($question_controle);
        $fil_ariane = "<a href='index.php?task=matiere'>Matières</a> > <a href='index.php?task=cours&matiere=".$ariane_question_controle[0]['num_matiere']."'>".$ariane_question_controle[0]['cn_id_matiere']."</a>";                
        $vue = new Vue('enregistrement_reponse_controle', $this->values);
        $vue->setVar('titre_page', 'Contrôles');        
        $vue->setVar('reponse_controle', $msg_enregistrement_reponse_controle); 
        $vue->setVar('fil_ariane', $fil_ariane); 
        $vue->setVar('retour_questions', $retour_controle); 
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                                       
        $vue->generer();
    }

 	//Création de la page de liste des Examens
     public function liste_examens() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }       
        $msg_liste_examen ="<table><tbody>";
        if (Examens::verifExamen()){
            $liste_examen = Examens::listeExamens();
            foreach ($liste_examen as $row){
                $msg_liste_examen .= "<tr><td><a href='index.php?task=examen&examen=".$row['num_examen']."'>".$row['cn_id_examen']."</a></td></tr>";
            }
        }   
        $msg_liste_examen .="</tbody></table>";
        $vue = new Vue('liste_examen', $this->values);
        $vue->setVar('titre_page', 'Examens');        
        $vue->setVar('liste_examen', $msg_liste_examen); 
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                
        $vue->generer();
    } 

 	//Création de la liste des question de l'Examen
     public function questionexamen($examen) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }       
        $msg_liste_question_examen ="<table><tbody>";
        $i = 1;
        if (Examens::verifQuestionExamen()){
            $liste_question_examen = Examens::listeQuestionExamen($examen);
            foreach ($liste_question_examen as $row){
                $msg_liste_question_examen .= "<tr><td><a href='index.php?task=question_examen&question=".$row['num_question_examen']."'>Question n°".$i."</a></td></tr>";
                $i++;
            }
        }   
        $msg_liste_question_examen .="</tbody></table><br><a href='index.php?task=liste_examen'>Retour à la liste des Examens</a>";
        $vue = new Vue('liste_question_examen', $this->values);
        $vue->setVar('titre_page', 'Examens');          
        $vue->setVar('liste_question_examen', $msg_liste_question_examen); 
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);               
        $vue->generer();
    } 

 	//Création de la page de l'Examen
     public function examen($question) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }       
        $msg_question_examen ="";
        $question_examen = Examens::questionExamen($question);
        $num_examen = Examens::numExamen($question);        
        $msg_question_examen .="<b>Question : ".$question_examen."</b><br>";
        $msg_question_examen .="<b>Réponse : </b><input type='text' name='reponse_examen'><br>"; 
        $retour_examen ="<br><a href='index.php?task=examen&examen=".$num_examen."'>Retour à la liste des questions</a>";                               
        $vue = new Vue('examen', $this->values);
        $vue->setVar('titre_page', 'Examens');          
        $vue->setVar('question_examen', $msg_question_examen); 
        $vue->setVar('num_question_examen', $question);  
        $vue->setVar('retour_questions', $retour_examen);  
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                             
        $vue->generer();
    }        

 	//Page de confirmation d'enregistrement des réponses des Examens
     public function enregistrement_reponse_examen($question_examen,$reponse_examen) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }      
        $msg_enregistrement_reponse_examen ="";
        $enregistrement_reponse_examen = Examens::enregistrementReponseExamen($question_examen,$reponse_examen,$_SESSION['id']);
        $num_examen = Examens::numExamen($question_examen);
        if ($enregistrement_reponse_examen == 0) {
            $msg_enregistrement_reponse_examen ="Votre réponse a bien été enregistrée!";
        } else {
             $msg_enregistrement_reponse_examen ="Vous avez déjà répondu à cette question!";
        }
        $retour_examen ="<br><br><a href='index.php?task=examen&examen=".$num_examen."'>Retour à la liste des questions</a>";                               
        $vue = new Vue('enregistrement_reponse_examen', $this->values);
        $vue->setVar('titre_page', 'Examens');          
        $vue->setVar('reponse_examen', $msg_enregistrement_reponse_examen);
        $vue->setVar('retour_questions', $retour_examen);  
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                            
        $vue->generer();
    }    

 	//Page des notes
    public function liste_notes() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }     
        $msg_notes = '';
        $verif_exercices = Examens::exercicesVerification($_SESSION['id']);
        if ($verif_exercices == 1) {
            $msg_notes .= '<table width="600" style="border:1px black solid"><tr><td colspan="4" style="border:1px black solid" align="center"><h2>Exercices</h2></td></tr><tr><td style="border:1px black solid" align="center"><b>Matières</b></td><td style="border:1px black solid" align="center"><b>Cours</b></td><td style="border:1px black solid" align="center"><b>Exercices réalisés</b></td><td style="border:1px black solid" align="center"><b>Notes</b></td></tr>';
            if (Enseignement::verifMatieres()){
                $matieres = Enseignement::listeMatieres();
                foreach ($matieres as $row) {
                    $nb_cours = Enseignement::nombreCours($row['num_matiere']);
                    $msg_notes .= "<tr><td align='center' style='border:1px black solid' rowspan='".$nb_cours."'>". $row['cn_id_matiere'] ."</td>";
                    if (Enseignement::verifCours($matiere) != 0){
                        $cours = Enseignement::listeCours($row['num_matiere']);
                        foreach ($cours as $row) {
                            $msg_notes .= "<td align='center' style='border:1px black solid'>". $row['cn_id_cours'] . "</td>";
                            $exercices_realises = Examens::exericesRealises($row['num_cours'],$_SESSION['id']);
                            $nombre_exerices = Examens::nombreExercices($row['num_cours']);
                            $note_exercices = Examens::noteExercices($row['num_cours'],$_SESSION['id']);
                            $msg_notes .= "<td align='center' style='border:1px black solid'>". $exercices_realises . "/". $nombre_exerices."</td><td align='center' style='border:1px black solid'>". $note_exercices . "/". $exercices_realises."</td></tr>";
                        }		
                    }
                }	
            $msg_notes .= '</table>';    	
           }
           
        }
        $verif_controles = Examens::controlesVerification($_SESSION['id']);
        if ($verif_controles == 1) {
            $msg_notes .= '<table width="600" style="border:1px black solid"><tr><td colspan="3" style="border:1px black solid" align="center"><h2>Contrôles</h2></td></tr><tr><td style="border:1px black solid" align="center"><b>Matières</b></td><td style="border:1px black solid" align="center"><b>Contrôle</b></td><td style="border:1px black solid" align="center"><b>Notes</b></td></tr>';
            if (Enseignement::verifMatieres()){
                $matieres = Enseignement::listeMatieres();
                foreach ($matieres as $row) {
                    $nb_controle = Examens::nombreControles($row['num_matiere']);
                    $msg_notes .= "<tr><td align='center' style='border:1px black solid' rowspan='".$nb_controle."'>". $row['cn_id_matiere'] ."</td>";
                    $i = 1;
                    if (Examens::verifControle()){
                        $liste_controle = Examens::listeControles($row['num_matiere']);
                        foreach ($liste_controle as $row){
                            $note_controles = Examens::noteControles($row['num_controle'],$_SESSION['id']);
                            $msg_notes .= "<td style='border:1px black solid' align='center'>Controle n°".$i."</td><td style='border:1px black solid' align='center'>".$note_controles."/20</td></tr>";
                            $i++;
                        }
                    } 
                }
            $msg_notes .= '</table>';     	   	
           }
        }
        $verif_examens = Examens::examensVerification($_SESSION['id']);
        if ($verif_examens == 1) {
            $msg_notes .= '<table width="600" style="border:1px black solid"><tr><td colspan="2" style="border:1px black solid" align="center"><h2>Examens</h2></td></tr><tr><td style="border:1px black solid" align="center"><b>Examens</b></td><td style="border:1px black solid" align="center"><b>Notes</b></td></tr>';
                if (Examens::verifExamen()){
                    $liste_examen = Examens::listeExamens();
                    foreach ($liste_examen as $row){
                        $msg_notes .= "<tr><td style='border:1px black solid' align='center'>".$row['cn_id_examen']."</td>";
                        $note_examens = Examens::noteExamens($row['num_examen'],$_SESSION['id']);
                        $msg_notes .= "<td style='border:1px black solid' align='center'>".$note_examens."/100</td></tr>";
                    } 
                }   
            $msg_notes .= '</table>';         
        }	 
        $vue = new Vue('notes', $this->values);
        $vue->setVar('titre_page', 'Notes'); 
        $vue->setVar('notes', $msg_notes);
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu);                                
        $vue->generer();
    }    
        
  	//Création de la page de création de contenu
    public function creation_contenu() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }        
        $vue = new Vue('creation_contenu', $this->values);
        $vue->setVar('titre_page', 'Création de contenu');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);            
        $vue->generer();
    }   

  	//Création de la page de création de matières
    public function creation_matiere() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        $vue = new Vue('creation_matiere', $this->values);
        $vue->setVar('titre_page', 'Création de matiere');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);                    
        $vue->generer();
    }  

  	//Enregistrement d'une matière
    public function enregistrement_creation_matiere($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($matiere == '') {
            $msg_creation_matiere = "Veuillez entrer un nom de matiere !";
        } else {
            $enregistrement_creation_matiere = Enseignement::enregistrementCreationMatiere($matiere,$_SESSION['id']); 
            if ($enregistrement_creation_matiere == 0) {
                $msg_creation_matiere = "La matière a bien été enregistrée !";
            } else {
                $msg_creation_matiere = "Cette matière existe déjà !";
            }
        }
        $vue = new Vue('enregistrement_creation_matiere', $this->values);
        $vue->setVar('titre_page', 'Création de matière');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('creation_matiere', $msg_creation_matiere);
        $vue->setVar('modification_contenu', $modification_contenu);          
        $vue->generer();
    } 

    //Création de la page de création de cours
    public function creation_cours() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_cours = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            $msg_creation_cours = '';
            foreach($liste_matieres as $row) {
                $msg_creation_cours .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('creation_cours', $this->values);
        $vue->setVar('titre_page', 'Création de cours');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('liste_matiere', $msg_creation_cours);  
        $vue->setVar('modification_contenu', $modification_contenu);                   
        $vue->generer();
    }  

  	//Enregistrement d'un cours
    public function enregistrement_creation_cours($matiere,$cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($cours == '') {
            $msg_creation_cours = "Veuillez entrer un nom de cours !";
        } else {
            $enregistrement_creation_cours = Enseignement::enregistrementCreationCours($matiere,$cours,$_SESSION['id']); 
            if ($enregistrement_creation_cours == 0) {
                $msg_creation_cours = "Le cours a bien été enregistré !";
            } else {
                $msg_creation_cours = "Ce cours existe déjà !";
            }
        }
        $vue = new Vue('enregistrement_creation_cours', $this->values);
        $vue->setVar('titre_page', 'Création de cours');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('creation_cours', $msg_creation_cours); 
        $vue->setVar('modification_contenu', $modification_contenu);         
        $vue->generer();
    } 

    //Création de la page de création de chapitre de cours
    public function creation_chapitre() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_creation_chapitre = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            foreach($liste_matieres as $row) {
                $msg_creation_chapitre .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('creation_chapitre', $this->values);
        $vue->setVar('titre_page', 'Création de chapitre de cours');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('liste_matiere', $msg_creation_chapitre); 
        $vue->setVar('modification_contenu', $modification_contenu);                    
        $vue->generer();
    }  

    //Création de la page de création de chapitre de cours (deuxième page)
    public function creation_chapitre_cours($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        $readonly = '';
        $disabled = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        $msg_creation_chapitre_cours = '';
        if (Enseignement::verifCours($matiere) != 0){
            $liste_cours = Enseignement::listeCours($matiere);
            $msg_creation_chapitre_cours .= '<label for="un_cours">Veuillez choisir un cours :</label><br><select name="un_cours">';
            foreach($liste_cours as $row) {
                $msg_creation_chapitre_cours .= '<option value="'.$row['num_cours'].'">'.$row['cn_id_cours'].'</option>';
            }
            $msg_creation_chapitre_cours .= '</select>';
        } else {
            $msg_creation_chapitre_cours = "Il n'y aucun cours pour cette matière";
            $readonly = "readonly";
            $disabled = "disabled";
        } 
        $vue = new Vue('creation_chapitre_cours', $this->values);
        $vue->setVar('titre_page', 'Création de chapitre de cours');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('liste_cours', $msg_creation_chapitre_cours);
        $vue->setVar('disabled', $disabled);
        $vue->setVar('readonly', $readonly);   
        $vue->setVar('modification_contenu', $modification_contenu);                                
        $vue->generer();
    }  

  	//Enregistrement d'un chapitre
      public function enregistrement_creation_chapitre_cours($cours,$chapitre,$url) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($chapitre == '') {
            $msg_creation_chapitre = "Veuillez entrer un nom de chapitre !";
        } elseif ($url == '') {
            $msg_creation_chapitre = "Veuillez entrer une url !";
        } else {
            $enregistrement_creation_chapitre = Enseignement::enregistrementCreationChapitreCours($cours,$chapitre,$url,$_SESSION['id']); 
            if ($enregistrement_creation_chapitre == 0) {
                $msg_creation_chapitre = "Le chapitre a bien été enregistré !";
            } else {
                $msg_creation_chapitre = "Ce chapitre existe déjà !";
            }
        }
        $vue = new Vue('enregistrement_creation_chapitre_cours', $this->values);
        $vue->setVar('titre_page', 'Création de cours');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('creation_chapitre_cours', $msg_creation_chapitre); 
        $vue->setVar('modification_contenu', $modification_contenu);         
        $vue->generer();
    }  
    
    //Création de la page de création d'examens
    public function creation_examen($matiere,$examen,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$question_onze,$question_douze,$question_treize,$question_quatorze,$question_quinze,$question_seize,$question_dix_sept,$question_dix_huit,$question_dix_neuf,$question_vingt) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_examen = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            foreach($liste_matieres as $row) {
                $selected = '';
                if ($row['num_matiere'] == $matiere) {
                    $selected = 'selected';
                }
                $msg_creation_examen .= '<option value="'.$row['num_matiere'].'" '. $selected .'>'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('creation_examen', $this->values);
        $vue->setVar('titre_page', "Création d'examen blanc");
        $vue->setVar('creation_contenu', $creation_contenu);
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_matiere', $msg_creation_examen);        
        $vue->setVar('examen', $examen);           
        $vue->setVar('question_un', $question_un);  
        $vue->setVar('question_deux', $question_deux);  
        $vue->setVar('question_trois', $question_trois);  
        $vue->setVar('question_quatre', $question_quatre);  
        $vue->setVar('question_cinq', $question_cinq);  
        $vue->setVar('question_six', $question_six);  
        $vue->setVar('question_sept', $question_sept);  
        $vue->setVar('question_huit', $question_huit);  
        $vue->setVar('question_neuf', $question_neuf);  
        $vue->setVar('question_dix', $question_dix);  
        $vue->setVar('question_onze', $question_onze);  
        $vue->setVar('question_douze', $question_douze);  
        $vue->setVar('question_treize', $question_treize);  
        $vue->setVar('question_quatorze', $question_quatorze);  
        $vue->setVar('question_quinze', $question_quinze);  
        $vue->setVar('question_seize', $question_seize);  
        $vue->setVar('question_dix_sept', $question_dix_sept);  
        $vue->setVar('question_dix_huit', $question_dix_huit);  
        $vue->setVar('question_dix_neuf', $question_dix_neuf);  
        $vue->setVar('question_vingt', $question_vingt);                                     
        $vue->generer();
    }      

  	//Enregistrement d'un examen
      public function enregistrement_creation_examen($matiere,$examen,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$question_onze,$question_douze,$question_treize,$question_quatorze,$question_quinze,$question_seize,$question_dix_sept,$question_dix_huit,$question_dix_neuf,$question_vingt) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($examen == '') {
            $msg_creation_examen = "Veuillez entrer un nom de examen !";
            $msg_creation_examen .= '<br><br><input type="submit" value="Modifier l\'examen"><br><br>';
        } elseif ($question_un == '' OR $question_deux == '' OR $question_trois == '' OR $question_quatre == '' OR $question_cinq == '' OR $question_six == '' OR $question_sept == '' OR $question_huit == '' OR $question_neuf == '' OR $question_dix == '' OR $question_onze == '' OR $question_douze == '' OR $question_treize == '' OR $question_quatorze == '' OR $question_quinze == '' OR $question_seize == '' OR $question_dix_sept == '' OR $question_dix_huit == '' OR $question_dix_neuf == '' OR $question_vingt == '') {
            $msg_creation_examen = "Veuillez remplir les questions manquantes";
            $msg_creation_examen .= '<br><br><input type="submit" value="Modifier l\'examen"><br><br>';                                                                                                                                                                                                                                                                       
        } else {
            $enregistrement_creation_examen = Examens::enregistrementCreationExamen($matiere,$examen,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$question_onze,$question_douze,$question_treize,$question_quatorze,$question_quinze,$question_seize,$question_dix_sept,$question_dix_huit,$question_dix_neuf,$question_vingt,$_SESSION['id']); 
            if ($enregistrement_creation_examen == 0) {
                $msg_creation_examen = "L'examen a bien été enregistré !";
            } else {
                $msg_creation_examen = "L'examen existe déjà !";
            }
        }
        $vue = new Vue('enregistrement_creation_examen', $this->values);
        $vue->setVar('titre_page', "Création d'examen");
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('creation_examen', $msg_creation_examen);
        $vue->setVar('examen', $examen);           
        $vue->setVar('question_un', $question_un);  
        $vue->setVar('question_deux', $question_deux);  
        $vue->setVar('question_trois', $question_trois);  
        $vue->setVar('question_quatre', $question_quatre);  
        $vue->setVar('question_cinq', $question_cinq);  
        $vue->setVar('question_six', $question_six);  
        $vue->setVar('question_sept', $question_sept);  
        $vue->setVar('question_huit', $question_huit);  
        $vue->setVar('question_neuf', $question_neuf);  
        $vue->setVar('question_dix', $question_dix);  
        $vue->setVar('question_onze', $question_onze);  
        $vue->setVar('question_douze', $question_douze);  
        $vue->setVar('question_treize', $question_treize);  
        $vue->setVar('question_quatorze', $question_quatorze);  
        $vue->setVar('question_quinze', $question_quinze);  
        $vue->setVar('question_seize', $question_seize);  
        $vue->setVar('question_dix_sept', $question_dix_sept);  
        $vue->setVar('question_dix_huit', $question_dix_huit);  
        $vue->setVar('question_dix_neuf', $question_dix_neuf);  
        $vue->setVar('question_vingt', $question_vingt); 
        $vue->setVar('matiere', $matiere);                         
        $vue->generer();
    }  

    //Création de la page de création de contrôle
    public function creation_controle() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_controle = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            foreach($liste_matieres as $row) {
                $msg_creation_controle .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('creation_controle', $this->values);
        $vue->setVar('titre_page', 'Création de contrôle');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_matiere', $msg_creation_controle);                    
        $vue->generer();
    }  

    //Création de la page de création de contrôle (deuxième page)
    public function creation_controle_cours($matiere,$cours,$controle,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix) {
        $creation_contenu = '';
        $modification_contenu = '';
        $readonly = '';
        $disabled = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        $msg_creation_controle_cours = '';
         if (Enseignement::verifCours($matiere) != 0){
            $liste_cours = Enseignement::listeCours($matiere);
            $msg_creation_controle_cours .= '<label for="un_cours">Veuillez choisir un cours :</label><br><select name="un_cours">';
            foreach($liste_cours as $row) {
                $selected = '';
                if ($row['num_cours'] == $cours) {
                    $selected = 'selected';
                }
                $msg_creation_controle_cours .= '<option value="'.$row['num_cours'].'" '. $selected .'>'.$row['cn_id_cours'].'</option>';
            }
            $msg_creation_controle_cours .= '</select>';
        } else {
            $msg_creation_controle_cours = "Il n'y aucun cours pour cette matière";
            $readonly = "readonly";
            $disabled = "disabled";
        } 
        $vue = new Vue('creation_controle_cours', $this->values);
        $vue->setVar('titre_page', 'Création de contrôle');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_cours', $msg_creation_controle_cours);
        $vue->setVar('controle', $controle);           
        $vue->setVar('question_un', $question_un);  
        $vue->setVar('question_deux', $question_deux);  
        $vue->setVar('question_trois', $question_trois);  
        $vue->setVar('question_quatre', $question_quatre);  
        $vue->setVar('question_cinq', $question_cinq);  
        $vue->setVar('question_six', $question_six);  
        $vue->setVar('question_sept', $question_sept);  
        $vue->setVar('question_huit', $question_huit);  
        $vue->setVar('question_neuf', $question_neuf);  
        $vue->setVar('question_dix', $question_dix);
        $vue->setVar('matiere', $matiere);
        $vue->setVar('disabled', $disabled);
        $vue->setVar('readonly', $readonly);                                  
        $vue->generer();
    }  

  	//Enregistrement d'un contrôle
      public function enregistrement_creation_controle($matiere,$cours,$controle,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($controle == '') {
            $msg_creation_controle = "Veuillez entrer un nom de contrôle !";
            $msg_creation_controle .= '<br><br><input type="submit" value="Modifier le contrôle"><br><br>';
        } elseif ($question_un == '' OR $question_deux == '' OR $question_trois == '' OR $question_quatre == '' OR $question_cinq == '' OR $question_six == '' OR $question_sept == '' OR $question_huit == '' OR $question_neuf == '' OR $question_dix == '') {
            $msg_creation_controle = "Veuillez remplir les questions manquantes";
            $msg_creation_controle .= '<br><br><input type="submit" value="Modifier le contrôle"><br><br>';                                                                                                                                                                                                                                                                       
        } else {
            $enregistrement_creation_controle = Examens::enregistrementCreationControle($cours,$controle,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$_SESSION['id']); 
            if ($enregistrement_creation_controle == 0) {
                $msg_creation_controle = "Le contrôle a bien été enregistré !";
            } else {
                $msg_creation_controle = "Le contrôle existe déjà !";
            }
        }

        $vue = new Vue('enregistrement_creation_controle', $this->values);
        $vue->setVar('titre_page', "Création de contrôle");
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('creation_controle', $msg_creation_controle);
        $vue->setVar('controle', $controle);           
        $vue->setVar('question_un', $question_un);  
        $vue->setVar('question_deux', $question_deux);  
        $vue->setVar('question_trois', $question_trois);  
        $vue->setVar('question_quatre', $question_quatre);  
        $vue->setVar('question_cinq', $question_cinq);  
        $vue->setVar('question_six', $question_six);  
        $vue->setVar('question_sept', $question_sept);  
        $vue->setVar('question_huit', $question_huit);  
        $vue->setVar('question_neuf', $question_neuf);  
        $vue->setVar('question_dix', $question_dix);  
        $vue->setVar('cours', $cours);
        $vue->setVar('matiere', $matiere);                            
        $vue->generer();
    }  

    //Création de la page de création d'exercice
    public function creation_exercice() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        $msg_creation_exercice = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            foreach($liste_matieres as $row) {
                $msg_creation_exercice .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('creation_exercice', $this->values);
        $vue->setVar('titre_page', "Création d'exercice");
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_matiere', $msg_creation_exercice);                    
        $vue->generer();
    }  

    //Création de la page de création d'exercice (2ème page)
    public function creation_exercice_cours($matiere,$cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        $disabled = '';        
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_exercice_cours = '';
        if (Enseignement::verifCours($matiere) != 0){
            $msg_creation_exercice_cours = '<label for="un_cours">Veuillez choisir un cours :</label><br>
            <select name="un_cours">';
            $liste_cours = Enseignement::listeCours($matiere);
            foreach($liste_cours as $row) {
                $msg_creation_exercice_cours .= '<option value="'.$row['num_cours'].'">'.$row['cn_id_cours'].'</option>';
            }
            $msg_creation_exercice_cours .= '</select>';
        } else {
            $msg_creation_exercice_cours = "Il n'y aucun cours pour cette matière";
            $disabled = "disabled";
        }
        $vue = new Vue('creation_exercice_cours', $this->values);
        $vue->setVar('titre_page', "Création d'exercice");
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_cours', $msg_creation_exercice_cours);
        $vue->setVar('disabled', $disabled);                            
        $vue->generer();
    }      

    //Création de la page de création d'exercice (3ème page)
    public function creation_exercice_chapitre($cours,$chapitre) {
        $creation_contenu = '';
        $modification_contenu = '';
        $disabled = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $msg_creation_exercice_chapitre = '';   
        if (Enseignement::verifChapitres($cours) != 0){
            $liste_chapitre = Enseignement::listeChapitres($cours);
            $msg_creation_exercice_chapitre .= '<label for="un_chapitre">Veuillez choisir un chapitre :</label><br><select name="un_chapitre">';
            foreach($liste_chapitre as $row) {
                $selected = '';
                if ($row['num_chapitre'] == $chapitre) {
                    $selected = 'selected';
                }
                $msg_creation_exercice_chapitre .= '<option value="'.$row['num_chapitre'].'" '. $selected .'>'.$row['cn_id_chapitre'].'</option>';
            }
            $msg_creation_exercice_chapitre .= '</select>';
        } else {
            $msg_creation_exercice_chapitre = "Il n'y aucun chapitre pour cette matière";
            $readonly = "readonly";
            $disabled = "disabled";
        } 
        $vue = new Vue('creation_exercice_chapitre', $this->values);
        $vue->setVar('titre_page', "Création d'exercice");
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_chapitre', $msg_creation_exercice_chapitre);
        $vue->setVar('cours', $cours);        
        $vue->setVar('disabled', $disabled);                                 
        $vue->generer();
    }     

  	//Enregistrement d'un exercice
      public function enregistrement_creation_exercice($cours,$chapitre,$exercice) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($exercice == '') {
            $msg_creation_exercice = "Veuillez remplir le champ de la question";
            $msg_creation_exercice .= '<br><br><input type="submit" value="Modifier l\'exercice"><br><br>';                                                                                                                                                                                                                                                                       
        } else {
            $enregistrement_creation_exercice = Examens::enregistrementCreationExercice($chapitre,$exercice,$_SESSION['id']); 
            if ($enregistrement_creation_exercice == 0) {
                $msg_creation_exercice = "L'exercice a bien été enregistré !";
            } else {
                $msg_creation_exercice = "L'exercice existe déjà !";
            }
        }
        $vue = new Vue('enregistrement_creation_exercice', $this->values);
        $vue->setVar('titre_page', "Création d'exercice");
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('creation_exercice', $msg_creation_exercice);    
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('cours', $cours);
        $vue->setVar('chapitre', $chapitre);                            
        $vue->generer();
    }  

    //Création de la page de création de QCM
    public function creation_qcm() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_qcm = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            foreach($liste_matieres as $row) {
                $msg_creation_qcm .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('creation_qcm', $this->values);
        $vue->setVar('titre_page', "Création de QCM");
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_matiere', $msg_creation_qcm);                    
        $vue->generer();
    }  

    //Création de la page de création de QCM (2ème page)
    public function creation_qcm_cours($matiere,$cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        $disabled = '';        
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_qcm_cours = '';
        if (Enseignement::verifCours($matiere) != 0){
            $msg_creation_qcm_cours = '<label for="un_cours">Veuillez choisir un cours :</label><br>
            <select name="un_cours">';
            $liste_cours = Enseignement::listeCours($matiere);
            foreach($liste_cours as $row) {
                $msg_creation_qcm_cours .= '<option value="'.$row['num_cours'].'">'.$row['cn_id_cours'].'</option>';
            }
            $msg_creation_qcm_cours .= '</select>';
        } else {
            $msg_creation_qcm_cours = "Il n'y aucun cours pour cette matière";
            $disabled = "disabled";
        }
        $vue = new Vue('creation_qcm_cours', $this->values);
        $vue->setVar('titre_page', "Création de QCM");
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_cours', $msg_creation_qcm_cours);
        $vue->setVar('disabled', $disabled);                            
        $vue->generer();
    }      

    //Création de la page de création de QCM (3ème page)
    public function creation_qcm_chapitre($cours,$chapitre,$question_un,$reponse_un_un,$etat_un_un,$reponse_un_deux,$etat_un_deux,$reponse_un_trois,$etat_un_trois,$question_deux,$reponse_deux_un,$etat_deux_un,$reponse_deux_deux,$etat_deux_deux,$reponse_deux_trois,$etat_deux_trois,$question_trois,$reponse_trois_un,$etat_trois_un,$reponse_trois_deux,$etat_trois_deux,$reponse_trois_trois,$etat_trois_trois,$question_quatre,$reponse_quatre_un,$etat_quatre_un,$reponse_quatre_deux,$etat_quatre_deux,$reponse_quatre_trois,$etat_quatre_trois,$question_cinq,$reponse_cinq_un,$etat_cinq_un,$reponse_cinq_deux,$etat_cinq_deux,$reponse_cinq_trois,$etat_cinq_trois) {
        $creation_contenu = '';
        $modification_contenu = '';
        $disabled = '';
        $readonly = '';
        $bonne_un_un = '';
        $fausse_un_un = '';
        $bonne_un_deux = '';
        $fausse_un_deux = '';
        $bonne_un_trois = '';
        $fausse_un_trois = '';
        $bonne_deux_un = '';
        $fausse_deux_un = '';
        $bonne_deux_deux = '';
        $fausse_deux_deux = '';
        $bonne_deux_trois = '';
        $fausse_deux_trois = '';
        $bonne_trois_un = '';
        $fausse_trois_un = '';
        $bonne_trois_deux = '';
        $fausse_trois_deux = '';
        $bonne_trois_trois = '';
        $fausse_trois_trois = '';
        $bonne_quatre_un = '';
        $fausse_quatre_un = '';        
        $bonne_quatre_deux = '';
        $fausse_quatre_deux = '';
        $bonne_quatre_trois = '';
        $fausse_quatre_trois = '';              
        $bonne_cinq_un = '';
        $fausse_cinq_un = '';        
        $bonne_cinq_deux = '';
        $fausse_cinq_deux = '';
        $bonne_cinq_trois = '';
        $fausse_cinq_trois = '';      
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($etat_un_un == '1') {
            $bonne_un_un = "checked";
        } elseif ($etat_un_un == '0') {
            $fausse_un_un = "checked";
        } else {
            $bonne_un_un = '';
            $fausse_un_un = '';
        }
        if ($etat_un_deux == '1') {
            $bonne_un_deux = "checked";
        } elseif ($etat_un_deux == '0') {
            $fausse_un_deux = "checked";
        } else {
            $bonne_un_deux = '';
            $fausse_un_deux = '';
        }
        if ($etat_un_trois == '1') {
            $bonne_un_trois = "checked";
        } elseif ($etat_un_trois == '0') {
            $fausse_un_trois = "checked";
        } else {
            $bonne_un_trois = '';
            $fausse_un_trois = '';
        }
        if ($etat_deux_un == '1') {
            $bonne_deux_un = "checked";
        } elseif ($etat_deux_un == '0') {
            $fausse_deux_un = "checked";
        } else {
            $bonne_deux_un = '';
            $fausse_deux_un = '';
        }
        if ($etat_deux_deux == '1') {
            $bonne_deux_deux = "checked";
        } elseif ($etat_deux_deux == '0') {
            $fausse_deux_deux = "checked";
        } else {
            $bonne_deux_deux = '';
            $fausse_deux_deux = '';
        }
        if ($etat_deux_trois == '1') {
            $bonne_deux_trois = "checked";
        } elseif ($etat_deux_trois == '0') {
            $fausse_deux_trois = "checked";
        } else {
            $bonne_deux_trois = '';
            $fausse_deux_trois = '';
        }
        if ($etat_trois_un == '1') {
            $bonne_trois_un = "checked";
        } elseif ($etat_trois_un == '0') {
            $fausse_trois_un = "checked";
        } else {
            $bonne_trois_un = '';
            $fausse_trois_un = '';
        }
        if ($etat_trois_deux == '1') {
            $bonne_trois_deux = "checked";
        } elseif ($etat_trois_deux == '0') {
            $fausse_trois_deux = "checked";
        } else {
            $bonne_trois_deux = '';
            $fausse_trois_deux = '';
        }
        if ($etat_trois_trois == '1') {
            $bonne_trois_trois = "checked";
        } elseif ($etat_trois_trois == '0') {
            $fausse_trois_trois = "checked";
        } else {
            $bonne_trois_trois = '';
            $fausse_trois_trois = '';
        }
        if ($etat_quatre_un == '1') {
            $bonne_quatre_un = "checked";
        } elseif ($etat_quatre_un == '0') {
            $fausse_quatre_un = "checked";
        } else {
            $bonne_quatre_un = '';
            $fausse_quatre_un = ''; 
        }
        if ($etat_quatre_deux == '1') {
            $bonne_quatre_deux = "checked";
        } elseif ($etat_quatre_deux == '0') {
            $fausse_quatre_deux = "checked";
        } else {
            $bonne_quatre_deux = '';
            $fausse_quatre_deux = '';
        }
        if ($etat_quatre_trois == '1') {
            $bonne_quatre_trois = "checked";
        } elseif ($etat_quatre_trois == '0') {
            $fausse_quatre_trois = "checked";
        } else {
            $bonne_quatre_trois = '';
            $fausse_quatre_trois = ''; 
        }
        if ($etat_cinq_un == '1') {
            $bonne_cinq_un = "checked";
        } elseif ($etat_cinq_un == '0') {
            $fausse_cinq_un = "checked";
        } else {
            $bonne_cinq_un = '';
            $fausse_cinq_un = '';  
        }
        if ($etat_cinq_deux == '1') {
            $bonne_cinq_deux = "checked";
        } elseif ($etat_cinq_deux == '0') {
            $fausse_cinq_deux = "checked";
        } else {
            $bonne_cinq_deux = '';
            $fausse_cinq_deux = '';
        }
        if ($etat_cinq_trois == '1') {
            $bonne_cinq_trois = "checked";
        } elseif ($etat_cinq_trois == '0') {
            $fausse_cinq_trois = "checked";
        } else {
            $bonne_cinq_trois = '';
            $fausse_cinq_trois = '';  
        }                                                                                                              
        $msg_creation_qcm_chapitre = '';   
        if (Enseignement::verifChapitres($cours) != 0){
            $liste_chapitre = Enseignement::listeChapitres($cours);
            $msg_creation_qcm_chapitre .= '<label for="un_chapitre">Veuillez choisir un chapitre :</label><br><select name="un_chapitre">';
            foreach($liste_chapitre as $row) {
                $selected = '';
                if ($row['num_chapitre'] == $chapitre) {
                    $selected = 'selected';
                }
                $msg_creation_qcm_chapitre .= '<option value="'.$row['num_chapitre'].'" '. $selected .'>'.$row['cn_id_chapitre'].'</option>';
            }
            $msg_creation_qcm_chapitre .= '</select>';
        } else {
            $msg_creation_qcm_chapitre = "Il n'y aucun chapitre pour cette matière";
            $readonly = "readonly";
            $disabled = "disabled";
        } 
        $vue = new Vue('creation_qcm_chapitre', $this->values);
        $vue->setVar('titre_page', "Création de QCM");
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_chapitre', $msg_creation_qcm_chapitre);
        $vue->setVar('cours', $cours);
        $vue->setVar('question_un', $question_un);
        $vue->setVar('reponse_un_un', $reponse_un_un);
        $vue->setVar('bonne_un_un', $bonne_un_un);
        $vue->setVar('fausse_un_un', $fausse_un_un);        
        $vue->setVar('reponse_un_deux', $reponse_un_deux);
        $vue->setVar('bonne_un_deux', $bonne_un_deux);
        $vue->setVar('fausse_un_deux', $fausse_un_deux); 
        $vue->setVar('reponse_un_trois', $reponse_un_trois);
        $vue->setVar('bonne_un_trois', $bonne_un_trois);
        $vue->setVar('fausse_un_trois', $fausse_un_trois); 
        $vue->setVar('question_deux', $question_deux);
        $vue->setVar('reponse_deux_un', $reponse_deux_un);
        $vue->setVar('bonne_deux_un', $bonne_deux_un);
        $vue->setVar('fausse_deux_un', $fausse_deux_un); 
        $vue->setVar('reponse_deux_deux', $reponse_deux_deux);
        $vue->setVar('bonne_deux_deux', $bonne_deux_deux);
        $vue->setVar('fausse_deux_deux', $fausse_deux_deux); 
        $vue->setVar('reponse_deux_trois', $reponse_deux_trois);
        $vue->setVar('bonne_deux_trois', $bonne_deux_trois);
        $vue->setVar('fausse_deux_trois', $fausse_deux_trois);      
        $vue->setVar('question_trois', $question_trois);
        $vue->setVar('reponse_trois_un', $reponse_trois_un);
        $vue->setVar('bonne_trois_un', $bonne_trois_un);
        $vue->setVar('fausse_trois_un', $fausse_trois_un); 
        $vue->setVar('reponse_trois_deux', $reponse_trois_deux);
        $vue->setVar('bonne_trois_deux', $bonne_trois_deux);
        $vue->setVar('fausse_trois_deux', $fausse_trois_deux); 
        $vue->setVar('reponse_trois_trois', $reponse_trois_trois);
        $vue->setVar('bonne_trois_trois', $bonne_trois_trois);
        $vue->setVar('fausse_trois_trois', $fausse_trois_trois); 
        $vue->setVar('question_quatre', $question_quatre);
        $vue->setVar('reponse_quatre_un', $reponse_quatre_un);
        $vue->setVar('bonne_quatre_un', $bonne_quatre_un);
        $vue->setVar('fausse_quatre_un', $fausse_quatre_un); 
        $vue->setVar('reponse_quatre_deux', $reponse_quatre_deux);
        $vue->setVar('bonne_quatre_deux', $bonne_quatre_deux);
        $vue->setVar('fausse_quatre_deux', $fausse_quatre_deux); 
        $vue->setVar('reponse_quatre_trois', $reponse_quatre_trois);
        $vue->setVar('bonne_quatre_trois', $bonne_quatre_trois);
        $vue->setVar('fausse_quatre_trois', $fausse_quatre_trois); 
        $vue->setVar('question_cinq', $question_cinq);
        $vue->setVar('reponse_cinq_un', $reponse_cinq_un);
        $vue->setVar('bonne_cinq_un', $bonne_cinq_un);
        $vue->setVar('fausse_cinq_un', $fausse_cinq_un); 
        $vue->setVar('reponse_cinq_deux', $reponse_cinq_deux);
        $vue->setVar('bonne_cinq_deux', $bonne_cinq_deux);
        $vue->setVar('fausse_cinq_deux', $fausse_cinq_deux); 
        $vue->setVar('reponse_cinq_trois', $reponse_cinq_trois);
        $vue->setVar('bonne_cinq_trois', $bonne_cinq_trois);
        $vue->setVar('fausse_cinq_trois', $fausse_cinq_trois);  
        $vue->setVar('readonly', $readonly);              
        $vue->setVar('disabled', $disabled);                                 
        $vue->generer();
    }     

  	//Enregistrement d'un QCM
      public function enregistrement_creation_qcm($cours,$chapitre,$question_un,$reponse_un_un,$etat_un_un,$reponse_un_deux,$etat_un_deux,$reponse_un_trois,$etat_un_trois,$question_deux,$reponse_deux_un,$etat_deux_un,$reponse_deux_deux,$etat_deux_deux,$reponse_deux_trois,$etat_deux_trois,$question_trois,$reponse_trois_un,$etat_trois_un,$reponse_trois_deux,$etat_trois_deux,$reponse_trois_trois,$etat_trois_trois,$question_quatre,$reponse_quatre_un,$etat_quatre_un,$reponse_quatre_deux,$etat_quatre_deux,$reponse_quatre_trois,$etat_quatre_trois,$question_cinq,$reponse_cinq_un,$etat_cinq_un,$reponse_cinq_deux,$etat_cinq_deux,$reponse_cinq_trois,$etat_cinq_trois) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($question_un == '' OR $reponse_un_un == '' OR $reponse_un_deux == '' OR $reponse_un_trois == '' OR $question_deux == '' OR $reponse_deux_un == '' OR $reponse_deux_deux == '' OR $reponse_deux_trois == '' OR $question_trois == '' OR $reponse_trois_un == '' OR $reponse_trois_deux == '' OR $reponse_trois_trois == '' OR $question_quatre == '' OR $reponse_quatre_un == '' OR $reponse_quatre_deux == '' OR $reponse_quatre_trois == '' OR $question_cinq == '' OR $reponse_cinq_un == '' OR $reponse_cinq_deux == '' OR $reponse_cinq_trois == '') {
            $msg_creation_qcm = "Veuillez remplir tous les champs !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                                                                                                                                                                                                                                                       
        } elseif ($etat_un_un == '' OR $etat_un_deux == '' OR $etat_un_trois == '' OR $etat_deux_un == '' OR $etat_deux_deux == '' OR $etat_deux_trois == '' OR $etat_trois_un == '' OR $etat_trois_deux == '' OR $etat_trois_trois == '' OR $etat_quatre_un == '' OR $etat_quatre_deux == '' OR $etat_quatre_trois == '' OR $etat_cinq_un == '' OR $etat_cinq_deux == '' OR $etat_cinq_trois == '') {
            $msg_creation_qcm = "Veuillez choisir un état pour chaque réponse !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                                                                                                                                                                                                                                                          
        } elseif ($etat_un_un == '0' AND $etat_un_deux == '0' AND $etat_un_trois == '0') {
            $msg_creation_qcm = "Vous devez choisir une bonne réponse pour la question un !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                                                                                                                                                                                                                                                          
        } elseif ($etat_deux_un == '0' AND $etat_deux_deux == '0' AND $etat_deux_trois == '0') {
            $msg_creation_qcm = "Vous devez choisir une bonne réponse pour la question deux !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';             
        } elseif ($etat_trois_un == '0' AND $etat_trois_deux == '0' AND $etat_trois_trois == '0') {
            $msg_creation_qcm = "Vous devez choisir une bonne réponse pour la question trois !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>'; 
        } elseif ($etat_quatre_un == '0' AND $etat_quatre_deux == '0' AND $etat_quatre_trois == '0') {
            $msg_creation_qcm = "Vous devez choisir une bonne réponse pour la question quatre !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>'; 
        } elseif ($etat_cinq_un == '0' AND $etat_cinq_deux == '0' AND $etat_cinq_trois == '0') {
            $msg_creation_qcm = "Vous devez choisir une bonne réponse pour la question cinq !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                     
        } elseif ($etat_un_un == '1' AND $etat_un_deux == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question un !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_un_un == '1' AND $etat_un_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question un !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_un_deux == '1' AND $etat_un_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question un !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_deux_un == '1' AND $etat_deux_deux == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question deux !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_deux_un == '1' AND $etat_deux_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question deux !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_deux_deux == '1' AND $etat_deux_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question deux !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_trois_un == '1' AND $etat_trois_deux == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question trois !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_trois_un == '1' AND $etat_trois_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question trois !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_trois_deux == '1' AND $etat_trois_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question trois !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_quatre_un == '1' AND $etat_quatre_deux == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question quatre !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_quatre_un == '1' AND $etat_quatre_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question quatre !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_quatre_deux == '1' AND $etat_quatre_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question quatre !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_cinq_un == '1' AND $etat_cinq_deux == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question cinq !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_cinq_un == '1' AND $etat_cinq_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question cinq !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } elseif ($etat_cinq_deux == '1' AND $etat_cinq_trois == '1') {
            $msg_creation_qcm = "Il ne peut pas y avoir qu'une seule bonne réponse à la question cinq !";
            $msg_creation_qcm .= '<br><br><input type="submit" value="Modifier le QCM"><br><br>';                                              
        } else {
            $enregistrement_creation_exercice = Examens::enregistrementCreationQCM($chapitre,$question_un,$reponse_un_un,$etat_un_un,$reponse_un_deux,$etat_un_deux,$reponse_un_trois,$etat_un_trois,$question_deux,$reponse_deux_un,$etat_deux_un,$reponse_deux_deux,$etat_deux_deux,$reponse_deux_trois,$etat_deux_trois,$question_trois,$reponse_trois_un,$etat_trois_un,$reponse_trois_deux,$etat_trois_deux,$reponse_trois_trois,$etat_trois_trois,$question_quatre,$reponse_quatre_un,$etat_quatre_un,$reponse_quatre_deux,$etat_quatre_deux,$reponse_quatre_trois,$etat_quatre_trois,$question_cinq,$reponse_cinq_un,$etat_cinq_un,$reponse_cinq_deux,$etat_cinq_deux,$reponse_cinq_trois,$etat_cinq_trois,$_SESSION['id']); 
            if ($enregistrement_creation_exercice == 0) {
                $msg_creation_qcm = "Le QCM a bien été enregistré !";
            } else {
                $msg_creation_qcm = "Le QCM existe déjà !";
            }
        }
        $vue = new Vue('enregistrement_creation_qcm', $this->values);
        $vue->setVar('titre_page', "Création de QCM");
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('creation_qcm', $msg_creation_qcm);
        $vue->setVar('cours', $cours);
        $vue->setVar('chapitre', $chapitre);
        $vue->setVar('question_un', $question_un);
        $vue->setVar('reponse_un_un', $reponse_un_un);
        $vue->setVar('etat_un_un', $etat_un_un);
        $vue->setVar('reponse_un_deux', $reponse_un_deux);
        $vue->setVar('etat_un_deux', $etat_un_deux);
        $vue->setVar('reponse_un_trois', $reponse_un_trois);
        $vue->setVar('etat_un_trois', $etat_un_trois);
        $vue->setVar('question_deux', $question_deux);
        $vue->setVar('reponse_deux_un', $reponse_deux_un);
        $vue->setVar('etat_deux_un', $etat_deux_un);
        $vue->setVar('reponse_deux_deux', $reponse_deux_deux);
        $vue->setVar('etat_deux_deux', $etat_deux_deux);
        $vue->setVar('reponse_deux_trois', $reponse_deux_trois);
        $vue->setVar('etat_deux_trois', $etat_deux_trois);     
        $vue->setVar('question_trois', $question_trois);
        $vue->setVar('reponse_trois_un', $reponse_trois_un);
        $vue->setVar('etat_trois_un', $etat_trois_un);
        $vue->setVar('reponse_trois_deux', $reponse_trois_deux);
        $vue->setVar('etat_trois_deux', $etat_trois_deux);
        $vue->setVar('reponse_trois_trois', $reponse_trois_trois);
        $vue->setVar('etat_trois_trois', $etat_trois_trois);
        $vue->setVar('question_quatre', $question_quatre);
        $vue->setVar('reponse_quatre_un', $reponse_quatre_un);
        $vue->setVar('etat_quatre_un', $etat_quatre_un);
        $vue->setVar('reponse_quatre_deux', $reponse_quatre_deux);
        $vue->setVar('etat_quatre_deux', $etat_quatre_deux);
        $vue->setVar('reponse_quatre_trois', $reponse_quatre_trois);
        $vue->setVar('etat_quatre_trois', $etat_quatre_trois);
        $vue->setVar('question_cinq', $question_cinq);
        $vue->setVar('reponse_cinq_un', $reponse_cinq_un);
        $vue->setVar('etat_cinq_un', $etat_cinq_un);
        $vue->setVar('reponse_cinq_deux', $reponse_cinq_deux);
        $vue->setVar('etat_cinq_deux', $etat_cinq_deux);
        $vue->setVar('reponse_cinq_trois', $reponse_cinq_trois);
        $vue->setVar('etat_cinq_trois', $etat_cinq_trois);
        $vue->generer();
    }  

  	//Création de la page de modification de contenu
      public function modification_contenu() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }        
        $vue = new Vue('modification_contenu', $this->values);
        $vue->setVar('titre_page', 'Modification de contenu');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);            
        $vue->generer();
    }    
    
  	//Création de la page de modification de matières
      public function modification_matiere() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeAllMatieres();
            $msg_modification_cours = '';
            foreach($liste_matieres as $row) {
                $msg_modification_cours .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('modification_matiere', $this->values);
        $vue->setVar('titre_page', 'Modification de matiere');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);  
        $vue->setVar('liste_matiere', $msg_modification_cours);                           
        $vue->generer();
    }  

  	//Création de la page de modification de matières (2ème page)
      public function choisir_modification_matiere($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        $actif = '';
        $inactif = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        $titre_matiere =  Enseignement::titreMatiere($matiere);
        $etat_matiere =  Enseignement::etatMatiere($matiere);  
        if ($etat_matiere == '1'){
            $actif = 'checked';
        } else {
            $inactif = 'checked';
        }      
        $vue = new Vue('choisir_modification_matiere', $this->values);
        $vue->setVar('titre_page', 'Modification de matiere');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);
        $vue->setVar('id_matiere', $matiere);            
        $vue->setVar('titre_matiere', $titre_matiere); 
        $vue->setVar('actif', $actif);          
        $vue->setVar('inactif', $inactif);         
        $vue->generer();
    }      

  	//Mise à jour d'une matière
      public function enregistrement_modification_matiere($id_matiere,$nom_matiere,$etat) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($nom_matiere == '') {
            $msg_modification_matiere = "Veuillez entrer un nom de matiere !";
        } else {
            $enregistrement_modification_matiere = Enseignement::enregistrementModificationMatiere($id_matiere,$nom_matiere,$etat,$_SESSION['id']); 
            $msg_modification_matiere = "La matière a bien été modifiée !";
        }
        $vue = new Vue('enregistrement_modification_matiere', $this->values);
        $vue->setVar('titre_page', 'Modification de matière');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_matiere', $msg_modification_matiere);
        $vue->setVar('modification_contenu', $modification_contenu);          
        $vue->generer();
    } 
    
    //Création de la page de modification de cours
    public function modification_cours() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_cours = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            $msg_modification_cours = '';
            foreach($liste_matieres as $row) {
                $msg_modification_cours .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('modification_cours', $this->values);
        $vue->setVar('titre_page', 'Modification de cours');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('liste_matiere', $msg_modification_cours);  
        $vue->setVar('modification_contenu', $modification_contenu);                   
        $vue->generer();
    }  

  	//Création de la page de modification de cours (2ème page)
      public function choisir_modification_matiere_cours($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        $disabled = "";
        $msg_modification_cours = "";
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        if (Enseignement::verifCours($matiere) != 0){
            $liste_cours = Enseignement::listeAllCours($matiere);
            $msg_modification_cours .= '<label for="un_cours">Veuillez choisir un cours :</label><br><select name="un_cours">';
            foreach($liste_cours as $row) {
                $msg_modification_cours .= '<option value="'.$row['num_cours'].'">'.$row['cn_id_cours'].'</option>';
            }
            $msg_modification_cours .= '</select>';
        } else {
            $msg_modification_cours = "Il n'y aucun cours pour cette matière";
            $disabled = "disabled";
        }         
        $vue = new Vue('choisir_modification_matiere_cours', $this->values);
        $vue->setVar('titre_page', 'Modification de cours');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);
        $vue->setVar('liste_cours', $msg_modification_cours);       
        $vue->setVar('disabled', $disabled);                                   
        $vue->generer();
    } 

  	//Création de la page de modification de cours (3ème page)
      public function choisir_modification_cours($cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        $msg_modification_cours = "";
        $actif = "";
        $inactif = "";
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        $titre_cours =  Enseignement::titreCours($cours);
        $etat_cours =  Enseignement::etatCours($cours);  
        if ($etat_cours == '1'){
            $actif = 'checked';
        } else {
            $inactif = 'checked';
        }  
        $vue = new Vue('choisir_modification_cours', $this->values);
        $vue->setVar('titre_page', 'Modification de cours');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);  
        $vue->setVar('id_cours', $cours);            
        $vue->setVar('titre_cours', $titre_cours); 
        $vue->setVar('actif', $actif);          
        $vue->setVar('inactif', $inactif);                                                  
        $vue->generer();
    } 

  	//Mise à jour d'un cours
      public function enregistrement_modification_cours($id_cours,$nom_cours,$etat) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($nom_cours == '') {
            $msg_modification_cours = "Veuillez entrer un nom de cours !";
        } else {
            $enregistrement_modification_cours = Enseignement::enregistrementModificationCours($id_cours,$nom_cours,$etat,$_SESSION['id']); 
            $msg_modification_cours = "Le cours a bien été modifié !";
        }
        $vue = new Vue('enregistrement_modification_cours', $this->values);
        $vue->setVar('titre_page', 'Modification de cours');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_cours', $msg_modification_cours);
        $vue->setVar('modification_contenu', $modification_contenu);          
        $vue->generer();
    } 

    //Création de la page de modification de chapitre
    public function modification_chapitre() {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        } 
        $msg_creation_cours = '';
        if (Enseignement::verifMatieres()){
            $liste_matieres = Enseignement::listeMatieres();
            $msg_modification_cours = '';
            foreach($liste_matieres as $row) {
                $msg_modification_cours .= '<option value="'.$row['num_matiere'].'">'.$row['cn_id_matiere'].'</option>';
            }
        }
        $vue = new Vue('modification_chapitre', $this->values);
        $vue->setVar('titre_page', 'Modification de chapitre');
        $vue->setVar('creation_contenu', $creation_contenu); 
        $vue->setVar('liste_matiere', $msg_modification_cours);  
        $vue->setVar('modification_contenu', $modification_contenu);                   
        $vue->generer();
    }  

  	//Création de la page de modification de chapitre (2ème page)
      public function choisir_modification_matiere_chapitre($matiere) {
        $creation_contenu = '';
        $modification_contenu = '';
        $disabled = "";
        $msg_modification_cours = "";
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        if (Enseignement::verifCours($matiere) != 0){
            $liste_cours = Enseignement::listeAllCours($matiere);
            $msg_modification_cours .= '<label for="un_cours">Veuillez choisir un cours :</label><br><select name="un_cours">';
            foreach($liste_cours as $row) {
                $msg_modification_cours .= '<option value="'.$row['num_cours'].'">'.$row['cn_id_cours'].'</option>';
            }
            $msg_modification_cours .= '</select>';
        } else {
            $msg_modification_cours = "Il n'y aucun cours pour cette matière";
            $disabled = "disabled";
        }         
        $vue = new Vue('choisir_modification_matiere_chapitre', $this->values);
        $vue->setVar('titre_page', 'Modification de chapitre');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);
        $vue->setVar('liste_cours', $msg_modification_cours);       
        $vue->setVar('disabled', $disabled);                                   
        $vue->generer();
    } 

  	//Création de la page de modification de chapitre (3ème page)
      public function choisir_modification_cours_chapitre($cours) {
        $creation_contenu = '';
        $modification_contenu = '';
        $msg_modification_chapitre = "";
        $disabled = "";
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }         
        if (Enseignement::verifChapitres($cours) != 0){
            $liste_chapitre = Enseignement::listeAllChapitres($cours);

            $msg_modification_chapitre .= '<label for="un_chapitre">Veuillez choisir un chapitre :</label><br><select name="un_chapitre">';
            foreach($liste_chapitre as $row) {
                $msg_modification_chapitre .= '<option value="'.$row['num_chapitre'].'">'.$row['cn_id_chapitre'].'</option>';
            }
            $msg_modification_chapitre .= '</select>';
        } else {
            $msg_modification_chapitre = "Il n'y aucun chapitre pour ce cours";
            $disabled = "disabled";
        }                 
        $vue = new Vue('choisir_modification_cours_chapitre', $this->values);
        $vue->setVar('titre_page', 'Modification de chapitre');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu); 
        $vue->setVar('liste_chapitre', $msg_modification_chapitre);          
        $vue->setVar('disabled', $disabled);                                                                    
        $vue->generer();
    } 

  	//Création de la page de modification de chapitre (4ème page)
      public function choisir_modification_chapitre($chapitre) {
        $creation_contenu = '';
        $modification_contenu = '';
        $msg_modification_cours = "";
        $actif = "";
        $inactif = "";
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }  
        $titre_chapitre =  Enseignement::titreChapitre($chapitre);
        $url_video =  Enseignement::urlVideo($chapitre);
        $etat_chapitre =  Enseignement::etatChapitre($chapitre);  
        if ($etat_chapitre == '1'){
            $actif = 'checked';
        } else {
            $inactif = 'checked';
        }  
        $vue = new Vue('choisir_modification_chapitre', $this->values);
        $vue->setVar('titre_page', 'Modification de chapitre');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_contenu', $modification_contenu);  
        $vue->setVar('id_chapitre', $chapitre);            
        $vue->setVar('titre_chapitre', $titre_chapitre); 
        $vue->setVar('url', $url_video);          
        $vue->setVar('actif', $actif);          
        $vue->setVar('inactif', $inactif);                                                  
        $vue->generer();
    } 

  	//Mise à jour d'un chapitre
      public function enregistrement_modification_chapitre($id_chapitre,$nom_chapitre,$url,$etat) {
        $creation_contenu = '';
        $modification_contenu = '';
        if ($_SESSION['type'] == '1' OR $_SESSION['type']== '2') {
            $creation_contenu = '<a href="index.php?task=creation_contenu">Création de contenu</a>';
            $modification_contenu = '<a href="index.php?task=modification_contenu">Modification de contenu</a>';
        }
        if ($nom_chapitre == '') {
            $msg_modification_chapitre = "Veuillez entrer un nom de chapitre !";
        } else {
            $enregistrement_modification_cours = Enseignement::enregistrementModificationChapitre($id_chapitre,$nom_chapitre,$url,$etat,$_SESSION['id']); 
            $msg_modification_chapitre = "Le chapitre a bien été modifié !";
        }
        $vue = new Vue('enregistrement_modification_chapitre', $this->values);
        $vue->setVar('titre_page', 'Modification de cours');
        $vue->setVar('creation_contenu', $creation_contenu);  
        $vue->setVar('modification_chapitre', $msg_modification_chapitre);
        $vue->setVar('modification_contenu', $modification_contenu);          
        $vue->generer();
    } 

}
