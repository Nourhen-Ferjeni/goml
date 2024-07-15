<?php
session_start();
include_once('connection.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tbl_user WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];

    // Mettre à jour le mot de passe si un nouveau mot de passe est fourni
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql = "UPDATE tbl_user SET name='$name', username='$username', password='$password', poste='$position', tel='$phone' WHERE id='$user_id'";
    } else {
        $sql = "UPDATE tbl_user SET name='$name', username='$username', poste='$position', tel='$phone' WHERE id='$user_id'";
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        echo "<script>
        alert('Compte mis à jour avec succès');
        window.location.href='homeadmin.php';
      </script>";
      exit;
    
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Modifier Compte</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        .custom-navbar {
            background-color: #E8E8E8; /* couleur gris */
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: black; /* couleur du texte */
        }
        .navbar-nav .nav-link {
            color: black; /* couleur du texte */
        }
        .navbar-nav .nav-link.active {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="ubcilogo.png" alt="Logo Archif" height="30" class="d-inline-block align-text-top me-2">
                Bienvenue Monsieur <?php echo htmlspecialchars($_SESSION['name']); ?>!
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Convertir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modifierCompte.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Modifier Compte</h1>
        <form action="modifiercompte.php" method="post" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Nom et Prénom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Poste</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                    <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($user['poste']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['tel']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau Mot de Passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Mettre à jour</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Archif. Tous droits réservés.</p>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <!-- Icons library -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
