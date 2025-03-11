<?php require_once('../../private/initialize.php'); 
$pageTitle = "Management Area | Culinnari"; 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
$currentUserRole = $session->user_role;?>
<body>
<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>

    <div id="wrapper">
        <div id="adminWrapper">
            <div class="mgmtTableHeading">
                <img src="<?php echo url_for('/images/icon/users.svg');?>" width="32" height="36">
                <h3>Users</h3>
                <a  href="<?php echo url_for('/admin/users/new.php');?>">Add user</a>
            </div>
            <section id="users">
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
                    <td><a  href="<?php echo url_for('/admin/users/show.php?id=' . h(u($user->id)));
                    ?>">View</a></td>
                    <td><a  href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user->id)));
                    ?>">Edit</a></td>
                    <td><a  href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id)));
                    ?>">Delete</a></td>
                </tr>
                <?php } ?>
                </table>
            </section>
            <section id="categories">
                <div class="mgmtTableHeading">
                    <img src="<?php echo url_for('/images/icon/categories.svg');?>" width="34" height="33">
                    <h3>Categories</h3>
                </div>
                <div id="categoriesWrapper">
                    <div class="categoriesContainer">
                        <div>
                            <h4>Meal Type</h4>
                            <ul>
                                <?php $mealtypes = MealType::find_all();
                                foreach ($mealtypes as $mealtype) { ?>
                                    <li><a href="<?php echo url_for('/admin/categories/manage.php?type=mealtype&id=' . h(u($mealtype->id))); ?>">
                                            <?php echo h($mealtype->meal_type_name); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>  
                    </div>

                    <div class="categoriesContainer">
                        <div>
                            <h4>Style</h4>
                            <ul>
                                <?php $styles = Style::find_all();
                                foreach ($styles as $style) { ?>
                                    <li><a href="<?php echo url_for('/admin/categories/manage.php?type=style&id=' . h(u($style->id))); ?>">
                                            <?php echo h($style->style_name); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>  
                    </div>

                    <div class="categoriesContainer">
                        <div>
                            <h4>Diets</h4>
                            <ul>
                                <?php $diets = Diet::find_all();
                                foreach ($diets as $diet) { ?>
                                    <li><a href="<?php echo url_for('/admin/categories/manage.php?type=diet&id=' . h(u($diet->id))); ?>">
                                            <?php echo h($diet->diet_name); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>  
                    </div>
                </div>
            </section>
        </div>
    </div>
    </main>
    <?php include(SHARED_PATH . '/public_footer.php'); ?>
</body>