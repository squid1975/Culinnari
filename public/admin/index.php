<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Management Area | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php require_mgmt_login(); ?>
<body>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>

    <section>
        <div class="mgmtTableHeading">
            <img src="<?php echo url_for('/images/icon/users.svg');?>" width="32" height="36">
            <h3>Users</h3>
        </div>
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
</section>
<section>
    <div class="mgmtTableHeading">
        <img src="<?php echo url_for('/images/icon/categories.svg');?>" width="34" height="33">
        <h3>Categories</h3>
    </div>
    <div id="categoriesContainer">
    <div>
        <h4>Meal Type</h4>
        <table>
            <tr>
                <th>Meal Type Name</th>
            </tr>
            <?php $mealtypes = MealType::find_all();
            foreach ($mealtypes as $mealtype) { ?>
                <tr>
                    <td>
                        <a class="action" href="<?php echo url_for('/admin/categories/manage.php?type=mealtype&id=' . h(u($mealtype->id))); ?>">
                            <?php echo h($mealtype->meal_type_name); ?>
                        </a>
                    </td>
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
            foreach ($styles as $style) { ?>
                <tr>
                    <td>
                        <a class="action" href="<?php echo url_for('/admin/categories/manage.php?type=style&id=' . h(u($style->id))); ?>">
                            <?php echo h($style->style_name); ?>
                        </a>
                    </td>
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
            foreach ($diets as $diet) { ?>
                <tr>
                    <td>
                        <a class="action" href="<?php echo url_for('/admin/categories/manage.php?type=diet&id=' . h(u($diet->id))); ?>">
                            <?php echo h($diet->diet_name); ?>
                        </a>
                    </td>
                    <td><img src="<?php echo url_for(h($diet->diet_icon_url)); ?>" alt="Diet Icon"></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
    </section>
</main>
    <?php include(SHARED_PATH . '/public_footer.php'); ?>
    </body>