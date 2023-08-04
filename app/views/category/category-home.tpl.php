<?php
// dump($_POST['home_order']);
?>

<form action="" method="POST" class="mt-5">
    <div class="row">
        <?php for ($i = 1; $i <= 5; $i++) : ?>
            <div class="col">
            <div class="form-group">
                <label for="home_order<?= $i ?>">Emplacement #<?= $i ?></label>
                <select class="form-control" id="home_order<?= $i ?>" name="home_order[<?= $i ?>]">
                    <option value="">choisissez :</option>
                    <option value="1"<?php $i == 2 ? 'selected' : '' ?>>Détente</option>
                    <option value="2"<?php $i == 1 ? 'selected' : '' ?>>Au travail</option>
                    <option value="3"<?php $i == 5 ? 'selected' : '' ?>>Cérémonie</option>
                    <option value="4"<?php $i == 3 ? 'selected' : '' ?>>Sortir</option>
                    <option value="5"<?php $i == 4 ? 'selected' : '' ?>>Vintage</option>
                </select>
            </div>
        </div>
        <?php endfor; ?>

        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </div>
</form>
