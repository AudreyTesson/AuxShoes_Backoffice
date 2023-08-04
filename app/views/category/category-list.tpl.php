    <div class="container my-4">
        <a href="<?= $router->generate('category-add') ?>" class="btn btn-success float-end">Ajouter</a>
        <h2>Liste des catégories</h2>
        <?php //dump($viewData); ?>
        <?php //dump($categories); ?>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Sous-titre</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $category) : ?>
                <tr>
                    <th scope="row"><?= $category->getId() ?></th>
                    <td><?= $category->getName() ?></td>
                    <td><?= $category->getSubtitle() ?></td>
                    <td><img src="<?= $category->getPicture() ?>" alt="<?= $category->getName() ?>" class="thumbnail w-25"></td>
                    
                    <td class="text-end">
                        <a href="<?= $router->generate('category-edit', ['id' => $category->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
