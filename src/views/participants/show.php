<?php include '../views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Détails du Participant</h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nom:</strong> <?= htmlspecialchars($participant['first_name'] . ' ' . $participant['last_name']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($participant['email']); ?></p>
                    <p><strong>Nom d'utilisateur:</strong> <?= htmlspecialchars($participant['username']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($participant['phone']); ?></p>
                    <p><strong>Département:</strong> <?= htmlspecialchars($participant['department']); ?></p>
                    <p><strong>Rôle:</strong> <?= ucfirst($participant['role']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Événements réservés (<?= count($reservations); ?>)</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($reservations)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Événement</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td>
                                        <a href="<?= BASE_URL; ?>/event/<?= $reservation['event_id']; ?>">
                                            <?= htmlspecialchars($reservation['title']); ?>
                                        </a>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($reservation['start_datetime'])); ?></td>
                                    <td><?= htmlspecialchars($reservation['location']); ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $reservation['status'] === 'confirmed' ? 'success' : 
                                            ($reservation['status'] === 'pending' ? 'warning text-dark' : 
                                            ($reservation['status'] === 'cancelled' ? 'danger' : 'secondary')); ?>">
                                            <?= ucfirst(str_replace('_', ' ', $reservation['status'])); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="mb-0">Aucune réservation pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="<?= BASE_URL; ?>/participants" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>