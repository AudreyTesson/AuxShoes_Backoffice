<?php

use App\Controllers\AppUserController;
use App\Controllers\CategoryController;
use App\Controllers\ProductController;

require_once '../vendor/autoload.php';

session_start();

$router = new AltoRouter();

if (array_key_exists('BASE_URI', $_SERVER)) {
    $router->setBasePath($_SERVER['BASE_URI']);
} else { 
    $_SERVER['BASE_URI'] = '/';
}

$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);


//? #Region "Category"

    $router->map(
        'GET',
        '/category/home',
        [
            'method' => 'homeCategory',
            'controller' => CategoryController::class
        ],
        'category-home'
    );

    $router->map(
        'POST',
        '/category/home',
        [
            'method' => 'updateOrderCategory',
            'controller' => CategoryController::class
        ],
        'category-choice'
    );

    $router->map(
        'GET',
        '/category/list',
        [
            'method' => 'listCategories',
            'controller' => CategoryController::class
        ],
        'category-list'
    );

    $router->map(
        'GET',
        '/category/add-update',
        [
            'method' => 'addCategory',
            'controller' => CategoryController::class
        ],
        'category-add'
    );

    $router->map(
        'POST',
        '/category/add-update',
        [
            'method' => 'createOrUpdateCategory',
            'controller' => CategoryController::class
        ],
        'category-create'
    );

    $router->map(
        'GET',
        '/category/add-update/[i:id]',
        [
            'method' => 'editCategory',
            'controller' => CategoryController::class
        ],
        'category-edit'
    );

    $router->map(
        'POST',
        '/category/add-update/[i:id]',
        [
            'method' => 'createOrUpdateCategory',
            'controller' => CategoryController::class
        ],
        'category-update'
    );

    $router->map(
        'GET',
        '/category/[i:id]/delete',
        [
        'method' => 'delete',
        'controller' => CategoryController::class
        ],
        'category-delete'
    );
//? #End Region

//? #Region "Product"
    $router->map(
        'GET',
        '/product/list',
        [
            'method' => 'listProducts',
            'controller' => ProductController::class
        ],
        'product-list'
    );

    $router->map(
        'GET',
        '/product/add-update',
        [
            'method' => 'addProduct',
            'controller' => ProductController::class
        ],
        'product-add'
    );

    $router->map(
        'POST',
        '/product/add-update',
        [
            'method' => 'createOrUpdateProduct',
            'controller' => ProductController::class
        ],
        'product-create'
    );

    $router->map(
        'GET',
        '/product/add-update/[i:id]',
        [
            'method' => 'editProduct',
            'controller' => ProductController::class
        ],
        'product-edit'
    );

    $router->map(
        'POST',
        '/product/add-update/[i:id]',
        [
            'method' => 'createOrUpdateProduct',
            'controller' => ProductController::class
        ],
        'product-update'
    );

    $router->map(
        'GET',
        '/product/[i:id]/delete',
        [
        'method' => 'delete',
        'controller' => ProductController::class
        ],
        'product-delete'
    );
//? #End Region

//? #Region "User"
    $router->map(
        'GET',
        '/user/login',
        [
            'method' => 'login',
            'controller' => AppUserController::class
        ],
        'user-login'
    );

    $router->map(
        'POST',
        '/user/login',
        [
            'method' => 'loginUser',
            'controller' => AppUserController::class
        ],
        'user-check'
    );

    $router->map(
        'GET',
        '/user/user-list',
        [
            'method' => 'userList',
            'controller' => AppUserController::class
        ],
        'user-list'
    );

    $router->map(
        'GET',
        '/user/add-update',
        [
            'method' => 'addUser',
            'controller' => AppUserController::class
        ],
        'user-add'
    );

    $router->map(
        'POST',
        '/user/add-update',
        [
            'method' => 'createOrUpdateUser',
            'controller' => AppUserController::class
        ],
        'user-create'
    );

    $router->map(
        'GET',
        '/user/add-update/[i:id]',
        [
            'method' => 'editUser',
            'controller' => AppUserController::class
        ],
        'user-edit'
    );

    $router->map(
        'GET',
        '/user/add-update/[i:id]',
        [
            'method' => 'createOrUpdateUser',
            'controller' => AppUserController::class
        ],
        'user-update'
    );

    $router->map(
        'GET',
        '/user/logout',
        [
            'method' => 'logoutUser',
            'controller' => AppUserController::class
        ],
        'user-logout'
    );
//? #End Region

$match = $router->match();

$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

$dispatcher->dispatch();
