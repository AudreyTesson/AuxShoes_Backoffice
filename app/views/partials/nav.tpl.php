<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">AuxShoes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

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
                    <a class="nav-link" href="<?= $router->generate('category-home') ?>">Sélection Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('user-list') ?>">Utilisateurs</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="navbar-nav ml-auto action-buttons">
        <div class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="<?= $router->generate('user-login') ?>" class="nav-link mr-4">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('user-logout') ?>">Déconnexion</a>
            </li>
        </div>
    </ul>
</nav>