<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if(!is_logged_in()) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Check if like exists
    $stmt = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->bind_param("ii", $user_id, $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        // Unlike
        $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $action = 'unliked';
    } else {
        // Like
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $action = 'liked';
    }

    // Get new count
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM likes WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $count_result = $stmt->get_result()->fetch_assoc();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'likes' => $count_result['count']
    ]);
} else {
    echo json_encode(['status' => 'error']);
}
?>
