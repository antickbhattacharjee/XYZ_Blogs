<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if(is_logged_in()) {
    redirect('index.php');
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($conn, $_POST['username']);
    $email = sanitize($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $error = "Username or Email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if($stmt->execute()) {
                $success = "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="auth-wrapper">
    <div class="card card-auth">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Register</h3>
            <?= display_error($error) ?>
            <?= display_success($success) ?>
            
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Create Account</button>
            </form>
            <div class="text-center mt-3">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
