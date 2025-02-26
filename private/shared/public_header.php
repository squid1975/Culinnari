<?php include('head.php');?>

<header role="banner">
    <div id="headerIcon">
        <h1 class="visuallyHidden">Culinnari | Recipe Sharing</h1>
        <a href="<?php echo url_for('/index.php'); ?>">
            <img src="<?php echo url_for('/images/logo.svg'); ?>" width="215" height="60" alt="Culinnari Logo" title="">
        </a>
    </div>
    <nav role="navigation" id="mainMenu">
        <img src="<?php echo url_for('/images/icon/menu.svg'); ?>" width="30" height="30" alt="Menu Icon" title="Menu">
        <div id="menuContent">
        <ul>
            <li><a href="<?php echo url_for('index.php'); ?>">Home</a></li>
            <li><a href="<?php echo url_for('recipes.php'); ?>">Recipes</a></li>
            
        </ul>
        </div>
    </nav>
    <div id="userHeader">
        <?php if(!$session->is_logged_in()){
            include(SHARED_PATH . '/gen_public_header.php');
        } elseif ($session->is_admin_logged_in() or $session->is_super_admin_logged_in()){  
            include(SHARED_PATH . '/admin_header.php');
        } else {
            include(SHARED_PATH . '/member_header.php');
        }?>
    </div>
</header>