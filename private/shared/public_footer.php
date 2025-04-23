<footer role="contentinfo">
    <div id="logoCR">
        <img src="<?php echo url_for('/images/logo.svg');?>" alt="Culinnnari Logo" title="Culinnari | Share Recipes, Enjoy Food" width="251" height="60">
        <p>&copy; 2025 Sydney Farrington<p>
        <?php if($current_page == url_for('/index.php')):?>
            <p><a href="https://www.freepik.com/free-photo/chicken-eggs-milk-oil-notebook-marble-surface_11623345.htm#fromView=search&page=1&position=24&uuid=000115ba-ed80-4ab2-9310-5de791f90e83&query=recipe+cooking">(Hero) Image by azerbaijan_stockers on Freepik</a></p>
        <?php endif; ?>
    </div>    
    <div id="secondaryNav">
        <ul>
            <li><a href="<?php echo url_for('/index.php'); ?>">Home</a></li>
            <li><a href="<?php echo url_for('/recipes.php'); ?>">Recipes</a></li>
            <li><a href="<?php echo url_for('/about.php');?>">About Us</a></li>
        </ul>
    </div>
    <div id="footerUserNav">
        <ul>
            <?php if(!$session->is_logged_in()){ ?>
            <li><a href="<?php echo url_for('/login_signup.php');?>">Log In / Create Account</a></li>
            <?php } elseif($session->is_logged_in()) { ?>
            <li><a href="<?php echo url_for('/member/profile.php'); ?>">My Profile</a></li>
            <li><a href="<?php echo url_for('/member/create_recipe.php'); ?> ">Create Recipe</a></li>
            <?php } ?>
            <?php if($session->is_mgmt_logged_in()){ ?>
            <li><a href="<?php echo url_for('/admin/index.php'); ?>">Management Area</a></li>
            <?php } ?>
        </ul>        
    </div>
    <div id="businessInfo">
        <ul>
            <li><img src="<?php echo url_for('/images/icon/email.svg'); ?>" width="30" height="30" alt="Email icon" title="Email culinnari"><a href="mailto:hello@culinnari.com">hello@culinnari.com</a></li>

        </ul>
    </div>
</footer>

</html>
