<?php include('head.php');
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<header role="banner">
    <div id="headerIcon">
        <h1 class="visuallyHidden">Culinnari | Recipe Sharing</h1>
        <a href="<?php echo url_for('/index.php'); ?>">
            <img src="<?php echo url_for('/images/logo.svg'); ?>" width="215" height="60" alt="Culinnari Logo" title="">
        </a>
    </div>
    <nav role="navigation" id="mainMenu">
        <input type="checkbox" id="menu-toggle">
        <label class="menuButton" for="menu-toggle">
            <img src="<?php echo url_for('/images/icon/menu.svg'); ?>" width="30" height="30" alt="Menu Icon" title="Menu">
        </label>
        <div id="menuContent">
            <ul>
                <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a href="<?php echo url_for('index.php'); ?>">Home</a>
                </li>
                <li class="<?php echo ($current_page == 'recipes.php') ? 'active' : ''; ?>">
                    <a href="<?php echo url_for('recipes.php'); ?>">Recipes</a>
                </li>  
            </ul>
        </div>
    </nav>
    <div id="userHeader">
    <?php
    if(!$session->is_logged_in()) {
        include(SHARED_PATH . '/gen_public_header.php');
    }
    if ($session->is_mgmt_logged_in()) {  
        include(SHARED_PATH . '/admin_header.php');
    }
    elseif($session->is_logged_in()) {  
        include(SHARED_PATH . '/member_header.php');
    }
    ?>
</div>
</header>