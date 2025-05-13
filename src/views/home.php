<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1 class="mb-4">Tableau de bord</h1>

    <?php if (!empty($myEvents)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Mes Événements</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myEvents as $event): ?>
                                <tr>
                                    <td><?= htmlspecialchars($event['title']); ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($event['start_datetime'])); ?></td>
                                    <td><?= htmlspecialchars($event['location']); ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $event['status'] === 'planned' ? 'primary' : 
                                            ($event['status'] === 'ongoing' ? 'warning text-dark' : 
                                            ($event['status'] === 'completed' ? 'success' : 'danger')); ?>">
                                            <?= ucfirst($event['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>" class="btn btn-sm btn-info">
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
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Événements à venir</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($upcomingEvents)): ?>
                <div class="row">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                                    <p class="card-text">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        <?= date('d/m/Y H:i', strtotime($event['start_datetime'])); ?>
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <?= htmlspecialchars($event['location']); ?>
                                    </p>
                                    <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>" class="btn btn-primary">
                                        Voir détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mb-0">Aucun événement à venir pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>