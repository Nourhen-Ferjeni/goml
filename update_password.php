<?php
include_once('connection.php');

if (isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $password = md5($_POST['password']);

    // Vérifier si le jeton est valide et non expiré
    $sql = "SELECT * FROM tbl_user WHERE reset_token='$token' AND reset_expires > NOW()";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        // Mettre à jour le mot de passe et supprimer le jeton de réinitialisation
        $sql = "UPDATE tbl_user SET password='$password', reset_token=NULL, reset_expires=NULL WHERE id='$user_id'";
        mysqli_query($conn, $sql);

        echo "Votre mot de passe a été réinitialisé avec succès.";
    } else {
        echo "Le lien de réinitialisation est invalide ou a expiré.";
    }
} else {
    echo "Requête invalide.";
}
?>
