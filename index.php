<?php require_once "functions/main.php"; ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$publicPages = ['login', 'register'];
$page = $_GET['page'] ?? 'home';

if (!isset($_SESSION['user']) && !in_array($page, $publicPages)) {
    header("Location: /project-p22/?page=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oleh's project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php if (isset($_SESSION['user'])): ?>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/project-p22/">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $_GET['page'] ?? 'home' === 'home' ? 'active' : '' ?>" href="/project-p22/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'gallery' ? 'active' : '' ?>" href="/project-p22/gallery">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'contacts' ? 'active' : '' ?>" href="/project-p22/contacts">Contacts</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'login' ? 'active' : '' ?>" href="/project-p22/reviews">Reviews</a>
                </li>
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="nav-link disabled"><?= $_SESSION['user'] ?? '' ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/project-p22/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>



<div class="container mt-4">
    <?php
    $page = $_GET['page'] ?? 'home';
    $pagePath = "pages/{$page}.php";

    if (!file_exists($pagePath)) {
        $pagePath = "pages/404.php";
    }

    require_once $pagePath;
    OldInput::clear();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
