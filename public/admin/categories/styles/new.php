<?php require_once('../../../../private/initialize.php');
$title = 'Manage Diet | Culinnari';
include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

if(is_post_request()){
    $args = $_POST['style'];
    $style = new Style($args);
    $result = $style->save();

    if($result === true){
        $new_id = $style->id;
        $_SESSION['message'] = 'The style was created successfully.';
        redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $style->id));
    } else {
        // Handle errors
        $style_errors = $style->errors;
        
    }
    
}
else {
    $style = new Style;
}

?>

<main role="main"  tabindex="-1">
    <div class="adminHero">
        <h2>Management Area : Style</h2>
    </div>

    <div class="wrapper">
        <div>
            &laquo;<a href="<?php echo url_for('/admin/categories/index.php');?>">Back to Categories Index</a>
        </div>
        <div class="manageCategoryWrapper">
            <h2>Create New Style</h2>
            <div class="new">
                <?php if (isset($style_errors['style_name'])): ?>
                    <div class="error-messages">
                    <?php foreach ($style_errors['style_name'] as $error): ?>
                        <p class="error"><?php echo h($error); ?></p>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo url_for('/admin/categories/styles/new.php'); ?>" method="post" id="createStyleForm">
                    <div class="formField">
                        <label for="styleName">Style Name:</label>
                        <input type="text" name="style[style_name]" value="<?php echo h($style->style_name); ?>" id="styleName" maxlength="50" pattern="^[A-Za-z\-']+( [A-Za-z\-']+)*$" required>
                    </div>
                    <div>
                        <input type="submit" name="create" value="Create" class="createUpdateButton">
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</main>
<script src="<?php echo url_for('/js/admin.js'); ?>" defer></script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>