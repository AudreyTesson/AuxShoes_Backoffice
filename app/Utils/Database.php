<?php

namespace App\Utils;

use PDO;

class Database
{
    /**
     * Objet PDO représentant la connexion à la base de données
     *
     * @var PDO
     */
    private $dbh;
    /**
     * Propriété statique (liée à la classe) stockant l'unique instance objet
     *
     * @var Database
     */
    private static $instance;

    /**
     * Constructeur
     *
     * en visibilité private
     * => seul le code de la classe a le droit de créer une instance de cette classe
     */
    private function __construct()
    {
        $configData = parse_ini_file(__DIR__ . '/../config.ini');

        try {
            $this->dbh = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) // Affiche les erreurs SQL à l'écran
            );
        } catch (\Exception $exception) {
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage() . '<br>';
            echo '<pre>';
            echo $exception->getTraceAsString();
            echo '</pre>';
            exit;
        }
    }

    /**
     * Méthode permettant de retourner, dans tous les cas,
     * la propriété dbh (objet PDO) de l'unique instance de Database
     *
     * @return PDO
     */
    public static function getPDO()
    {
        if (empty(self::$instance)) {
            self::$instance = new Database();
        }
        
        return self::$instance->dbh;
    }
}
