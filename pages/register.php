<?php
if (isset($_SESSION['user'])) {
    header("Location: /project-p22/");
    exit;
}
?>


<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email && $password) {
        $users = file_exists('users.json') ? json_decode(file_get_contents('users.json'), true) : [];

        foreach ($users as $user) {
            if ($user['email'] === $email) {
                echo "<div class='alert alert-danger'>Email already registered.</div>";
                return;
            }
        }

        $users[] = ['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)];
        file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

        header("Location: /project-p22/?page=login");
        exit;
    }
}
?>

<link rel="stylesheet" href="/project-p22/css/auth.css">

<div class="auth-center">
    <form method="post" class="auth-box">
        <h2>Sign Up</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Register</button>

        <p class="switch-link">Already have an account?
            <a href="?page=login">Sign In</a>
        </p>
    </form>
</div>


