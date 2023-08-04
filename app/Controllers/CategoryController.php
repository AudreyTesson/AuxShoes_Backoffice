<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * Méthode qui esrt exécutée pour l'affichage de toutes les cartégories du site
     *
     * @return void
     */
    public function listCategories()
    {
        $categories = Category::findAll();

        $this->show('category/category-list', [
            'categories' => $categories
        ]);

    }

    /**
     * Méthode pour afficher le formulaire d'ajout d'une nouvelle catégorie
     *
     * @return void
     */
    public function addCategory()
    {
        $this->show('category/category-add-update', [
            'category' => new Category()
        ]);
    }

    /**
     * Méthode pour mettre à jour une catégorie (existante)
     *
     * @return void
     */
    public function editCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $this->show('category/category-add-update', [
            'category' => $category,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * Créer ou modifier en BDD une catégorie
     *
     * @param int | null $categoryId
     * @return void
     */
    public function createOrUpdateCategory($categoryId = null)
    {
        $isUpdate = isset($categoryId);

        if (!empty($_POST)) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);

            $errorList = [];

            if (empty($name)) {
                $errorList[] = 'Merci de renseigner le nom de la catégorie';
            }

            if ($name === false) {
                $errorList[] = 'Merci de renseigner un nom valide';
            }

            //! TERNAIRE
            //! empty($name) ? $errorList[] = 'Merci de renseigner le nom de la catégorie' : null;
            //! $name === false ? $errorList[] = 'Merci de renseigner un nom valide' : null;

            if (empty($subtitle)) {
                $errorList[] = 'Merci de renseigner le sous-titre de la catégorie';
            }

            if ($subtitle === false) {
                $errorList[] = 'Merci de renseigner un sous-titre valide';
            }

            if (empty($picture)) {
                $errorList[] = 'Merci de renseigner l\'image de la catégorie';
            }

            if ($picture === false) {
                $errorList[] = 'Merci de renseigner une image valide';
            }

            if (empty($errorList)) {
                if ($isUpdate) {
                    $modelCategory = Category::find($categoryId);
                } else {
                    $modelCategory = new Category();
                }

                $modelCategory->setName($name);
                $modelCategory->setSubtitle($subtitle);
                $modelCategory->setPicture($picture);

                if ($isUpdate) {
                    $isUpdateOk = $modelCategory->update();

                    if ($isUpdateOk) {
                        header("Location: /category/add-update/{$categoryId}");
                    } else {
                        $errorList[] = 'La modification de la catégorie a échoué';
                    }
                } else {
                    $isInsertOk = $modelCategory->insert();
                    
                    if ($isInsertOk) {
                        header('Location: /category/list');
                    } else {
                        $errorList[] = 'La création de la catégorie a échoué';
                    }
                }

            } else {
                $modelCategory = new Category();

                $modelCategory->setName($name);
                $modelCategory->setSubtitle($subtitle);
                $modelCategory->setPicture($picture);

                $this->show('category/category-add-update', [
                    'category' => $modelCategory,
                    'errors' => $errorList
                ]);

            }
        }
    }

    public function homeCategory()
    {     
        $categories = Category::findAllHomepage();
        $this->show('category/category-home', [
            'categories' => $categories
        ]);
    }

    public function updateOrderCategory()
    {
        if (!empty($_POST)) {
            $home_order = filter_input(INPUT_POST, 'home_order', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if(!empty($home_order)) {
                foreach ($home_order as $order => $categoryId) {
                    Category::orderCategory($categoryId, $order);
                }
                header('Location: /category/home');
                exit();
            }
        }
        header('Location: /category/home');
        exit();
    }
}