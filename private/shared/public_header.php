<?php include('head.php');?>

<header role="banner">
    <h1 class="visuallyHidden">Culinnari | Recipe Sharing</h1>
    <a href="<?php echo url_for('/index.php'); ?>">
        <img src="<?php echo url_for('/images/logo.svg'); ?>" width="215" height="60" alt="Culinnari Logo" title="">
    </a>
    <nav role="navigation">
        <ul>
            <li><a href="<?php echo url_for('index.php'); ?>">Home</a></li>
            <li><a href="<?php echo url_for('recipes.php'); ?>">Recipes</a></li>
            <li><a href="<?php echo url_for('about.php'); ?>">About</a></li>
        </ul>
    </nav>
    <?php if(!$session->is_logged_in()){ ?>
        <div id="headerLoginSignup">
            <img src=<?php echo url_for('images/icon/loginSignupIcon.svg'); ?> width="30" height="30" alt="Login or Signup Icon" title="Login or Signup with Culinnari">
            <a href=<?php echo url_for('/login_signup.php'); ?> >Login / Signup</a>
        </div>
    <?php } elseif($session->is_logged_in()){ ?>
        <div id="userHeader">
            <img src=<?php echo url_for('/images/icon/memberIcon.svg'); ?> width="30" height="30" alt="User Icon" title="User Profile">
            <a href=<?php echo url_for("/member/profile.php"); ?> ><?php echo $session->username; ?></a>
            <a href=<?php echo url_for("public/logout.php"); ?> >Logout</a>
        </div>
    <?php } ?>
</header>