<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Product extends CoreModel
{

//? #Region "private / getter / setter"
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

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
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }
//? #End Region

    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public static function find($productId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $productId;

        $pdoStatement = $pdo->query($sql);

        return $pdoStatement->fetchObject(Product::class);
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, Product::class);
    }

     /**
     * Récupérer les 5 produits mises en avant sur la home
     *
     * @return Product[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM `product`
            ORDER BY `id`
            LIMIT 5
        ';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, Product::class);
    }

        /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public static function insert()
    {
        $pdo = Database::getPDO();

        $sql = '
            INSERT INTO `product`
            (`name`, `description`, `picture`, `price`, `rate`, `status`, `category_id`, `brand_id`, `type_id`)
            VALUES (:name, :description, :picture, :price, :rate, :status, :category_id, :brand_id, :type_id)
        ';

        $query = $pdo->prepare($sql);

        $query->execute([
            ':name' => self::$name,
            ':description' => self::$description,
            ':picture' => self::$picture,
            ':price' => self::$price,
            ':rate' => self::$rate,
            ':status' => self::$status,
            ':category_id' => self::$category_id,
            ':brand_id' => self::$brand_id,
            ':type_id' => self::$type_id,
        ]);

   
        if ($query->rowCount() > 0) {
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
            UPDATE `product` 
            (`name`, `description`, `picture`, `price`, `rate`, `status`, `category_id`, `brand_id`, `type_id`)
            SET
                name = (:name),
                description = (:description),
                picture = (:picture),
                price = (:price),
                rate = (:rate),
                status = (:status),
                category_id = (:category_id),
                brand_id = (:brand_id),
                type_id = (:type_id),
                updated_at = NOW()
            WHERE id = :productId
        ";

        $updatedRows = $pdo->prepare($sql);

        $updatedRows->bindValue(":name",self::$name,PDO::PARAM_STR);
        $updatedRows->bindValue(":description",self::$description,PDO::PARAM_STR);
        $updatedRows->bindValue(":picture", self::$picture,PDO::PARAM_STR);
        $updatedRows->bindValue(":price",self::$price,PDO::PARAM_STR);
        $updatedRows->bindValue(":rate",self::$rate,PDO::PARAM_STR);
        $updatedRows->bindValue(":status",self::$status,PDO::PARAM_STR);
        $updatedRows->bindValue(":category_id",self::$category_id,PDO::PARAM_STR);
        $updatedRows->bindValue(":brand_id",self::$brand_id,PDO::PARAM_STR);
        $updatedRows->bindValue(":type_id",self::$type_id,PDO::PARAM_STR);
        $updatedRows->bindValue(":productId",self::$id,PDO::PARAM_INT);
        $updatedRows->execute();

        //! return ($updatedRows > 0);
        if ($updatedRows > 0) {
            self::$id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }
}
