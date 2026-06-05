<?php
session_start();

function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($input))));
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect($location) {
    header("Location: " . $location);
    exit();
}

function get_user($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function display_error($error) {
    if (!empty($error)) {
        return "<div class='alert alert-danger'>$error</div>";
    }
    return '';
}

function display_success($msg) {
    if (!empty($msg)) {
        return "<div class='alert alert-success'>$msg</div>";
    }
    return '';
}
?>
