<?php
require_once('../../../private/initialize.php');
 $pageTitle = "Management Area | Culinnari"; 
 include(SHARED_PATH . '/public_header.php'); 

// Ensure `type` and `id` are provided
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Invalid category.");
}

// Sanitize input
$type = h($_GET['type']);
$id = h($_GET['id']);

// Determine the correct class
switch ($type) {
    case 'mealtype':
        $class = 'MealType';
        $title = 'Meal Type';
        break;
    case 'style':
        $class = 'Style';
        $title = 'Style';
        break;
    case 'diet':
        $class = 'Diet';
        $title = 'Diet';
        break;
    default:
        die("Invalid category type.");
}

// Fetch item
$item = $class::find_by_id($id);
if (!$item) {
    die("Item not found.");
}
?>
<body>
    <h2>View <?php echo $title; ?></h2>

    <p><strong><?php echo $title; ?> Name:</strong> <?php echo h($item->{$type . '_name'}); ?></p>

    <?php if ($type === 'diet'): ?>
        <p><strong>Diet Icon:</strong> <img src="<?php echo url_for(h($item->diet_icon_url)); ?>" alt="Diet Icon"></p>
    <?php endif; ?>

    <!-- Edit Form -->
    <h3>Edit <?php echo $title; ?></h3>
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <label for="name"><?php echo $title; ?> Name:</label>
        <input type="text" name="name" value="<?php echo h($item->{$type . '_name'}); ?>">
        <input type="submit" value="Save Changes">
    </form>

    <!-- Delete Form -->
    <h3>Delete <?php echo $title; ?></h3>
    <form action="delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this <?php echo $title; ?>?');">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <input type="submit" value="Delete">
    </form>

    <br>
    <a href="/admin/index.php">Back to Admin</a>
</body>
</html>