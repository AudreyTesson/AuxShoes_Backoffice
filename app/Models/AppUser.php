<?php

namespace App\Models;

use App\Utils\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

class AppUser extends CoreModel
{

//? #Region "private / getter / setter"
    private $email;

    private $password;

    private $firstname;

    private $lastname;

    private $role;

    private $status;

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
//? #End Region

    public static function find($userId)
    {
        $pdo = Database::getPDO();

        $sql = "SELECT * FROM `app_user` WHERE `id` = {$userId}";

        $pdoStatement = $pdo->query($sql);
        
        return $pdoStatement->fetchObject(AppUser::class);
    }

    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();

        $sql = "
            SELECT * FROM `app_user`
            WHERE `email` = :email
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([':email' => $email]);

        $user = $pdoStatement->fetchObject(AppUser::class);

        return ($user) ? $user : false;
    }

    public static function findAll()
    {
        $pdo = Database::getPDO();

        $pdoStatement = $pdo->query('SELECT * FROM `app_user`');

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);
    }
    
    /**
     * Méthode permettant d'ajouter un enregistrement dans la table app_user
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     * @return void
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = '
            INSERT INTO `app_user`
            (`email`, `password`, `firstname`, `lastname`, `role`, `status`)
            VALUES (:email, :password, :firstname, :lastname, :role, :status)
        ';

        $query = $pdo->prepare($sql);

        $query->execute([
            ':email' => $this->email,
            ':password' => $this->password,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':role' => $this->role,
            ':status' => $this->status,
        ]);

        if ($query->rowCount() > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }

        return false;
    }

    public static function update()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE `app_user`
            SET
            email = :email,
            password = :password,
            firstname = :firstname,
            lastname = :lastname,
            role = :role,
            status = :status,
            updated_at = NOW()
            WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', self::$email);
        $pdoStatement->bindValue(':password', self::$password);
        $pdoStatement->bindValue(':firstname', self::$firstname);
        $pdoStatement->bindValue(':lastname', self::$lastname);
        $pdoStatement->bindValue(':role', self::$role);
        $pdoStatement->bindValue(':status', self::$status);
        $pdoStatement->bindValue(':id', self::$id, PDO::PARAM_INT);

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

      $sql = "DELETE FROM `app_user` WHERE id = :id";

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

    public function logout()
    {
        session_destroy();
    }
}
