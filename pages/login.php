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

    $users = file_exists('users.json') ? json_decode(file_get_contents('users.json'), true) : [];

    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $email;
            header("Location: /project-p22/?page=home");
            exit;
        }
    }

    echo "<div class='alert alert-danger'>Invalid email or password.</div>";
}
?>

<link rel="stylesheet" href="styles.css">

<div class="auth-center">
    <form method="post" class="auth-box">
        <h2>Sign In</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

        <p class="switch-link">Don't have an account?
            <a href="?page=register">Sign Up</a>
        </p>
    </form>
</div>


