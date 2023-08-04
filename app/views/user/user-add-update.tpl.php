<div class="container my-4">
        <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>

        <?php if (empty($userId)) : ?>
            <h2>Ajouter un utilisateur</h2>
        <?php else : ?>
            <h2>Modifier un utilisateur</h2>
        <?php endif; ?>

        <h3>
            <ul>
                <!-- On boucle sur $errors, array d'erreurs transmis par show() -->
                <!-- On doit vérifier que $errors existe et contient bien quelque chose -->
                <?php if (isset($viewData['$errors'])) : ?>
                    <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </h3>
    
        <form action="" method="POST" class="mt-5">
        <div class="mb-3">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Veuillez saisir votre prénom" aria-describedby="firstnameHelpBlock" value="<?= $user->getFirstname() ?>">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Veuillez saisir votre nom" aria-describedby="lastnameHelpBlock" value="<?= $user->getLastname() ?>">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Veuillez enregisterr votre email" value="<?= $user->getEmail() ?>" required>
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Mot de Passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Veuillez enregistrer votre mot de passe" aria-describedby="passwordHelpBlock" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" required>
                    <option value="catalog-manager" <?= $user->getRole() === 'catalog-manager' ? 'selected' : '' ?>>catalog-manager</option>
                    <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">statut</label>
                <select name="status" id="status" required>
                    <option value="1" <?= $user->getStatus() === 1 ? 'selected' : '' ?>>Actif</option>
                    <option value="2" <?= $user->getStatus() === 2 ? 'selected' : '' ?>>Inactif</option>
                </select>
            </div>
            <!-- <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select name="role" id="role" value="<?= $user->getRole() ?>" required>
                    <option value="admin">Admin</option>
                    <option value="catalog-manager">Catalog-manager</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" value="<?= $user->getStatus() ?>" required>
                    <option value="-">-</option>
                    <option value="1">Actif</option>
                    <option value="2">Désactivé</option>
                </select>
            </div> -->

            <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary"><?= empty($userId) ? 'Ajouter' : 'Modifier' ?></button>
            </div>
        </form>
    </div>
