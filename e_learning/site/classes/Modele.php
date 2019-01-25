<?php
abstract class Modele {

    static private $connexion = NULL;

    static protected function getConnexion() {
        if (!isset(self::$connexion)) {
            include dirname(__FILE__) . '../../configuration.php';
            self::$connexion = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        }
        return self::$connexion;
    }

}
