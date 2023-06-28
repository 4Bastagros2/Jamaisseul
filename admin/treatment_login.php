<?php
session_start();
if (!isset($_SESSION['username']) && empty($_SESSION['username']))
{
    header('Location: ../');
}

require_once('../class/User.php');


$userRepo = new UserRepository();
$email = htmlspecialchars(strip_tags($_POST['email']));
$username = htmlspecialchars(strip_tags($_POST['username']));
$password = htmlspecialchars(strip_tags($_POST['password']));


$user = $userRepo->getUserByEmailAndUsername($email, $username);
if ($user != []) {
    if (password_verify($password, $user->getPassword())) {

        $_SESSION['username'] = $user->getUsername();
        $_SESSION['id_user'] = $user->getIdUser();
        $_SESSION['success-message'] = "Bienvenue sur votre espace administrateur !";
        header('Location: panel.php');
    } else {

        $_SESSION['error-message'] = "Un des champs est incorrect.";
        header('Location: index.php');
    }
} else {

    $_SESSION['error-message'] = "Aucun utilisateur n'a été trouvé.";
    header('Location: index.php');
}
?>