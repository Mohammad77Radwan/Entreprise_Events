<?php include '../views/partials/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= htmlspecialchars($event['title']); ?></h1>
        <?php if (Auth::isAdmin() || (Auth::isOrganizer() && $_SESSION['user_id'] == $event['organizer_id'])): ?>
            <div>
                <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>/edit" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="<?= BASE_URL; ?>/event/<?= $event['id']; ?>/delete" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Organisateur:</strong> <?= htmlspecialchars($event['organizer_first_name'] . ' ' . $event['organizer_last_name']); ?></p>
                    <p><strong>Date:</strong> <?= date('d/m/Y H:i', strtotime($event['start_datetime'])); ?> - <?= date('H:i', strtotime($event['end_datetime'])); ?></p>
                    <p><strong>Lieu:</strong> <?= htmlspecialchars($event['location']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Statut:</strong> <span class="badge bg-<?= 
                        $event['status'] === 'planned' ? 'primary' : 
                        ($event['status'] === 'ongoing' ? 'warning text-dark' : 
                        ($event['status'] === 'completed' ? 'success' : 'danger')); ?>">
                        <?= ucfirst($event['status']); ?>
                    </span></p>
                    <p><strong>Participants:</strong> <?= $participantCount; ?>/<?= $event['max_participants']; ?></p>
                    <?php if (Auth::check() && !Auth::isAdmin()): ?>
                        <?php if ($participant = (new Participant())->getByUserId($_SESSION['user_id'])): ?>
                            <?php if (!(new Reservation())->exists($event['id'], $participant['id'])): ?>
                                <a href="<?= BASE_URL; ?>/reservations/<?= $event['id']; ?>/create" class="btn btn-success">
                                    <i class="fas fa-user-plus"></i> S'inscrire
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Déjà inscrit</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <h5>Description</h5>
            <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Participants (<?= count($participants); ?>)</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($participants)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Département</th>
                                <th>Statut</th>
                                <th>Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($participants as $participant): ?>
                                <tr>
                                    <td><?= htmlspecialchars($participant['first_name'] . ' ' . $participant['last_name']); ?></td>
                                    <td><?= htmlspecialchars($participant['email']); ?></td>
                                    <td><?= htmlspecialchars($participant['department']); ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $participant['status'] === 'confirmed' ? 'success' : 
                                            ($participant['status'] === 'pending' ? 'warning text-dark' : 
                                            ($participant['status'] === 'cancelled' ? 'danger' : 'secondary')); ?>">
                                            <?= ucfirst(str_replace('_', ' ', $participant['status'])); ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($participant['reservation_date'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="mb-0">Aucun participant pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>