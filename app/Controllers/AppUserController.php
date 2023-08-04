<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController
{
    public function login()
    {
        $this->show('user/login');
    }

    /**
     * Méthode pour ajouter un nouvel user
     *
     * @return void
     */
    public function addUser()
    {
        $this->show('user/user-add-update', [
            'user' => new AppUser(),
            'errors' => [],
        ]);
    }

    /**
     * Méthode pour le login
     *
     * @return void
     */
    public function loginUser()
    {
        if (!empty($_POST)) {

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            $user = AppUser::findByEmail($email);

            if ($user != false) {
                if (password_verify($password, $user->getPassword())) {

                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userObject'] = $user;
                    echo 'User id = ' . $_SESSION['userId'];

                    sleep(2);
                    header("Location: /");
                    exit();
                } else {
                    echo "Email et/ou mot de passe incorrects";
                }
            } else {
                echo "Email et/ou mot de passe incorrects";
            }
        } else {
            echo "Merci de renseigner les champs du formulaire";
        }
    }

    /**
     * Méthode qui récupère la liste de tous les users
     *
     * @return void
     */
    public function userList()
    {
        $this->checkAuthorization(['admin']);

        $users = AppUser::findAll();

        $this->show('/user/user-list', [
            'users' => $users
        ]);
    }

    /**
     * Créer ou modifier un utilisateur
     *
     * @param [int] null $userId
     * @return void
     */
    public function createOrUpdateUser($userId = null)
    {
        $isUpdate = isset($userId);

        if (!empty($_POST)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

            $errorList = [];

            empty($email) ? $errorList[] = 'Merci de renseigner votre email' : null;
            $email === false ? $errorList[] = 'Merci de renseigner une adresse email valide' : null;
            empty($password) ? $errorList[] = 'Merci de renseigner votre password' : null;
            $password === false ? $errorList[] = 'Merci de renseigner un password valide' : null;
            empty($firstname) ? $errorList[] = 'Merci de renseigner votre prénom' : null;
            $firstname === false ? $errorList[] = 'Merci de renseigner un prénom valide' : null;
            empty($lastname) ? $errorList[] = 'Merci de renseigner votre nom' : null;
            $lastname === false ? $errorList[] = 'Merci de renseigner un nom valide' : null;
            empty($role) ? $errorList[] = 'Merci de renseigner un role' : null;
            $role === false ? $errorList[] = 'Merci de renseigner un role valide' : null;
            empty($status) ? $errorList[] = 'Merci de renseigner le statut' : null;
            $status === false ? $errorList[] = 'Merci de renseigner un statut valide' : null;

            if (empty($errorList)) {
                if ($isUpdate) {
                    $modelUser = AppUser::find($userId);
                } else {
                    $modelUser = new AppUser();
                }

                $modelUser->setEmail($email);
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $modelUser->setPassword($hashedPassword);
                // OU NINJA
                // $modelUser->setPassword(password_hash($password, PASSWORD_BCRYPT));
                $modelUser->setFirstname($firstname);
                $modelUser->setLastname($lastname);
                $modelUser->setRole($role);
                $modelUser->setStatus($status);

                if ($isUpdate) {
                    $isUpdateOk = $modelUser->update();

                    if ($isUpdateOk) {
                        header("Location: /user/add-update/{$userId}");
                    } else {
                        $errorList[] = "La modification de l'utilisateur a échoué";
                    }
                } else {
                    $isInsertOk = $modelUser->insert();

                    if ($isInsertOk) {
                        header("Location: /user/user-list");
                    } else {
                        $errorList[] = "La création de l'utilisateur a échoué";
                    }
                }
            } else {
                $modelUser = new AppUser();

                $modelUser->setEmail($email);
                $modelUser->setPassword(password_hash($password, PASSWORD_BCRYPT));
                $modelUser->setFirstname($firstname);
                $modelUser->setLastname($lastname);
                $modelUser->setRole($role);
                $modelUser->setStatus($status);

                $this->show('user/user-add-update', [
                    'user' => $modelUser,
                    'errors' => $errorList
                ]);
            }
        }
    }

    /**
     * Méthode pour éditer un user
     *
     * @param [type] $userId
     * @return void
     */
    public function editUser($userId)
    {
        $user = AppUser::find($userId);

        $this->show('user/user-add-update', [
            'user' => $user,
            'userId' => $userId
        ]);
    }

    /**
     * Méthode pour se déconnecter et rediriger vers la page de login
     *
     * @return void
     */
    public function logoutUser()
    {
        $userLogout = new AppUser();

        $userLogout->logout();

        sleep(3);

        header("Location: /user/login");

        exit();
    }
}
