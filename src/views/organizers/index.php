<?php include '../views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Liste des Organisateurs</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Département</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($organizers as $organizer): ?>
                            <tr>
                                <td><?= htmlspecialchars($organizer['first_name'] . ' ' . $organizer['last_name']); ?></td>
                                <td><?= htmlspecialchars($organizer['email']); ?></td>
                                <td><?= htmlspecialchars($organizer['phone']); ?></td>
                                <td><?= htmlspecialchars($organizer['department']); ?></td>
                                <td><?= ucfirst($organizer['role']); ?></td>
                                <td>
                                    <a href="<?= BASE_URL; ?>/organizers/<?= $organizer['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>