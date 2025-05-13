<?php include '../views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Détails de l'organisateur</h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nom:</strong> <?= htmlspecialchars($organizer['first_name'] . ' ' . $organizer['last_name']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($organizer['email']); ?></p>
                    <p><strong>Nom d'utilisateur:</strong> <?= htmlspecialchars($organizer['username']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($organizer['phone']); ?></p>
                    <p><strong>Département:</strong> <?= htmlspecialchars($organizer['department']); ?></p>
                    <p><strong>Rôle:</strong> <?= ucfirst($organizer['role']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="<?= BASE_URL; ?>/organizers" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>