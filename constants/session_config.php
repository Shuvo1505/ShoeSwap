<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Global session status check
// You can access this from any page after including this file
$is_logged_in = isset($_SESSION['status']) && $_SESSION['status'] === 'active';

// Example: fallback for username (optional)
$current_user = $_SESSION['user'] ?? null;
?>