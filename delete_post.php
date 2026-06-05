<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if(!is_logged_in()) {
    redirect('login.php');
}

$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch post to check ownership
$stmt = $conn->prepare("SELECT user_id, image FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if($post && $post['user_id'] == $_SESSION['user_id']) {
    // Delete image if exists
    if(!empty($post['image']) && file_exists('assets/uploads/' . $post['image'])) {
        unlink('assets/uploads/' . $post['image']);
    }
    
    // Delete post
    $del_stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $del_stmt->bind_param("i", $post_id);
    $del_stmt->execute();
}

redirect('index.php');
?>
