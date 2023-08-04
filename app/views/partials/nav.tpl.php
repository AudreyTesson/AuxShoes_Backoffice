<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">oShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- <?php //dump($currentPage); 
                ?> -->

        <!-- Bonus : gestion de la classe active -->
        <!-- Plusieurs manières de faire -->
        <!-- Copyright Christelle -->
        <!-- <a class="nav-link <?php // echo $viewName === "main/home" ? "active" : ""
                                ?>" href="<?php // echo $router->generate('main-home') 
                                                                                                    ?>"> -->

        <!-- Copyright Erwann -->
        <?php //echo (strpos($currentPage, 'product') !== false) ? "active" : ""; 
        ?>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $viewName === "main/home" ? "active" : "" ?>" href="<?= $router->generate('main-home') ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $viewName === "category/list" ? "active" : "" ?>" href="<?= $router->generate('category-list') ?>">Catégories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('product-list') ?>">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Types</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Marques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tags</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('category-home') ?>">Sélection Accueil</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="navbar-nav ml-auto action-buttons">
        <div class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('user-list') ?>">Utilisateurs</a>
            </li>
            <li class="nav-item">
                <a href="<?= $router->generate('user-login') ?>" class="nav-link mr-4">Connection</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('user-logout') ?>">Déconnection</a>
            </li>
        </div>
    </ul>
</nav>