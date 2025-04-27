<?php require_once('../../../private/initialize.php'); 
$title = "Management Area| Categories | Culinnari"; 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
?>

<main role="main" tabindex="-1">
    <div class="adminHero">
        <h2>Management Area - Categories</h2>
    </div>

    <div class="wrapper">
        <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Management Index</a>
        <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
        
        <div class="mgmtTableHeading">
            <img src="<?php echo url_for('/images/icon/categories.svg');?>" width="32" height="36" alt="Categories icon">
            <h3>Categories</h3>
        </div>
        <section class="categoriesTableSection">
            <div class="sectionHeader">
                <h4>Meal Types</h4>
                <a class="adminAddNew" href="<?php echo url_for('/admin/categories/meal_types/new.php');?>">Add New Meal Type</a>
            </div>
            <table id="mealTypes">
                <tr>
                    <th>Meal Type Name</th>
                    <th>Manage</th>
                </tr>
                <?php $mealTypes = MealType::find_all();
                    foreach($mealTypes as $mealType) { ?>
                    <tr>
                        <td><?php echo h($mealType->meal_type_name); ?></td>
                        <td><a href="<?php echo url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . h(u($mealType->id)));
                        ?>">Manage</a></td>
                    </tr>
                    <?php } ?>
            </table>
        </section>

        <section class="categoriesTableSection">
            <div class="sectionHeader">
                <h4>Styles</h4>
                <a class="adminAddNew" href="<?php echo url_for('/admin/categories/styles/new.php');?>">Add New Style</a>
            </div>
            <table id="styles">
                <tr>
                    <th>Style Name</th>
                    <th>Manage</th>
                </tr>
                <?php $styles = Style::find_all();
                foreach($styles as $style) { ?>
                    <tr>
                        <td><?php echo h($style->style_name); ?></td>
                        <td><a href="<?php echo url_for('/admin/categories/styles/manage.php?style_id=' . h(u($style->id)));
                        ?>">Manage</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </section>

            <section class="categoriesTableSection">           
                <div class="sectionHeader">
                    <h4>Diets</h4>
                    <a class="adminAddNew" href="<?php echo url_for('/admin/categories/diets/new.php');?>">Add New Diet</a>
                </div>
                <table id="diets">
                    <tr>
                        <th>Diet Name and Icon</th>
                        <th>Manage</th>
                    </tr>
                    <?php $diets = Diet::find_all();
                    foreach($diets as $diet) { ?>
                    <tr>
                        <td><img src="<?php echo url_for($diet->diet_icon_url); ?>" width="20" height="20" alt="Icon for <?php echo h($diet->diet_name); ?>">  <?php echo h($diet->diet_name); ?> </td>
                        <td><a href="<?php echo url_for('/admin/categories/diets/manage.php?diet_id=' . h(u($diet->id)));
                        ?>">Manage</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </section> 
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>