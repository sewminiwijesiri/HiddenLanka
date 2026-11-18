<?php
require_once __DIR__ . '/../config.php';

// Detect if we are currently inside an admin dashboard page
$current_filename = basename($_SERVER['PHP_SELF']);
$isAdminPage = (strpos($current_filename, 'admin') === 0 || $current_filename === 'settings.php');

// Default page metadata if not defined
$pageTitle = isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME . ' - ' . SITE_TAGLINE;
$pageDesc = isset($pageDesc) ? $pageDesc : 'Hidden Lanka guest house in Sri Lanka. Villa accommodations, home-cooked local meals, guided tours, tuk tuk & motorbike rentals & repairs by P H C Kelum.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css?v=1.1.1">
</head>
<body>

