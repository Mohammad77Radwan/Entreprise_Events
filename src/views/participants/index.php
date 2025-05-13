<?php include '../views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Liste des Participants</h1>

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $participant): ?>
                            <tr>
                                <td><?= htmlspecialchars($participant['first_name'] . ' ' . $participant['last_name']); ?></td>
                                <td><?= htmlspecialchars($participant['email']); ?></td>
                                <td><?= htmlspecialchars($participant['phone']); ?></td>
                                <td><?= htmlspecialchars($participant['department']); ?></td>
                                <td>
                                    <a href="<?= BASE_URL; ?>/participants/<?= $participant['id']; ?>" class="btn btn-sm btn-info">
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