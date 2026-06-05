<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if(is_logged_in()) {
    redirect('index.php');
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_username = sanitize($_POST['email_or_username']);
    $password = $_POST['password'];

    if(empty($email_or_username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$email_or_username, $email_or_username]);

        if($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                redirect('index.php');
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="auth-wrapper">
    <div class="card card-auth">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Login</h3>
            <?= display_error($error) ?>
            
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username or Email</label>
                    <input type="text" name="email_or_username" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
