<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     */
    public function home()
    {
        $categories = Category::findAllHomepage();

        $products = Product::findAllHomepage();

        $this->show('main/home', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
