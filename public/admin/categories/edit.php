<?php
require_once('../../private/initialize.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Determine class
    $class = ucfirst($type);
    $item = $class::find_by_id($id);

    if ($item) {
        $item->{$type . '_name'} = $name;
        $item->save();
    }
}

// Redirect back to admin panel
header("Location: /admin/index.php");
exit();
?>