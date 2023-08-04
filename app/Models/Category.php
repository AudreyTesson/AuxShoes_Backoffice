<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

//? #Region "private / getter / setter"
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

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

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

        /**
     * Set the value of home_order
     *
     * @param  int  $home_order
     *
     * @return  self
     */ 
    public function setHome_order(int $home_order)
    {
        $this->home_order = $home_order;

        return $this;
    }
    
//? #End Region

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        $pdoStatement = $pdo->query($sql);

        return $pdoStatement->fetchObject(Category::class);

    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, Category::class);
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM `category`
            WHERE `home_order` > 0
            ORDER BY `home_order` ASC
            LIMIT 5
        ';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, Category::class);
    }

    
     /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = '
            INSERT INTO `category`
            (`name`, `subtitle`, `picture`)
            VALUES (:name, :subtitle, :picture)
        ';

        $query = $pdo->prepare($sql);

        $query->execute([
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

        if ($query->rowCount() > 0) {
            $this->id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }

    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE `category`
            SET
            name = :name,
            subtitle = :subtitle,
            picture = :picture,
            updated_at = NOW()
            WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name);
        $pdoStatement->bindValue(':subtitle', $this->subtitle);
        $pdoStatement->bindValue(':picture', $this->picture);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $pdoStatement->execute();

        if ($pdoStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

        //! Version plus courte
        //! retourne true si la condition est vraie, sinon false
        //! return ($pdoStatement->rowCount() > 0);
    }

    /**
     * Méthode qui supprime un enregistrement de la table
     *
     * @return bool
     */
    public function delete()
    {
      $pdo = Database::getPDO();

      $sql = "DELETE * FROM `category` WHERE id = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->execute([
        ":id" => $this->id
      ]);

      if($pdoStatement->rowCount() > 0)
      {
        return true;
      }
      else
      {
        return false;
      }

      return $pdoStatement->rowCount() > 0;
    }

        /**
     * Pour définir l'ordre d'affichage des catégories sur la homepage
     *
     * @param integer $categoryId
     * @param integer $home_order
     *
     */
    
     public static function orderCategory($categoryId, $home_order)
    {
        $pdo = Database::getPDO();

        $sql ='UPDATE `category` 
            SET `home_order` = :home_order 
            WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([
            'home_order' => $home_order,
            'id' => $categoryId
        ]);
    }
}
