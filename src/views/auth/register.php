<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Inscription</h2>
                <form method="POST" action="<?= BASE_URL; ?>/auth/register">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe (8 caractères minimum)</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">S'inscrire</button>
                    </div>
                </form>
                <p class="mt-3 text-center">
                    Déjà inscrit ? <a href="<?= BASE_URL; ?>/auth/login">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
