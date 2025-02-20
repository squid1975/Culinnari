<?php include('head.php');?>

<header role="banner">
    <h1 class="visuallyHidden">Culinnari | Recipe Sharing</h1>
    <a href="index.php"><img src="../public/images/logo.svg" width="215" height="60" alt="Culinnari Logo" title=""></a>
    <nav role="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="recipes.php">Recipes</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>
    <div id="headerSearch">
        <form class="navSearch" action="searchRecipes.php" method="GET">
            <label for="navRecipeSearch" class="visuallyHidden">Search:</label>
            <div>
                <input type="text" id="recipeSearch" name="recipeQuery" placeholder="Search recipes..">
                <button type="submit" value="Search"><img src="../public/images/icon/search.svg" width="20" height="20"></button>
            </div>
    </div>
    <div id="loginSignup">
        <img src="../public/images/icon/loginSignupIcon.svg" width="30" height="30" alt="Login or Signup Icon" title="Login or Signup with Culinnari">
        <a href="../public/login_signup.php">Login / Signup</a>
    </div>
</header>