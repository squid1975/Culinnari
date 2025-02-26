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
            <li><a href="<?php echo url_for('/login_signup.php');?>">Log In / Sign Up</a></li>
            <li><a href="<?php echo url_for('/member/profile.php'); ?>">Profile</a></li>
            <li><a href="<?php echo url_for('/member/create_recipe.php'); ?> ">Create Recipe</a></li>
            <li><a href="<?php echo url_for('/member/edit_recipe.php'); ?>" >Edit Recipe</a></li>


        </ul>        
    </div>
    <div id="businessInfo">
        <li><a href="privacyPolicy.php">Privacy Policy</a></li>
        <li><a href="mailto:hello@culinnari.com">hello@culinnari.com</a></li>
    </div>
</footer>
</html>
