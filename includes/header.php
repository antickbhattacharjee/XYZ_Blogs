<?php
require_once 'db.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XYZ Blogs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">XYZ Blogs</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(is_logged_in()): ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Newsfeed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="create_post.php">Create Post</a>
            </li>
        <?php endif; ?>
      </ul>

      <form class="d-flex me-3" action="search.php" method="GET">
        <input class="form-control me-2" type="search" name="q" placeholder="Search posts or users..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit"><i class="fa fa-search"></i></button>
      </form>

      <ul class="navbar-nav">
        <?php if(is_logged_in()): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fa fa-user-circle"></i> Profile
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php?id=<?= $_SESSION['user_id'] ?>">My Profile</a></li>
                <li><a class="dropdown-item" href="edit_profile.php">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            </li>
        <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4 mb-5 main-content">
