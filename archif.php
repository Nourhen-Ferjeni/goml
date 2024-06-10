<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Custom CSS -->
    <style>
        .custom-navbar {
            background-color: #E8E8E8; /* couleur grey */
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
    <div class="w3-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
      <a href="#home" class="w3-bar-item w3-button"><b></b> </a>

      <a class="navbar-brand" href="#">
            <img src="ubcilogo.png" alt="Logo Archif" height="30" class="d-inline-block align-text-top me-2">
            Bienvenue sur Archif Page
        </a>


      <!-- Float links to the right. Hide them on small screens -->
      <div class="w3-right w3-hide-small">
        <a href="#about" class="w3-bar-item w3-button">Home</a> 
        <a href="#contact" class="w3-bar-item w3-button">Consult</a>
        <a href="logout.php" class="w3-bar-item w3-button">Logout</a> 
        <a href="#projects" class="w3-bar-item w3-button"><b>
            <div onclick="open_menu()">☰</div>
          </b>
        </a>
      </div>
    </div>
  </div>
</nav>



    <!-- Main content -->
    <div class="container mt-5">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
        
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Archif. Tous droits réservés.</p>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>
</html>
