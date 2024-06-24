<?php
include_once('connection.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Vérifier si l'email existe dans la base de données
    $sql = "SELECT * FROM tbl_user WHERE username='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50)); // Générer un jeton de réinitialisation unique
        $sql = "UPDATE tbl_user SET reset_token='$token', reset_expires=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE username='$email'";
        mysqli_query($conn, $sql);

        // Envoyer l'email avec le lien de réinitialisation
        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Réinitialisation du mot de passe";
        $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";
        $headers = "From: no-reply@yourdomain.com";

        mail($email, $subject, $message, $headers);
        echo "Un lien de réinitialisation a été envoyé à votre adresse e-mail.";
    } else {
        echo "Aucun compte associé à cette adresse e-mail.";
    }
} else {
    echo "Veuillez fournir une adresse e-mail.";
}
?>
