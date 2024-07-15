<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: indexlog.php');
    exit;
}

if (isset($_POST['delete_file'])) {
    $file_to_delete = $_POST['file_name'];
    if (file_exists($file_to_delete)) {
        unlink($file_to_delete);
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'File deleted successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'File does not exist.'];
    }
    header('Location: homeadmin.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Archif Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Custom CSS -->
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

    <!-- Main content -->
    <div class="container mt-5">
        
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['alert']['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
        
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">File Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dir = 'uploads/';
                    if (is_dir($dir)) {
                        if ($dh = opendir($dir)) {
                            $count = 1;
                            while (($file = readdir($dh)) !== false) {
                                if (pathinfo($file, PATHINFO_EXTENSION) == 'xml') {
                                    echo "<tr>";
                                    echo "<th scope='row'>{$count}</th>";
                                    echo "<td><a href='{$dir}{$file}' target='_blank'>{$file}</a></td>";
                                    echo "<td>
                                        <a href='{$dir}{$file}' class='btn btn-primary btn-sm' target='_blank'>View</a>
                                        <a href='{$dir}{$file}' download class='btn btn-success btn-sm'>Download</a>
                                        <form action='' method='post' class='d-inline' onsubmit='return confirmDelete()'>
                                            <input type='hidden' name='file_name' value='{$dir}{$file}'>
                                            <button type='submit' name='delete_file' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
                                    </td>";
                                    echo "</tr>";
                                    $count++;
                                }
                            }
                            closedir($dh);
                        } else {
                            echo "<tr><td colspan='3' class='text-danger'>Could not open the uploads directory.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-danger'>Upload directory does not exist.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Archif. Tous droits réservés.</p>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script>
        function confirmDelete() {
            return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?');
        }
    </script>
</body>
</html>
