<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;

class ProductController extends CoreController
{
    public function listProducts()
    {
        $this->checkAuthorization(['admin']);

        $products = Product::findAll();

        $this->show('product/product-list', [
            'products' => $products
        ]);
    }

    public function addProduct()
    {
        $modelBrand = new Brand();
        $brands = $modelBrand->findAll();

        $modelCategory = new Category();
        $categories = $modelCategory->findAll();

        $modelType = new Type();
        $types = $modelType->findAll();

        $this->show('product/product-add-update', [
            'brands' => $brands,
            'categories' => $categories,
            'types' => $types,
            'product' => new Product()
        ]);
    }

    public function createOrUpdateProduct($productId = null)
    {
        $this->checkAuthorization(['admin']);

        $isUpdate = isset($productId);

        if (!empty($_POST)) {

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
            $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_NUMBER_INT);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_SANITIZE_NUMBER_INT);
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);

            $errorList = [];

            if (empty($name)) {
                $errorList[] = 'Merci de renseigner le nom du produit';
            }

            if ($name === false) {
                $errorList[] = 'Merci de renseigner un nom valide';
            }

            if (empty($description)) {
                $errorList[] = 'Merci de renseigner la description du produit';
            }

            if ($description === false) {
                $errorList[] = 'Merci de renseigner une description valide';
            }

            if (empty($picture)) {
                $errorList[] = 'Merci de renseigner l\'image du produit';
            }

            if ($picture === false) {
                $errorList[] = 'Merci de renseigner une image valide';
            }

            if (empty($price)) {
                $errorList[] = 'Merci de renseigner le prix du produit';
            }

            if ($price === false) {
                $errorList[] = 'Merci de renseigner un prix valide';
            }

            if (empty($rate)) {
                $errorList[] = 'Merci de renseigner la note du produit';
            }

            if ($rate === false) {
                $errorList[] = 'Merci de renseigner une note valide';
            }

            if (empty($status)) {
                $errorList[] = 'Merci de renseigner le statut du produit';
            }

            if ($status === false) {
                $errorList[] = 'Merci de renseigner un statut valide';
            }

            if (empty($category_id)) {
                $errorList[] = 'Merci de renseigner la catégorie du produit';
            }

            if ($category_id === false) {
                $errorList[] = 'Merci de renseigner une catégorie valide';
            }

            if (empty($type_id)) {
                $errorList[] = 'Merci de renseigner le type du produit';
            }

            if ($type_id === false) {
                $errorList[] = 'Merci de renseigner un type valide';
            }

            if (empty($brand_id)) {
                $errorList[] = 'Merci de renseigner la marque du produit';
            }

            if ($brand_id === false) {
                $errorList[] = 'Merci de renseigner une marque valide';
            }


            if (empty($errorList)) {
                if ($isUpdate) {
                    $modelProduct = Product::find($productId);
                } else {
                    $modelProduct = new Product();
                }

                $modelProduct->setName($name);
                $modelProduct->setDescription($description);
                $modelProduct->setPicture($picture);
                $modelProduct->setPrice($price);
                $modelProduct->setRate($rate);
                $modelProduct->setStatus($status);
                $modelProduct->setCategoryId($category_id);
                $modelProduct->setBrandId($brand_id);
                $modelProduct->setTypeId($type_id);

                if ($isUpdate) {
                    $isUpdateOK = $modelProduct->update();

                    if ($isUpdateOK) {
                        header("location: /product/add-update/{$productId}");
                    } else {
                        $errorList[] = "La modification du produit a échouée";
                    }
                } else {

                }

                $isInsert = $modelProduct->insert();

                if ($isInsert) { 
                    header('Location: /product/list');
                } else {

                    $errorList[] = 'La création du produit a échoué';
                }
            } else {

                $modelProduct = new Product();

                $modelProduct->setName($name);
                $modelProduct->setDescription($description);
                $modelProduct->setPicture($picture);
                $modelProduct->setPrice($price);
                $modelProduct->setRate($rate);
                $modelProduct->setStatus($status);
                $modelProduct->setCategoryId($category_id);
                $modelProduct->setBrandId($brand_id);
                $modelProduct->setTypeId($type_id);

                $this->show('product/product-add-update', [
                    'product' => $modelProduct,
                    'errors' => $errorList
                ]);

            }
        }
    }

    public function editProduct($productId)
    {
        $this->checkAuthorization(['admin']);

        $product = Product::find($productId);
        $this->show('product/product-add-update', [
            'product' => $product,
            'productId' => $productId
        ]);
    }
}