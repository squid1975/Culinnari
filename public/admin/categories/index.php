<?php require_once('../../../private/initialize.php'); 
$pageTitle = "Management Area | Culinnari"; 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
?>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>

    <div class="wrapper">
        <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Management Home</a>
        
        <section id="categories">
                <div class="mgmtTableHeading">
                    <img src="<?php echo url_for('/images/icon/categories.svg');?>" width="32" height="36">
                    <h3>Categories</h3>
                    
                </div>
                <div>
                    <div>
                        <h4>Meal Types</h4>
                        <a class="adminAddNew" href="<?php echo url_for('/admin/categories/meal_types/new.php');?>">Add New Meal Type</a>
                    </div>
                    <table id="mealTypes">
                        <tr>
                            <th>Meal Type Name</th>
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
                </div>
                
                <div>
                    <div>
                        <h4>Styles</h4>
                        <a class="adminAddNew" href="<?php echo url_for('/admin/categories/styles/new.php');?>">Add New Style</a>
                    </div>
                    <table id="styles">
                        <tr>
                            <th>Style Name</th>
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
                </div>

                <div>
                    <div>
                        <h4>Diets</h4>
                        <a class="adminAddNew" href="<?php echo url_for('/admin/categories/diets/new.php');?>">Add New Diet</a>
                    </div>
                    <table id="diets">
                        <tr>
                            <th>Diet Name</th>
                        </tr>
                        <?php $diets = Diet::find_all();
                        foreach($diets as $diet) { ?>
                        <tr>
                            <td><img src="<?php echo url_for($diet->diet_icon_url); ?>">  <?php echo h($diet->diet_name); ?> </td>
                            <td><a href="<?php echo url_for('/admin/categories/diets/manage.php?diet_id=' . h(u($diet->id)));
                            ?>">Manage</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </section>
            
            
        </div>
    </div>
    </main>
    <?php include(SHARED_PATH . '/public_footer.php'); ?>
</body>

