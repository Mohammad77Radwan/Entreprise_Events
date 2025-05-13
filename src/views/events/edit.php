<?php include '../views/partials/header.php'; ?>

<div class="container">
    <h1 class="mb-4">Modifier l'événement</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Titre *</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($event['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($event['description']); ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_datetime" class="form-label">Date et heure de début *</label>
                <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime" 
                       value="<?= date('Y-m-d\TH:i', strtotime($event['start_datetime'])); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_datetime" class="form-label">Date et heure de fin *</label>
                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" 
                       value="<?= date('Y-m-d\TH:i', strtotime($event['end_datetime'])); ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Lieu *</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($event['location']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="max_participants" class="form-label">Nombre maximum de participants *</label>
            <input type="number" class="form-control" id="max_participants" name="max_participants" 
                   value="<?= $event['max_participants']; ?>" min="1" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut *</label>
            <select class="form-select" id="status" name="status" required>
                <option value="planned" <?= $event['status'] === 'planned' ? 'selected' : ''; ?>>Planifié</option>
                <option value="ongoing" <?= $event['status'] === 'ongoing' ? 'selected' : ''; ?>>En cours</option>
                <option value="completed" <?= $event['status'] === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                <option value="cancelled" <?= $event['status'] === 'cancelled' ? 'selected' : ''; ?>>Annulé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="<?= BASE_URL; ?>/event/<?= $event['id']; ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startInput = document.getElementById('start_datetime');
    const endInput = document.getElementById('end_datetime');
    
    startInput.addEventListener('change', function() {
        endInput.min = this.value;
    });
});
</script>

<?php include '../views/partials/footer.php'; ?>