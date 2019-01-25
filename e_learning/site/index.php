<?php

//Création des url des pages PHP
spl_autoload_register(function ($nom_classe) {
    require "./classes/" . $nom_classe . ".php";
});

//Test de connexion
try {
    session_start();
//Récupération des identifants dans le formulaire de connexion        
    $post_identifiant = filter_input(INPUT_POST, 'un_identifiant', FILTER_SANITIZE_STRING);
    $ctrl = new Controller();
//Vérification si la variable et SESSION est vide,sinon enregistrement de l'identifiant dans une variable SESSION
    if ($post_identifiant == '') {
        if (isset($_SESSION['id'])){
            $post_identifiant = $_SESSION['id'];
            $est_connecte = TRUE;
        } else {
            $est_connecte = FALSE;
        }
    } else {
        $est_connecte = TRUE;
    }
 //Vérification si la SESSION est initialisée           
    if ($est_connecte == FALSE) {
        $ctrl->login();
    } else {
        $ctrl->addVal('un_identifiant', $post_identifiant);
        $task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING);
        if (!isset($task)){
            $task = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);
            if (!isset($task)){
                $task = 'logout';
            }
        }
//Liste des tâches à effectuer
        switch($task) {
            case 'login':
                $post_mdp = filter_input(INPUT_POST, 'un_mdp', FILTER_SANITIZE_STRING);
                $ctrl->testConnexion($post_identifiant, $post_mdp);
                break;
            case 'logout':
                $ctrl->logout();
                break; 
            case 'mention':
                $ctrl->mention();
                break; 	
            case 'confidentialite':
                $ctrl->confidentialite();
                break;
            case 'contact':
                $ctrl->contact();
                break; 
            case 'retour_accueil':
                $ctrl->accueil();
                break; 
            case 'profil':
                $ctrl->profil();
                break; 	                
            case 'matiere':
                $ctrl->matiere();
                break; 
            case 'cours':
                $choix_matiere = filter_input(INPUT_GET, 'matiere', FILTER_SANITIZE_STRING);
                $ctrl->cours($choix_matiere);
                break;
            case 'chapitre':
                $choix_cours = filter_input(INPUT_GET, 'cours', FILTER_SANITIZE_STRING);
                $ctrl->chapitre($choix_cours);
                break;
            case 'fichier':
                $choix_chapitre = filter_input(INPUT_GET, 'chapitre', FILTER_SANITIZE_STRING);
                $ctrl->fichier($choix_chapitre);
                break;
            case 'qcm':
                $fichier = filter_input(INPUT_GET, 'fichier', FILTER_SANITIZE_STRING);
                $ctrl->qcm($fichier);
                break; 	
            case 'verification_qcm':
                $question_1 = filter_input(INPUT_POST, 'question_1', FILTER_SANITIZE_STRING);
                $question_2 = filter_input(INPUT_POST, 'question_2', FILTER_SANITIZE_STRING);
                $question_3 = filter_input(INPUT_POST, 'question_3', FILTER_SANITIZE_STRING); 
                $question_4 = filter_input(INPUT_POST, 'question_4', FILTER_SANITIZE_STRING); 
                $question_5 = filter_input(INPUT_POST, 'question_5', FILTER_SANITIZE_STRING); 
                $fichier = filter_input(INPUT_POST, 'un_fichier', FILTER_SANITIZE_STRING);                                                                                
                $ctrl->verification_qcm($question_1,$question_2,$question_3,$question_4,$question_5,$fichier);
                break; 	 
            case 'liste_exercice':
                $cours = filter_input(INPUT_GET, 'cours', FILTER_SANITIZE_STRING);
                $ctrl->liste_exercices($cours);
                break;  
            case 'exercice':
                $exercice = filter_input(INPUT_GET, 'exercice', FILTER_SANITIZE_STRING);
                $ctrl->exercice($exercice);
                break;
            case 'enregistrement_exercice':
                $exercice = filter_input(INPUT_POST, 'un_exercice', FILTER_SANITIZE_STRING);
                $reponse = filter_input(INPUT_POST, 'reponse_exercice', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_reponse_exerice($exercice,$reponse);
                break; 
            case 'liste_controle':
                $matiere = filter_input(INPUT_GET, 'matiere', FILTER_SANITIZE_STRING);
                $ctrl->liste_controles($matiere);
                break;
            case 'controle':
                $controle = filter_input(INPUT_GET, 'controle', FILTER_SANITIZE_STRING);
                $ctrl->questioncontrole($controle);
                break; 
            case 'question_controle':
                $question_controle = filter_input(INPUT_GET, 'question', FILTER_SANITIZE_STRING);
                $ctrl->controle($question_controle);
                break;
            case 'enregistrement_controle':
                $question_controle = filter_input(INPUT_POST, 'une_question_controle', FILTER_SANITIZE_STRING);
                $reponse_controle = filter_input(INPUT_POST, 'reponse_controle', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_reponse_controle($question_controle,$reponse_controle);
                break;  
            case 'liste_examen':
                $ctrl->liste_examens();
                break; 
            case 'examen':
                $examen = filter_input(INPUT_GET, 'examen', FILTER_SANITIZE_STRING);
                $ctrl->questionexamen($examen);
                break;  
            case 'question_examen':
                $question_examen = filter_input(INPUT_GET, 'question', FILTER_SANITIZE_STRING);
                $ctrl->examen($question_examen);
                break;
            case 'enregistrement_examen':
                $question_examen = filter_input(INPUT_POST, 'une_question_examen', FILTER_SANITIZE_STRING);
                $reponse_examen = filter_input(INPUT_POST, 'reponse_examen', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_reponse_examen($question_examen,$reponse_examen);
                break;    
            case 'notes':
                $ctrl->liste_notes();
                break;   
            case 'creation_contenu':
                $ctrl->creation_contenu();
                break;  
            case 'creation_matiere':
                $ctrl->creation_matiere();
                break;   
            case 'enregistrement_creation_matiere':
                $intitule_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_creation_matiere($intitule_matiere);
                break;                       
            case 'creation_cours':
                $ctrl->creation_cours();
                break;   
            case 'enregistrement_creation_cours':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $intitule_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_creation_cours($choix_matiere,$intitule_cours);
                break;                 
            case 'creation_chapitre':
                $ctrl->creation_chapitre();
                break;
            case 'creation_chapitre_cours':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $ctrl->creation_chapitre_cours($choix_matiere);
                break;   
            case 'enregistrement_creation_chapitre_cours':
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $intitule_chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);  
                $url = filter_input(INPUT_POST, 'une_video', FILTER_SANITIZE_STRING);              
                $ctrl->enregistrement_creation_chapitre_cours($choix_cours,$intitule_chapitre,$url);              
                break;            
            case 'creation_examen':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $intitule_examen = filter_input(INPUT_POST, 'un_examen', FILTER_SANITIZE_STRING);  
                $question_un = filter_input(INPUT_POST, 'question_un', FILTER_SANITIZE_STRING); 
                $question_deux = filter_input(INPUT_POST, 'question_deux', FILTER_SANITIZE_STRING); 
                $question_trois = filter_input(INPUT_POST, 'question_trois', FILTER_SANITIZE_STRING); 
                $question_quatre = filter_input(INPUT_POST, 'question_quatre', FILTER_SANITIZE_STRING); 
                $question_cinq = filter_input(INPUT_POST, 'question_cinq', FILTER_SANITIZE_STRING); 
                $question_six = filter_input(INPUT_POST, 'question_six', FILTER_SANITIZE_STRING); 
                $question_sept = filter_input(INPUT_POST, 'question_sept', FILTER_SANITIZE_STRING); 
                $question_huit = filter_input(INPUT_POST, 'question_huit', FILTER_SANITIZE_STRING); 
                $question_neuf = filter_input(INPUT_POST, 'question_neuf', FILTER_SANITIZE_STRING); 
                $question_dix = filter_input(INPUT_POST, 'question_dix', FILTER_SANITIZE_STRING); 
                $question_onze = filter_input(INPUT_POST, 'question_onze', FILTER_SANITIZE_STRING); 
                $question_douze = filter_input(INPUT_POST, 'question_douze', FILTER_SANITIZE_STRING); 
                $question_treize = filter_input(INPUT_POST, 'question_treize', FILTER_SANITIZE_STRING); 
                $question_quatorze = filter_input(INPUT_POST, 'question_quatorze', FILTER_SANITIZE_STRING); 
                $question_quinze = filter_input(INPUT_POST, 'question_quinze', FILTER_SANITIZE_STRING); 
                $question_seize = filter_input(INPUT_POST, 'question_seize', FILTER_SANITIZE_STRING); 
                $question_dix_sept = filter_input(INPUT_POST, 'question_dix_sept', FILTER_SANITIZE_STRING); 
                $question_dix_huit = filter_input(INPUT_POST, 'question_dix_huit', FILTER_SANITIZE_STRING); 
                $question_dix_neuf = filter_input(INPUT_POST, 'question_dix_neuf', FILTER_SANITIZE_STRING); 
                $question_vingt = filter_input(INPUT_POST, 'question_vingt', FILTER_SANITIZE_STRING);             
                $ctrl->creation_examen($choix_matiere,$intitule_examen,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$question_onze,$question_douze,$question_treize,$question_quatorze,$question_quinze,$question_seize,$question_dix_sept,$question_dix_huit,$question_dix_neuf,$question_vingt);
                break;   
            case 'enregistrement_creation_examen':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $intitule_examen = filter_input(INPUT_POST, 'un_examen', FILTER_SANITIZE_STRING);  
                $question_un = filter_input(INPUT_POST, 'question_un', FILTER_SANITIZE_STRING); 
                $question_deux = filter_input(INPUT_POST, 'question_deux', FILTER_SANITIZE_STRING); 
                $question_trois = filter_input(INPUT_POST, 'question_trois', FILTER_SANITIZE_STRING); 
                $question_quatre = filter_input(INPUT_POST, 'question_quatre', FILTER_SANITIZE_STRING); 
                $question_cinq = filter_input(INPUT_POST, 'question_cinq', FILTER_SANITIZE_STRING); 
                $question_six = filter_input(INPUT_POST, 'question_six', FILTER_SANITIZE_STRING); 
                $question_sept = filter_input(INPUT_POST, 'question_sept', FILTER_SANITIZE_STRING); 
                $question_huit = filter_input(INPUT_POST, 'question_huit', FILTER_SANITIZE_STRING); 
                $question_neuf = filter_input(INPUT_POST, 'question_neuf', FILTER_SANITIZE_STRING); 
                $question_dix = filter_input(INPUT_POST, 'question_dix', FILTER_SANITIZE_STRING); 
                $question_onze = filter_input(INPUT_POST, 'question_onze', FILTER_SANITIZE_STRING); 
                $question_douze = filter_input(INPUT_POST, 'question_douze', FILTER_SANITIZE_STRING); 
                $question_treize = filter_input(INPUT_POST, 'question_treize', FILTER_SANITIZE_STRING); 
                $question_quatorze = filter_input(INPUT_POST, 'question_quatorze', FILTER_SANITIZE_STRING); 
                $question_quinze = filter_input(INPUT_POST, 'question_quinze', FILTER_SANITIZE_STRING); 
                $question_seize = filter_input(INPUT_POST, 'question_seize', FILTER_SANITIZE_STRING); 
                $question_dix_sept = filter_input(INPUT_POST, 'question_dix_sept', FILTER_SANITIZE_STRING); 
                $question_dix_huit = filter_input(INPUT_POST, 'question_dix_huit', FILTER_SANITIZE_STRING); 
                $question_dix_neuf = filter_input(INPUT_POST, 'question_dix_neuf', FILTER_SANITIZE_STRING); 
                $question_vingt = filter_input(INPUT_POST, 'question_vingt', FILTER_SANITIZE_STRING);                 
                $ctrl->enregistrement_creation_examen($choix_matiere,$intitule_examen,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix,$question_onze,$question_douze,$question_treize,$question_quatorze,$question_quinze,$question_seize,$question_dix_sept,$question_dix_huit,$question_dix_neuf,$question_vingt);              
                break;               
            case 'creation_controle':
                $ctrl->creation_controle();
                break; 
            case 'creation_controle_cours':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);    
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);                    
                $intitule_controle = filter_input(INPUT_POST, 'un_controle', FILTER_SANITIZE_STRING);  
                $question_un = filter_input(INPUT_POST, 'question_un', FILTER_SANITIZE_STRING); 
                $question_deux = filter_input(INPUT_POST, 'question_deux', FILTER_SANITIZE_STRING); 
                $question_trois = filter_input(INPUT_POST, 'question_trois', FILTER_SANITIZE_STRING); 
                $question_quatre = filter_input(INPUT_POST, 'question_quatre', FILTER_SANITIZE_STRING); 
                $question_cinq = filter_input(INPUT_POST, 'question_cinq', FILTER_SANITIZE_STRING); 
                $question_six = filter_input(INPUT_POST, 'question_six', FILTER_SANITIZE_STRING); 
                $question_sept = filter_input(INPUT_POST, 'question_sept', FILTER_SANITIZE_STRING); 
                $question_huit = filter_input(INPUT_POST, 'question_huit', FILTER_SANITIZE_STRING); 
                $question_neuf = filter_input(INPUT_POST, 'question_neuf', FILTER_SANITIZE_STRING); 
                $question_dix = filter_input(INPUT_POST, 'question_dix', FILTER_SANITIZE_STRING);                         
                $ctrl->creation_controle_cours($choix_matiere,$choix_cours,$intitule_controle,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix);
                break;   
            case 'enregistrement_creation_controle':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);            
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $intitule_controle = filter_input(INPUT_POST, 'un_controle', FILTER_SANITIZE_STRING);  
                $question_un = filter_input(INPUT_POST, 'question_un', FILTER_SANITIZE_STRING); 
                $question_deux = filter_input(INPUT_POST, 'question_deux', FILTER_SANITIZE_STRING); 
                $question_trois = filter_input(INPUT_POST, 'question_trois', FILTER_SANITIZE_STRING); 
                $question_quatre = filter_input(INPUT_POST, 'question_quatre', FILTER_SANITIZE_STRING); 
                $question_cinq = filter_input(INPUT_POST, 'question_cinq', FILTER_SANITIZE_STRING); 
                $question_six = filter_input(INPUT_POST, 'question_six', FILTER_SANITIZE_STRING); 
                $question_sept = filter_input(INPUT_POST, 'question_sept', FILTER_SANITIZE_STRING); 
                $question_huit = filter_input(INPUT_POST, 'question_huit', FILTER_SANITIZE_STRING); 
                $question_neuf = filter_input(INPUT_POST, 'question_neuf', FILTER_SANITIZE_STRING); 
                $question_dix = filter_input(INPUT_POST, 'question_dix', FILTER_SANITIZE_STRING); 
                $ctrl->enregistrement_creation_controle($choix_matiere,$choix_cours,$intitule_controle,$question_un,$question_deux,$question_trois,$question_quatre,$question_cinq,$question_six,$question_sept,$question_huit,$question_neuf,$question_dix);              
                break;                                      
            case 'creation_exercice':
                $ctrl->creation_exercice();
                break;
            case 'creation_exercice_cours':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);  
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);            
                $ctrl->creation_exercice_cours($choix_matiere,$choix_cours);
                break;   
            case 'creation_exercice_chapitre':
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $choix_chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);                 
                $ctrl->creation_exercice_chapitre($choix_cours,$choix_chapitre);
                break;   
            case 'enregistrement_creation_exercice':
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $choix_chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);                
                $question_exercice = filter_input(INPUT_POST, 'un_exercice', FILTER_SANITIZE_STRING);  
                $ctrl->enregistrement_creation_exercice($choix_cours,$choix_chapitre,$question_exercice);              
                break;                                             
            case 'creation_qcm':
                $ctrl->creation_qcm();
                break; 
            case 'creation_qcm_cours':
                $choix_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);  
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);            
                $ctrl->creation_qcm_cours($choix_matiere,$choix_cours);
                break;   
            case 'creation_qcm_chapitre':
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);            
                $choix_chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);
                $question_un = filter_input(INPUT_POST, 'question_un', FILTER_SANITIZE_STRING); 
                $reponse_un_un = filter_input(INPUT_POST, 'reponse_un_un', FILTER_SANITIZE_STRING); 
                $etat_un_un = filter_input(INPUT_POST, 'etat_un_un', FILTER_SANITIZE_STRING); 
                $reponse_un_deux = filter_input(INPUT_POST, 'reponse_un_deux', FILTER_SANITIZE_STRING); 
                $etat_un_deux = filter_input(INPUT_POST, 'etat_un_deux', FILTER_SANITIZE_STRING); 
                $reponse_un_trois = filter_input(INPUT_POST, 'reponse_un_trois', FILTER_SANITIZE_STRING); 
                $etat_un_trois = filter_input(INPUT_POST, 'etat_un_trois', FILTER_SANITIZE_STRING); 
                $question_deux = filter_input(INPUT_POST, 'question_deux', FILTER_SANITIZE_STRING); 
                $reponse_deux_un = filter_input(INPUT_POST, 'reponse_deux_un', FILTER_SANITIZE_STRING); 
                $etat_deux_un = filter_input(INPUT_POST, 'etat_deux_un', FILTER_SANITIZE_STRING); 
                $reponse_deux_deux = filter_input(INPUT_POST, 'reponse_deux_deux', FILTER_SANITIZE_STRING); 
                $etat_deux_deux = filter_input(INPUT_POST, 'etat_deux_deux', FILTER_SANITIZE_STRING); 
                $reponse_deux_trois = filter_input(INPUT_POST, 'reponse_deux_trois', FILTER_SANITIZE_STRING); 
                $etat_deux_trois = filter_input(INPUT_POST, 'etat_deux_trois', FILTER_SANITIZE_STRING); 
                $question_trois = filter_input(INPUT_POST, 'question_trois', FILTER_SANITIZE_STRING); 
                $reponse_trois_un = filter_input(INPUT_POST, 'reponse_trois_un', FILTER_SANITIZE_STRING); 
                $etat_trois_un = filter_input(INPUT_POST, 'etat_trois_un', FILTER_SANITIZE_STRING); 
                $reponse_trois_deux = filter_input(INPUT_POST, 'reponse_trois_deux', FILTER_SANITIZE_STRING); 
                $etat_trois_deux = filter_input(INPUT_POST, 'etat_trois_deux', FILTER_SANITIZE_STRING); 
                $reponse_trois_trois = filter_input(INPUT_POST, 'reponse_trois_trois', FILTER_SANITIZE_STRING); 
                $etat_trois_trois = filter_input(INPUT_POST, 'etat_trois_trois', FILTER_SANITIZE_STRING); 
                $question_quatre = filter_input(INPUT_POST, 'question_quatre', FILTER_SANITIZE_STRING); 
                $reponse_quatre_un = filter_input(INPUT_POST, 'reponse_quatre_un', FILTER_SANITIZE_STRING); 
                $etat_quatre_un = filter_input(INPUT_POST, 'etat_quatre_un', FILTER_SANITIZE_STRING); 
                $reponse_quatre_deux = filter_input(INPUT_POST, 'reponse_quatre_deux', FILTER_SANITIZE_STRING); 
                $etat_quatre_deux = filter_input(INPUT_POST, 'etat_quatre_deux', FILTER_SANITIZE_STRING); 
                $reponse_quatre_trois = filter_input(INPUT_POST, 'reponse_quatre_trois', FILTER_SANITIZE_STRING); 
                $etat_quatre_trois = filter_input(INPUT_POST, 'etat_quatre_trois', FILTER_SANITIZE_STRING); 
                $question_cinq = filter_input(INPUT_POST, 'question_cinq', FILTER_SANITIZE_STRING); 
                $reponse_cinq_un = filter_input(INPUT_POST, 'reponse_cinq_un', FILTER_SANITIZE_STRING); 
                $etat_cinq_un = filter_input(INPUT_POST, 'etat_cinq_un', FILTER_SANITIZE_STRING); 
                $reponse_cinq_deux = filter_input(INPUT_POST, 'reponse_cinq_deux', FILTER_SANITIZE_STRING); 
                $etat_cinq_deux = filter_input(INPUT_POST, 'etat_cinq_deux', FILTER_SANITIZE_STRING); 
                $reponse_cinq_trois = filter_input(INPUT_POST, 'reponse_cinq_trois', FILTER_SANITIZE_STRING); 
                $etat_cinq_trois = filter_input(INPUT_POST, 'etat_cinq_trois', FILTER_SANITIZE_STRING);               
                $ctrl->creation_qcm_chapitre($choix_cours,$choix_chapitre,$question_un,$reponse_un_un,$etat_un_un,$reponse_un_deux,$etat_un_deux,$reponse_un_trois,$etat_un_trois,$question_deux,$reponse_deux_un,$etat_deux_un,$reponse_deux_deux,$etat_deux_deux,$reponse_deux_trois,$etat_deux_trois,$question_trois,$reponse_trois_un,$etat_trois_un,$reponse_trois_deux,$etat_trois_deux,$reponse_trois_trois,$etat_trois_trois,$question_quatre,$reponse_quatre_un,$etat_quatre_un,$reponse_quatre_deux,$etat_quatre_deux,$reponse_quatre_trois,$etat_quatre_trois,$question_cinq,$reponse_cinq_un,$etat_cinq_un,$reponse_cinq_deux,$etat_cinq_deux,$reponse_cinq_trois,$etat_cinq_trois);
                break;   
            case 'enregistrement_creation_qcm':
                $choix_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);            
                $choix_chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);
                $question_un = filter_input(INPUT_POST, 'question_un', FILTER_SANITIZE_STRING); 
                $reponse_un_un = filter_input(INPUT_POST, 'reponse_un_un', FILTER_SANITIZE_STRING); 
                $etat_un_un = filter_input(INPUT_POST, 'type_reponse_un_un', FILTER_SANITIZE_STRING); 
                $reponse_un_deux = filter_input(INPUT_POST, 'reponse_un_deux', FILTER_SANITIZE_STRING); 
                $etat_un_deux = filter_input(INPUT_POST, 'type_reponse_un_deux', FILTER_SANITIZE_STRING); 
                $reponse_un_trois = filter_input(INPUT_POST, 'reponse_un_trois', FILTER_SANITIZE_STRING); 
                $etat_un_trois = filter_input(INPUT_POST, 'type_reponse_un_trois', FILTER_SANITIZE_STRING); 
                $question_deux = filter_input(INPUT_POST, 'question_deux', FILTER_SANITIZE_STRING); 
                $reponse_deux_un = filter_input(INPUT_POST, 'reponse_deux_un', FILTER_SANITIZE_STRING); 
                $etat_deux_un = filter_input(INPUT_POST, 'type_reponse_deux_un', FILTER_SANITIZE_STRING); 
                $reponse_deux_deux = filter_input(INPUT_POST, 'reponse_deux_deux', FILTER_SANITIZE_STRING); 
                $etat_deux_deux = filter_input(INPUT_POST, 'type_reponse_deux_deux', FILTER_SANITIZE_STRING); 
                $reponse_deux_trois = filter_input(INPUT_POST, 'reponse_deux_trois', FILTER_SANITIZE_STRING); 
                $etat_deux_trois = filter_input(INPUT_POST, 'type_reponse_deux_trois', FILTER_SANITIZE_STRING); 
                $question_trois = filter_input(INPUT_POST, 'question_trois', FILTER_SANITIZE_STRING); 
                $reponse_trois_un = filter_input(INPUT_POST, 'reponse_trois_un', FILTER_SANITIZE_STRING); 
                $etat_trois_un = filter_input(INPUT_POST, 'type_reponse_trois_un', FILTER_SANITIZE_STRING); 
                $reponse_trois_deux = filter_input(INPUT_POST, 'reponse_trois_deux', FILTER_SANITIZE_STRING); 
                $etat_trois_deux = filter_input(INPUT_POST, 'type_reponse_trois_deux', FILTER_SANITIZE_STRING); 
                $reponse_trois_trois = filter_input(INPUT_POST, 'reponse_trois_trois', FILTER_SANITIZE_STRING); 
                $etat_trois_trois = filter_input(INPUT_POST, 'type_reponse_trois_trois', FILTER_SANITIZE_STRING); 
                $question_quatre = filter_input(INPUT_POST, 'question_quatre', FILTER_SANITIZE_STRING); 
                $reponse_quatre_un = filter_input(INPUT_POST, 'reponse_quatre_un', FILTER_SANITIZE_STRING); 
                $etat_quatre_un = filter_input(INPUT_POST, 'type_reponse_quatre_un', FILTER_SANITIZE_STRING); 
                $reponse_quatre_deux = filter_input(INPUT_POST, 'reponse_quatre_deux', FILTER_SANITIZE_STRING); 
                $etat_quatre_deux = filter_input(INPUT_POST, 'type_reponse_quatre_deux', FILTER_SANITIZE_STRING); 
                $reponse_quatre_trois = filter_input(INPUT_POST, 'reponse_quatre_trois', FILTER_SANITIZE_STRING); 
                $etat_quatre_trois = filter_input(INPUT_POST, 'type_reponse_quatre_trois', FILTER_SANITIZE_STRING); 
                $question_cinq = filter_input(INPUT_POST, 'question_cinq', FILTER_SANITIZE_STRING); 
                $reponse_cinq_un = filter_input(INPUT_POST, 'reponse_cinq_un', FILTER_SANITIZE_STRING); 
                $etat_cinq_un = filter_input(INPUT_POST, 'type_reponse_cinq_un', FILTER_SANITIZE_STRING); 
                $reponse_cinq_deux = filter_input(INPUT_POST, 'reponse_cinq_deux', FILTER_SANITIZE_STRING); 
                $etat_cinq_deux = filter_input(INPUT_POST, 'type_reponse_cinq_deux', FILTER_SANITIZE_STRING); 
                $reponse_cinq_trois = filter_input(INPUT_POST, 'reponse_cinq_trois', FILTER_SANITIZE_STRING); 
                $etat_cinq_trois = filter_input(INPUT_POST, 'type_reponse_cinq_trois', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_creation_qcm($choix_cours,$choix_chapitre,$question_un,$reponse_un_un,$etat_un_un,$reponse_un_deux,$etat_un_deux,$reponse_un_trois,$etat_un_trois,$question_deux,$reponse_deux_un,$etat_deux_un,$reponse_deux_deux,$etat_deux_deux,$reponse_deux_trois,$etat_deux_trois,$question_trois,$reponse_trois_un,$etat_trois_un,$reponse_trois_deux,$etat_trois_deux,$reponse_trois_trois,$etat_trois_trois,$question_quatre,$reponse_quatre_un,$etat_quatre_un,$reponse_quatre_deux,$etat_quatre_deux,$reponse_quatre_trois,$etat_quatre_trois,$question_cinq,$reponse_cinq_un,$etat_cinq_un,$reponse_cinq_deux,$etat_cinq_deux,$reponse_cinq_trois,$etat_cinq_trois);
                break;  
            case 'modification_contenu':
                $ctrl->modification_contenu();
                break; 
            case 'modification_matiere':
                $ctrl->modification_matiere();
                break;   
            case 'choisir_modification_matiere':
                $matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $ctrl->choisir_modification_matiere($matiere);
                break;   
            case 'enregistrement_modification_matiere':
                $id_matiere = filter_input(INPUT_POST, 'id_matiere', FILTER_SANITIZE_STRING);
                $nom_matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $etat = filter_input(INPUT_POST, 'etat', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_modification_matiere($id_matiere,$nom_matiere,$etat);
                break;                                  
            case 'modification_cours':
                $ctrl->modification_cours();
                break;   
            case 'choisir_modification_matiere_cours':
                $matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $ctrl->choisir_modification_matiere_cours($matiere);
                break;  
            case 'choisir_modification_cours':
                $cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $ctrl->choisir_modification_cours($cours);
                break;                                     
            case 'enregistrement_modification_cours':
                $id_cours = filter_input(INPUT_POST, 'id_cours', FILTER_SANITIZE_STRING);
                $nom_cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $etat = filter_input(INPUT_POST, 'etat', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_modification_cours($id_cours,$nom_cours,$etat);
                break;                 
            case 'modification_chapitre':
                $ctrl->modification_chapitre();
                break;
            case 'choisir_modification_matiere_chapitre':
                $matiere = filter_input(INPUT_POST, 'une_matiere', FILTER_SANITIZE_STRING);
                $cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $ctrl->choisir_modification_matiere_chapitre($matiere,$cours);
                break;  
            case 'choisir_modification_cours_chapitre':  
                $cours = filter_input(INPUT_POST, 'un_cours', FILTER_SANITIZE_STRING);
                $ctrl->choisir_modification_cours_chapitre($cours);
                break;  
            case 'choisir_modification_chapitre':  
                $chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);
                $ctrl->choisir_modification_chapitre($chapitre);
                break;                  
            case 'enregistrement_modification_chapitre':
                $id_chapitre = filter_input(INPUT_POST, 'id_chapitre', FILTER_SANITIZE_STRING);
                $nom_chapitre = filter_input(INPUT_POST, 'un_chapitre', FILTER_SANITIZE_STRING);  
                $url = filter_input(INPUT_POST, 'un_url', FILTER_SANITIZE_STRING);  
                $etat = filter_input(INPUT_POST, 'etat', FILTER_SANITIZE_STRING);
                $ctrl->enregistrement_modification_chapitre($id_chapitre,$nom_chapitre,$url,$etat);              
                break;                                                                                 
            default:
                throw new Exception("Action $task inconnue");           
        }
    }
//Récupération des erreurs	
} catch (Exception $e) {
    echo "Nous avons un sérieux problème :-( <br />" . $e->getMessage();
}
