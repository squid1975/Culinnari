<?php require_once('../../../../private/initialize.php');
$title = 'Manage Style | Culinnari';
include(SHARED_PATH . '/public_header.php');
require_mgmt_login();
$id = $_GET['style_id'] ?? '1';
$style = Style::find_by_id($id);
if($style === false){
    $_SESSION['message'] = 'Style not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}

$style_errors = $_SESSION['style_errors'] ?? [];
unset($_SESSION['style_errors']);


if(is_post_request()){
    
        $result = $style->delete();
        if($result === true){
            $_SESSION['message'] = 'The style was deleted successfully.';
            redirect_to(url_for('/admin/categories/index.php'));
        }
        else {
            // Handle error
            $_SESSION['message'] = 'Error deleting style.';
            redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $style->id));
        }
    

} else {
    // Display the form
    // No action needed here as we are already fetching the style details above
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
            <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
            <h2>Manage Style: <?php echo h($style->style_name); ?></h2>
            <section>
                <div class="edit">
                    <h3>Edit Style</h3>
                    <?php if (isset($style_errors['style_name'])): ?>
                        <div class="error-messages">
                        <?php foreach ($style_errors['style_name'] as $error): ?>
                            <p class="error"><?php echo h($error); ?></p>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo url_for('/admin/categories/styles/edit.php?style_id=' . $style->id);?>" method="post" id="editStyleForm">
                        <div class="formField">
                            <label for="styleName">Style Name</label>
                            <input type="text" name="style[style_name]" value="<?php echo h($style->style_name); ?>" id="styleName" maxlength="50"  pattern="^[A-Za-z\-']+( [A-Za-z\-']+)*$" required>
                        </div>
                        <div>
                            <input type="submit" name="edit" value="Update Style" class="createUpdateButton">
                        </div>
                    </form>
                </div>
            </section>

            <section>
            <div class="delete">
                <h3>Delete Style</h3>
                <p>Are you sure you want to delete this style? This will delete the style and remove it from any recipes associated with the style. <strong>This cannot be undone.</strong></p>
                <form action="<?php echo url_for('/admin/categories/styles/manage.php?style_id=' . $style->id);?>" method="post">
                    <input type="hidden" name="style[id]" value="<?php echo $style->id; ?>">
                    <div>
                        <input type="submit" name="delete" value="Delete" class="deleteButton">
                    </div>
                </form>
           </div>
            </section>
        </div>
    </div>
</main>
<script src="<?php echo url_for('/js/admin.js'); ?>" defer></script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>