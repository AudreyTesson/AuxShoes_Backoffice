<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Type extends CoreModel
{

//? #Region "private / getter / setter"
    /**
     * @var string
     */
    private $name;


    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
//? #End Region

    /**
     * Méthode permettant de récupérer un enregistrement de la table Type en fonction d'un id donné
     *
     * @param int $typeId ID du type
     * @return Type
     */
    public static function find($typeId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `type` WHERE `id` =' . $typeId;

        $pdoStatement = $pdo->query($sql);

        return $pdoStatement->fetchObject(Type::class);
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table type
     *
     * @return Type[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `type`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, Type::class);
    }

        /**
     * Méthode permettant d'ajouter un enregistrement dans la table brand
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public static function insert()
    {
        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `type` (name)
            VALUES ('{self::name}')
        ";

        $insertedRows = $pdo->exec($sql);

        if ($insertedRows > 0) {
            self::$id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table brand
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public static function update()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE `type`
            SET
                name = '{self::name}',
                updated_at = NOW()
            WHERE id = {self::id}
        ";

        $updatedRows = $pdo->exec($sql);

        return ($updatedRows > 0);
    }
}
