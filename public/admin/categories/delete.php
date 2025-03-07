<?php
require_once('../../private/initialize.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $id = $_POST['id'];

    // Determine class
    $class = ucfirst($type);
    $item = $class::find_by_id($id);

    if ($item) {
        $item->delete();
    }
}

// Redirect back to admin panel
header("Location: /admin/index.php");
exit();
?>