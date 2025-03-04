<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Management Area | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php require_mgmt_login(); ?>


<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>

    
        <h3>Users</h3>
    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/users/new.php');
      ?>">Add user</a>
    </div>

    <table>
      <tr>    
        <th>Username</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Create Account Date</th>
        <th>Role</th>        
      </tr>
<?php

// Create a new user object that uses the find_all() method
$users = User::find_all();

foreach($users as $user) { 
  ?>
      <tr>
        <td><?php echo h($user->username); ?></td>
        <td><?php echo h($user->user_first_name); ?></td>
        <td><?php echo h($user->user_last_name); ?></td>
        <td><?php echo h($user->user_email_address); ?></td>
        <td><?php echo h($user->user_create_account_date); ?></td>
        <td><?php echo h($user->user_role); ?></td>
        <td><a class="action" href="<?php echo url_for('/admin/users/show_user.php?id=' . h(u($user->id)));
        ?>">View</a></td>
        <td><a class="action" href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user->id)));
        ?>">Edit</a></td>
        <td><a class="action" href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id)));
        ?>">Delete</a></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

<h3>Categories</h3>
    <div id="categoriesContainer">
        <div>
            <h4>Meal Type</h4>
            <table>
            <tr>
                <th>Meal Type Name</th>
            </tr>
            <?php $mealtypes = MealType::find_all(); 
            foreach($mealtypes as $mealtype) { ?>
                <tr>
                    <td><?php echo h($mealtype->meal_type_name); ?></td>
                    <td><a class="action" href="<?php echo url_for('/admin/categories/show_mealtype.php?id=' . h(u($mealtype->id))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('/admin/edit_mealtype.php?id=' . h(u($mealtype->id))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/admin/delete_mealtype.php?id=' . h(u($mealtype->id))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
            </table>
        </div>
        <div>
            <h4>Style</h4>
            <table>
            <tr>
                <th>Style Name</th>
            </tr>
            <?php $styles = Style::find_all(); 
            foreach($styles as $style) { ?>
                <tr>
                    <td><?php echo h($style->style_name); ?></td>
                    <td><a class="action" href="<?php echo url_for('/admin/show_style.php?id=' . h(u($style->id))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('/admin/edit_style.php?id=' . h(u($style->id))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/admin/delete_style.php?id=' . h(u($style->id))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
            </table>
            </div>
        <div>
            <h4>Diet</h4>
            <table>
            <tr>
                <th>Diet Name</th>
                <th>Diet Icon</th>
            </tr>
            <?php $diets = Diet::find_all(); 
            foreach($diets as $diet) { ?>
                <tr>
                    <td><?php echo h($diet->diet_name); ?></td>
                    <td><img src="<?php echo url_for(h($diet->diet_icon_url)); ?>"></td>
                    <td><a class="action" href="<?php echo url_for('/admin/show_mealtype.php?id=' . h(u($diet->id))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('/admin/edit_mealtype.php?id=' . h(u($diet->id))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/admin/delete_mealtype.php?id=' . h(u($diet->id))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div> 

</main>
    <?php include(SHARED_PATH . '/public_footer.php'); ?>