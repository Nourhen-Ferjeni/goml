<!doctype html>
<html lang="en">
<head>
    <title>Réinitialisation du mot de passe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Réinitialisation du mot de passe</h2>
        <form action="update_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
