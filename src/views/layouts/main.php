<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestion des Événements'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?= BASE_URL; ?>/assets/css/style.css" rel="stylesheet">
    <?= $additionalCSS ?? ''; ?>
</head>
<body>
    <?php include '../views/partials/navbar.php'; ?>
    
    <main class="container py-4">
        <?= $content; ?>
    </main>

    <?php include '../views/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL; ?>/assets/js/main.js"></script>
    <?= $additionalJS ?? ''; ?>
</body>
</html>