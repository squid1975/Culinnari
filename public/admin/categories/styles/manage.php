<?php require_once('../../../../private/initialize.php');
$title = 'Manage Style | Culinnari';
include(SHARED_PATH . '/public_header.php');
require_mgmt_login();
$styleId = $_GET['style_id'] ?? '1';
$style = Style::find_by_id($styleId);
if($style === false){
    redirect_to(url_for('/admin/index.php'));
}

if(is_post_request()){
    if(isset($_POST['update'])){
        $args = $_POST['style'];
        $style->merge_attributes($args);
        $result = $style->save();
        if($result === true){
            $_SESSION['message'] = 'The style was updated successfully.';
            redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $style->id));
        }
    }
    if(isset($_POST['delete'])){
        $result = $style->delete();
        if($result === true){
            $_SESSION['message'] = 'The style was deleted successfully.';
            redirect_to(url_for('/admin/categories/index.php'));
        }
        else {
            
        }
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
    <div id="wrapper">
        <div class="manageCategoryWrapper">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/categories/index.php');?>">Back to Categories Index</a>
            </div>
            <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
            <h2>Manage Style: <?php echo h($style->style_name); ?> </h2>
            <section>
            <div class="edit">
                <h3>Edit Style</h3>
                <form action="<?php echo url_for('/admin/categories/styles/manage.php?style_id=' . $style->id);?>" method="post">
                    <div>
                        <label for="style_name">Style Name</label>
                        <input type="text" name="style[style_name]" value="<?php echo h($style->style_name); ?>" id="style_name" maxlength="50" required>
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update Style">
                    </div>
                </form>
            </div>
            </section>
            <section>
            <div class="delete">
                <h3>Delete Style</h3>
                <p>Are you sure you want to delete this style?<strong>This cannot be undone.</strong></p>
                <form action="<?php echo url_for('/admin/categories/styles/manage.php?style_id=' . $style->id);?>" method="post">
                    <input type="hidden" name="style[id]" value="<?php echo $style->id; ?>">
                    <div>
                        <input type="submit" name="delete" value="Delete Style">
                    </div>
                </form>
           </div>
            </section>
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>