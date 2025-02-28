<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Manage Categories | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<main role="main" tabindex="-1">
<div id="adminHero">
        <h2>Management Area: Categories</h2>
    </div>
    <h3>Diet</h3>
    <table>

    </table>

    <h3>Meal Type</h3>
    <table>
    <?php $mealtypes = MealType::find_all(); 
    foreach($mealtypes as $mealtype) { ?>
        <tr>
            <td><?php echo h($mealtype->meal_type_name); ?></td>
            <td><a class="action" href="<?php echo url_for('/admin/show_mealtype.php?id=' . h(u($mealtype->id))); ?>">View</a></td>
            <td><a class="action" href="<?php echo url_for('/admin/edit_mealtype.php?id=' . h(u($mealtype->id))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo url_for('/admin/delete_mealtype.php?id=' . h(u($mealtype->id))); ?>">Delete</a></td>
        </tr>
    <?php } ?>
    <table> 
    </table>

    <h3>Style</h3>
</main>


<?php include(SHARED_PATH . '/public_footer.php'); ?>