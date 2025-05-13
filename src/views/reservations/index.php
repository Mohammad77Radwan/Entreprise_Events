<?php include '../views/partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Toutes les Réservations</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Événement</th>
                            <th>Participant</th>
                            <th>Email</th>
                            <th>Date Réservation</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td>
                                    <a href="<?= BASE_URL; ?>/event/<?= $reservation['event_id']; ?>">
                                        <?= htmlspecialchars($reservation['event_title']); ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']); ?></td>
                                <td><?= htmlspecialchars($reservation['email']); ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($reservation['reservation_date'])); ?></td>
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
        </div>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>