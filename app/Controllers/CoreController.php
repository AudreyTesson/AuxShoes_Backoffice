<?php

namespace App\Controllers;

class CoreController
{
    /**
     * Constructeur : systématiquement et automatiqueent appelé
     * (à l'appel de la classe ou lors d'une nouvelle isntanciation)
     */
    public function __construct()
    {
       $acl = [
            'user-list' => ['admin', 'catalog-manager'],
            'user-add' => ['admin'],
            'user-create' => ['admin'],
            // ...
       ];
       
       global $match;
       $routeName = $match['name'];

       if (array_key_exists($routeName, $acl)) {
          $authorizedRoles = $acl[$routeName];
          //! OU  $authorizedRoles = $acl[$match['name']]; SI on SUPPR $routeName = $match['name']; plus haut

          $this->checkAuthorization($authorizedRoles);
       }
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     */
    protected function show(string $viewName, $viewData = [])
    {
        global $router;

        $viewData['currentPage'] = $viewName;

        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        extract($viewData);
        
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . "/../views/{$viewName}.tpl.php";
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    /**
     * Méthode "helper" qui sera appelée dans les Controllers
     * pour véfrifier si le user peut accéder à la page demandée
     *
     */
    protected function checkAuthorization($authorizedRoles = [])
    {
        if (isset($_SESSION['userId']))
        {
            $user = $_SESSION['userObject'];

            $role = $user->getRole();

            if (in_array($role, $authorizedRoles)) {
                return true;
            } else {
                http_response_code(403);
                exit();
            }

        } else {
            header('Location:/user/login');
            exit();
        }
    }
}
