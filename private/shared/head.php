<?php 
$id = $_SESSION['user_id'] ?? false; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php isset($pageTitle) ? $pageTitle : 'Culinnari'; ?></title>
    <link href="<?php echo url_for('css/main.css'); ?>" rel="stylesheet">
    
</head>
