<title>Management Area Home | Culinnari</title>
<?php require_once('../../private/initialize.php'); 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
?>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area - Home</h2>
    </div>
    
    <div class="wrapper">
        <div id="adminWrapper">
        <h3>Welcome <?php echo h($session->username); ?></h3>
        
            <section id="adminLinks">
                
                    <a href="<?php echo url_for('/admin/users/index.php');?>">
                        <img src="<?php echo url_for('/images/icon/users.svg');?>" width="32" height="36" alt="Users icon">
                        Users
                    </a>
                

                
                    <a href="<?php echo url_for('/admin/categories/index.php');?>">
                        <img src="<?php echo url_for('/images/icon/categories.svg');?>" width="32" height="36" alt="Categories icon">
                        Categories
                    </a>
                
            <section>
        
  
        </div>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
