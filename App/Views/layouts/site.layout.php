<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Public/assets/css/main.css">
    <title><?php echo $params['title']; ?></title>
</head>

<body class="bg-custom-dark">

<header>
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand text-accent" href="/product">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-people-fill" viewBox="0 0 16 16" style="margin-right:10px;">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg>
                Pear Store home
            </a>
            <ul class="nav align-items-center">
                <?php if (isset($params['user']) && $params['user']['admin']): ?>
                <li class="nav-item me-3">
                    <a class="nav-link nav-link-custom" href="/admin">
                        <i class="bi bi-gear me-1"></i>Admin
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item me-3">
                    <a class="nav-link nav-link-custom" href="/cart">
                        <i class="bi bi-cart3 me-1"></i>My Cart
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-custom dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= '/Public/assets/avatar/' . ($params['user']['image'] ?? 'default.png') ?>" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32" 
                             alt="Profile"
                             style="object-fit: cover;">
                        Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/user/profile">
                                <i class="bi bi-person me-2"></i>View Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/cart/history">
                                <i class="bi bi-clock-history me-2"></i>Order History
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="/user/logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main class="main-content">
    <?php echo $params['content']; ?>
</main>

<footer class="footer-custom">
    <div class="container">
        <hr class="footer-divider">
        <p class="text-center mt-5 footer-text">
            <em>@2025 by Yaros.</em>
        </p>
    </div>
</footer>
    
</body>
</html>