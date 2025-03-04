<footer role="contentinfo">
    <div id="logoCR">
        <img src="<?php echo url_for('/images/logo.svg');?>" alt="Culinnnari Logo" title="Culinnari | Share Recipes, Enjoy Food" width="251" height="60">
        <p>&copy; 2025 Sydney Farrington<p>
    </div>    
    <div id="secondaryNav">
        <ul>
            <li><a href="<?php echo url_for('/index.php'); ?>">Home</a></li>
            <li><a href="<?php echo url_for('/recipes.php'); ?>">Recipes</a></li>
            
        </ul>
    </div>
    <div id="footerUserNav">
        <ul>
            <?php if(!$session->is_logged_in()){ ?>
            <li><a href="<?php echo url_for('/login_signup.php');?>">Log In</a></li>
            <li><a href="<?php echo url_for('/login_signup.php');?>">Create Account</a></li>
            <?php } elseif($session->is_logged_in()) { ?>
            <li><a href="<?php echo url_for('/member/profile.php'); ?>">My Profile</a></li>
            <li><a href="<?php echo url_for('/member/create_recipe.php'); ?> ">Create Recipe</a></li>
            <li><a href="<?php echo url_for('/member/cookbook.php'); ?>">My Cookbook</a></li>
            <?php } ?>
            <?php if($session->is_mgmt_logged_in()){ ?>
            <li><a href="<?php echo url_for('/admin/index.php'); ?>">Management Area</a></li>
            <?php } ?>
        </ul>        
    </div>
    <div id="businessInfo">
        <li><a href="privacyPolicy.php">Privacy Policy</a></li>
        <li><a href="mailto:hello@culinnari.com">hello@culinnari.com</a></li>
    </div>
</footer>
</html>
