<?php include '../views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Inscription à l'événement</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <h5><?= htmlspecialchars($event['title']); ?></h5>
                        <p class="mb-1"><i class="far fa-calendar-alt me-2"></i> 
                            <?= date('d/m/Y H:i', strtotime($event['start_datetime'])); ?> - 
                            <?= date('H:i', strtotime($event['end_datetime'])); ?>
                        </p>
                        <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> <?= htmlspecialchars($event['location']); ?></p>
                        <p class="mb-0"><i class="fas fa-users me-2"></i> 
                            Places disponibles: <?= max(0, $event['max_participants'] - $participantCount); ?>/<?= $event['max_participants']; ?>
                        </p>
                    </div>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="comments" class="form-label">Commentaires (optionnel)</label>
                            <textarea class="form-control" id="comments" name="comments" rows="3" 
                                      placeholder="Régime alimentaire, besoins spécifiques..."></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Confirmer l'inscription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>